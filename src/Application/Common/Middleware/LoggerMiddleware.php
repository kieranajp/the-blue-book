<?php declare(strict_types=1);

namespace BlueBook\Application\Common\Middleware;

use Ds\Vector;
use InvalidArgumentException;
use League\Route\Dispatcher;
use League\Route\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use UnderflowException;

class LoggerMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    private Stopwatch $stopwatch;

    private array $config;

    /**
     * LoggerMiddleware constructor.
     * @param LoggerInterface $logger
     * @param Stopwatch $stopwatch
     * @param array $config
     */
    public function __construct(LoggerInterface $logger, Stopwatch $stopwatch, array $config)
    {
        $this->logger = $logger;
        $this->stopwatch = $stopwatch;
        $this->config = $config;
    }

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->isDebug()) {
            $this->logger->debug('Dispatching controller action', [
                'method' => $request->getMethod(),
                'path' => (string) $request->getUri(),
            ]);
            $this->stopwatch->start('dispatch');
        }

        $routeName = $this->getRouteName($handler, $request);
        $response = $handler->handle($request);

        if ($this->isDebug()) {
            $time = $this->stopwatch->stop('dispatch');
            $this->logger->debug('Finished dispatching controller action', [
                'method' => $request->getMethod(),
                'path' => (string) $request->getUri(),
                'duration' => $time->getDuration(),
            ]);
        }

        return $response->withAddedHeader('X-Upstream', gethostname());
    }

    private function getRouteName(
        RequestHandlerInterface $handler,
        ServerRequestInterface $request
    ): string {
        if (! $handler instanceof Dispatcher) {
            return 'unknown';
        }

        try {
            $resolved = new Vector($handler->dispatch($request->getMethod(), $request->getUri()->getPath()));
            /** @var Route $route */
            /** @psalm-suppress MissingParamType */
            $route = $resolved->filter(fn($resolved): bool => $resolved instanceof Route)->first();

            return $route->getName();
        } catch (UnderflowException | InvalidArgumentException $e) {
            return 'undefined';
        }
    }

    private function isDebug(): bool
    {
        return strtolower($this->config['level']) === 'debug';
    }
}
