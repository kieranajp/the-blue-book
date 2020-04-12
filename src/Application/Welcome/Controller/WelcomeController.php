<?php declare(strict_types=1);

namespace BlueBook\Application\Welcome\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class WelcomeController
{
    public function __invoke(): ResponseInterface
    {
        return new Response(200, [], json_encode([
            'application' => 'The Blue Book',
            'version' => '0.1.0',
        ]));
    }
}
