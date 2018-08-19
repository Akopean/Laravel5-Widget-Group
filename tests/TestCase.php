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

        $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\Session\Middleware\StartSession');
        $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\View\Middleware\ShareErrorsFromSession');

        $this->install();
    }

    protected function getPackageProviders($app)
    {
        return [
            WidgetServiceProvider::class,
            \Arrilot\Widgets\ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Widget' => \Arrilot\Widgets\Facade::class,
            'AsyncWidget' => \Arrilot\Widgets\AsyncFacade::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function install()
    {
        if (app()->version() >= 5.4) {
            $migrator = app('migrator');
            if (!$migrator->repositoryExists()) {
                $this->artisan('migrate:install');
            }
            $migrator->run([realpath(__DIR__ . '/migrations')]);
            $this->artisan('migrate', ['--path' => realpath(__DIR__ . '/migrations')]);
        }

        //app(WidgetServiceProvider::class, ['app' => $this->app]);

        //remove all Widget in config => widgets.widgets
        config([ 'widgets.widgets' => []]);
        //add new TestWidget
        config([
            'widgets.widgets' => (require realpath(__DIR__ . '/database/dummy/configTextWidget.php')),
        ]);

        if (file_exists(realpath(__DIR__ . '/../routes/routes.php'))) {
            require realpath(__DIR__ . '/../routes/routes.php');
        }

    }
}
