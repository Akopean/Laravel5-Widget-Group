<?php
namespace Akopean\widgets\Tests;


use Akopean\widgets\WidgetServiceProvider;
use Orchestra\Testbench\BrowserKit\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected $withDummy = true;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->install();
    }

    protected function getPackageProviders($app)
    {
        return [
            WidgetServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
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

    protected function install()
    {
        if (app()->version() >= 5.4) {
            $migrator = app('migrator');
            if (!$migrator->repositoryExists()) {
                $this->artisan('migrate:install');
            }
            $migrator->run([realpath(__DIR__.'/migrations')]);
            $this->artisan('migrate', ['--path' => realpath(__DIR__.'/migrations')]);
        }

        //app(WidgetServiceProvider::class, ['app' => $this->app]);

        if (file_exists(realpath(__DIR__.'/../routes/routes.php'))) {
            require realpath(__DIR__.'/../routes/routes.php');
        }

    }
}
