<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApplicationServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        /** @var Container $container */
        $container = $this->getContainer();
    }
}
