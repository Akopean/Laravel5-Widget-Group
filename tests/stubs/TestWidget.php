<?php

namespace Akopean\widgets\Tests\stubs;

use Akopean\widgets\AbstractWidget;

class TestWidget extends AbstractWidget
{
    //Widget Data
    protected $data;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return view('widgets::widgets.text_widget', [
            'data' => []
        ]);
    }

}