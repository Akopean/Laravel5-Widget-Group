<?php

namespace Akopean\laravel5WidgetsGroup\Widgets;

use Akopean\laravel5WidgetsGroup\AbstractWidget;

class TextWidget extends AbstractWidget
{
    //Widget  Fields
    protected $title;
    protected $body;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->title = isset($config['title']) ? $config['title'] : '';
        $this->body  =  isset($config['body']) ? $config['body'] : '';
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return view('widgets::widgets.text_widget', [
            'title' => $this->title,
            'body'  => $this->body
        ]);
    }

}