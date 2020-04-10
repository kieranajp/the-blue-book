<?php declare(strict_types=1);

namespace BlueBook\Application\HealthCheck\Controller;

use Gentux\Healthz\HealthResult;
use Gentux\Healthz\Healthz;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

class HealthCheckController
{
    private Healthz $healthcheck;

    public function __construct(Healthz $healthcheck)
    {
        $this->healthcheck = $healthcheck;
    }

    public function __invoke(): ResponseInterface
    {
        $results = $this->healthcheck->run();

        $statusCode = $results->hasFailures() ? 503 : ($results->hasWarnings() ? 503 : 200);
        $body = array_map(function (HealthResult $result): array {
            return [
                'title'  => $result->title(),
                'description' => $result->description(),
                'status' => $result->failed() ? 'Failed' : 'OK',
            ];
        }, $results->all());

        return new JsonResponse(
            $body,
            $statusCode
        );
    }
}
