<?php

namespace Akopean\laravel5WidgetsGroup;

use Illuminate\Support\ServiceProvider;
use Akopean\laravel5WidgetsGroup\Providers\WidgetEventServiceProvider;
use App;
use Blade;
use Illuminate\Http\Request;

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
        App::register(WidgetEventServiceProvider::class);

        App::register(\Intervention\Image\ImageServiceProvider::class);

        App::singleton('widget', function(){
            return new \Akopean\laravel5WidgetsGroup\Widget();
        });

        App::singleton('WidgetGroup', function(){
            return new WidgetGroup();
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
