<?php

namespace Akopean\laravel5WidgetsGroup\Listeners;

use Akopean\laravel5WidgetsGroup\Events\UpdateWidgetEvent;
use Akopean\laravel5WidgetsGroup\File;


class UpdateWidget
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {

    }

    /**
     * Update Widget
     * @param UpdateWidgetEvent $widget
     * @return string
     */
    public function handle(UpdateWidgetEvent $widget)
    {
       // dd(json_encode(array_merge((array)json_decode($widget->w->value),$widget->r->post())));

        $widget->widget->value = array_merge((array)$widget->widget->value,$widget->request->post());

        $widget->widget->save();

        return  $widget->widget->toJson();
    }
}
