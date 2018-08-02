<?php

namespace Akopean\widgets;

use Illuminate\Support\ServiceProvider;
use Akopean\widgets\Providers\WidgetEventServiceProvider;
use App;
use Blade;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish a config file
        $this->publishes([
            __DIR__ . '/../config/' => config_path() . '/',
        ], 'config');

        // Publish a views file
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/Akopean/widgets'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../publishable/assets' => public_path('vendor/Akopean/widgets/assets'),
        ], 'assets');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang'),
        ], 'lang');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'widgets');

        $this->loadTranslationsFrom(realpath(__DIR__ . '/../resources/lang'), 'widgets');

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        Blade::directive('WidgetGroup', function ($name) {
            return "<?php app('WidgetGroup')->run($name); ?>";
        });
    }

    public function register()
    {
        App::register(WidgetEventServiceProvider::class);

        App::register(\Intervention\Image\ImageServiceProvider::class);

        App::singleton('widget', function () {
            return new \Akopean\widgets\Widget();
        });

        App::singleton('WidgetGroup', function () {
            return new WidgetGroup();
        });

        $this->loadHelpers();
    }


    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
