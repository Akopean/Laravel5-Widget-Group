<?php

namespace Akopean\laravel5WidgetsGroup\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class WidgetEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Akopean\laravel5WidgetsGroup\Events\UpdateWidgetEvent' => [
            'Akopean\laravel5WidgetsGroup\Listeners\UpdateWidget'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
