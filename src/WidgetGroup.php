<?php

namespace Akopean\laravel5WidgetsGroup;

use Akopean\laravel5WidgetsGroup\Models\Widget as Widgets;
use Widget;

class WidgetGroup
{
    protected $widget, $group, $db, $config;


    public function __construct(){
        $this->config = config('widgets');

        $this->group = $this->config['group'];
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     * @param $widget_zone
     */
    public function run($widget_zone)
    {
        if (!array_key_exists($widget_zone, $this->group)){
            return;
        }

        $widgets = Widgets::where(['group' => $widget_zone])->get();

        foreach ($widgets as $widget){
            $value = json_decode($widget['value']);
            if (!empty($value) && !is_null($value)){
                Widget::group($widget_zone)->addWidget($this->config['widgets'][$widget->name]['namespace'], $value);
            }
        }
        echo Widget::group($widget_zone)->display();
    }
}