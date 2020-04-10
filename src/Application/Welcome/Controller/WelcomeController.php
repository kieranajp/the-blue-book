<?php declare(strict_types=1);

namespace BlueBook\Application\Welcome\Controller;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

class WelcomeController
{
    public function __invoke(): ResponseInterface
    {
        return new JsonResponse([
            'application' => 'The Blue Book',
            'version' => '0.1.0',
        ]);
    }
}
