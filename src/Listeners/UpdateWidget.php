<?php

namespace Akopean\laravel5WidgetsGroup\Listeners;

use Akopean\laravel5WidgetsGroup\Events\UpdateWidgetEvent;
use Akopean\laravel5WidgetsGroup\File;


class UpdateWidget
{
    protected $file;
    /**
     * Create the event listener.
     *
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Update Widget
     *
     * @param UpdateWidgetEvent $widget
     * @return string
     */
    public function handle(UpdateWidgetEvent $widget)
    {
        $file = [];
        $files = $widget->request->file();
        if($files) {
            $file = $this->file->upload($widget->request);
        }

        $widget->widget->value = json_encode(array_merge($widget->request->post(), $file));

        $widget->widget->save();

        return  $widget->widget->toJson();
    }
}
