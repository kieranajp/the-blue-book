<?php declare(strict_types=1);

namespace BlueBook\Application\Common\Middleware;

use Throwable;
use JsonException;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use League\Route\Http\Exception\HttpExceptionInterface;

class ErrorHandlingMiddleware implements MiddlewareInterface
{
    private ResponseFactoryInterface $responseFactory;

    private LoggerInterface $log;

    public function __construct(ResponseFactoryInterface $responseFactory, LoggerInterface $log)
    {
        $this->responseFactory = $responseFactory;
        $this->log = $log;
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (Throwable $exception) {
            $code = $this->getResponseCode($exception);
            $response = $this->responseFactory->createResponse($code);
            $response->getBody()->write(json_encode($this->getResponseBody($code, $exception)));
            $this->log->error($exception->getMessage(), $exception->getTrace());
        }

        return $response;
    }

    private function getResponseCode(Throwable $exception): int
    {
        switch (true) {
            case $exception instanceof HttpExceptionInterface:
                return $exception->getStatusCode();
            case $exception instanceof JsonException:
                return 400;
            default:
                return 500;
        }
    }

    private function getResponseBody(int $status, Throwable $exception): array
    {
        $body = [
            'status_code' => $status,
            'reason_phrase' => $status >= 500 ? 'Internal server error' : $exception->getMessage(),
        ];

        if (getenv('APP_ENV') === 'local') {
            $body['message'] = $exception->getMessage();
            $body['stack_trace'] = $exception->getTrace();
        }

        return $body;
    }
}
