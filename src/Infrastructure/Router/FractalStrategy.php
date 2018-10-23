<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Router;

use League\Fractal\Manager;
use League\Fractal\Resource\ResourceAbstract;
use League\Route\Route;
use League\Route\Strategy\JsonStrategy;
use League\Route\Strategy\StrategyInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FractalStrategy extends JsonStrategy implements StrategyInterface
{
    public function invokeRouteCallable(Route $route, ServerRequestInterface $request): ResponseInterface
    {
        $controller = $route->getCallable($this->getContainer());
        $response = $controller($request, $route->getVars());

        if ($response instanceof ResourceAbstract) {
            $body = json_encode($this->transformResourceToArray($response));
            $response = $this->responseFactory->createResponse(200);
            $response->getBody()->write($body);
        } else if ($this->isJsonEncodable($response)) {
            $body = json_encode($response);
            $response = $this->responseFactory->createResponse(200);
            $response->getBody()->write($body);
        }

        $response = $this->applyDefaultResponseHeaders($response);

        return $response;
    }

    private function transformResourceToArray(ResourceAbstract $resource): array
    {
        /** @var Manager $fractal */
        $fractal = $this->getContainer()->get('fractal');

        return $fractal->createData($resource)->toArray();
    }
}
