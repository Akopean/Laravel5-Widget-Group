<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Widgets\Core\WidgetGroup;
use Blade;

class WidgetGroupProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('WidgetGroup', function ($name) {
           return "<?php app('WidgetGroup')->run($name); ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::singleton('WidgetGroup', function(){
            return new WidgetGroup();
        });
    }
}
