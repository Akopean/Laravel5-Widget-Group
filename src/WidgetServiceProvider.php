<?php

namespace Akopean\laravel5WidgetsGroup;

use Illuminate\Support\ServiceProvider;
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

        //Указываем, что файлы из папки config должны быть опубликованы при установке

        // Publish a config file
        $this->publishes([
            __DIR__ . '/../config/' => config_path() . '/'
        ], 'config');

        // Publish a views file
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/Akopean/laravel5WidgetsGroup')
        ], 'views');

        $this->publishes([
            __DIR__.'/../publishable/assets' => public_path('vendor/Akopean/laravel5WidgetsGroup/assets')
            ], 'assets');

		$this->loadViewsFrom(__DIR__.'/../resources/views', 'widgets');

        $this->loadTranslationsFrom(realpath(__DIR__.'/../publishable/lang'), 'widgets');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        Blade::directive('WidgetGroup', function ($name) {
           return "<?php app('WidgetGroup')->run($name); ?>";
        });
    }

    public function register()
    {

        App::singleton('widget', function(){
            return new \Akopean\laravel5WidgetsGroup\Widget();
        });
        $this->loadHelpers();
     }


         /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
