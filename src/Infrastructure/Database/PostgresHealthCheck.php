<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Database;

use Gentux\Healthz\HealthCheck;
use PDO;

class PostgresHealthCheck extends HealthCheck
{
    /**
     * @var string
     */
    protected $title = 'Database';

    /**
     * @var string
     */
    protected $description = 'Connection to the Postgres database.';

    /**
     * @var string
     */
    private $dsn;

    /**
     * PostgresHealthCheck constructor.
     *
     * @param string $dsn
     */
    public function __construct(string $dsn)
    {
        $this->dsn = $dsn;
    }

    /**
     * @inheritdoc
     */
    public function run(): void
    {
        $connection = new PDO($this->dsn);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->query('SELECT 1;');
    }
}
