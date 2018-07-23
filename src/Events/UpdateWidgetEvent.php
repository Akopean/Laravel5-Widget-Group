<?php

namespace Akopean\laravel5WidgetsGroup\Events;

use Akopean\laravel5WidgetsGroup\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;


class UpdateWidgetEvent
{
    use SerializesModels;
    /** @var Widget $widget */
    public $widget;

    public $request;

    /**
     * UpdateWidgetEvent constructor.
     * @param Widget $widget
     * @param Request $request
     */
    public function __construct(Widget $widget , Request $request)
    {
        $this->widget = $widget;
        $this->request = $request;
      //  event(new UpdateWidgetEvent($widget, $data, 'Added'));
    }
}
