<?php

namespace Akopean\widgets\Events;

use Akopean\widgets\Models\Widget;
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
    }
}
