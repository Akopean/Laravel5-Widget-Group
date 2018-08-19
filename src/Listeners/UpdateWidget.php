<?php

namespace Akopean\widgets\Listeners;

use Akopean\widgets\Events\UpdateWidgetEvent;
use Akopean\widgets\File;
use Illuminate\Http\Response;


class UpdateWidget
{
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

        return response()->json($widget->widget->toJson(), 200);
    }
}
