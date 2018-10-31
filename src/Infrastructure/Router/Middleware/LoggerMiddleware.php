<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Router\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class LoggerMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Stopwatch
     */
    private $stopwatch;

    public function __construct(LoggerInterface $logger, Stopwatch $stopwatch)
    {
        $this->logger = $logger;
        $this->stopwatch = $stopwatch;
    }

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->logger->debug('Dispatching controller action', [
            'method' => $request->getMethod(),
            'path' => (string) $request->getUri(),
        ]);

        if ($this->isDebug()) {
            $this->stopwatch->start('dispatch');
        }

        $response = $handler->handle($request);

        if ($this->isDebug()) {
            $time = $this->stopwatch->stop('dispatch');
            $this->logger->debug('Finished dispatching controller action', [
                'method' => $request->getMethod(),
                'path' => (string) $request->getUri(),
                'duration' => $time->getDuration(),
            ]);
        }

        return $response;
    }

    private function isDebug()
    {
        return strtolower(getenv('LOG_LEVEL')) === 'debug';
    }
}
