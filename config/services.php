<?php declare(strict_types=1);

use BlueBook\Infrastructure\ServiceProvider\ApplicationServiceProvider;
use BlueBook\Infrastructure\ServiceProvider\DatabaseServiceProvider;
use Ds\Vector;
use BlueBook\Infrastructure\ServiceProvider\InfrastructureServiceProvider;

return new Vector([
    ApplicationServiceProvider::class,
    DatabaseServiceProvider::class,
    InfrastructureServiceProvider::class
]);
