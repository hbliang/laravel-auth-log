<?php

namespace Hbliang\AuthLog\Tests;

use CreateAuthLogTable;
use Hbliang\AuthLog\AuthLogServierProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [AuthLogServierProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function setUpDatabase()
    {
        $this->loadLaravelMigrations(); // load laravel users table
        $this->createAuthLogTable();
    }

    protected function createAuthLogTable()
    {
        include_once __DIR__.'/../database/migrations/create_auth_log_table.php.stub';
        (new CreateAuthLogTable())->up();
    }
}
