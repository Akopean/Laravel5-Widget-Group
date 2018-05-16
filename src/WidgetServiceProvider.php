<?php

namespace Akopean\Widgets;

use Illuminate\Support\ServiceProvider;
use App;
use Blade;


class WidgetServiceProvider extends ServiceProvider
{

 
    public function register()
    {

        App::singleton('widget', function(){
            return new \Akopean\Widgets\Widget();
        });

     }
}