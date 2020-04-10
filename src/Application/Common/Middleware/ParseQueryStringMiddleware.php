<?php declare(strict_types=1);

namespace BlueBook\Application\Common\Middleware;

use League\Fractal\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ParseQueryStringMiddleware implements MiddlewareInterface
{
    private Manager $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $query = $request->getQueryParams();

        if (isset($query['include'])) {
            $this->fractal->parseIncludes($query['include']);
        }

        return $handler->handle($request->withAttribute('includes', $this->fractal->getRequestedIncludes()));
    }
}
