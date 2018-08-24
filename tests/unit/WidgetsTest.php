<?php

namespace Tests\Unit;

use Akopean\widgets\Tests\TestCase;
use Akopean\widgets\Widgets;

class WidgetsTest extends TestCase
{
    /**
     * A dummy widget instance.
     *
     * @var \Akopean\widgets\Models\Widget
     */
    protected $widget;
    protected $group;
    protected $config;

    public function setUp()
    {
        parent::setUp();

    }

    protected function install()
    {

    }

    /**
     * @test
     * @return void
     */
    public function can_run_routes()
    {
        Widgets::routes();
        $this->assertTrue(true);
    }

    /**
     * @test
     * @return void
     * @covers   Akopean\widgets\Widgets::formField
     */
    public function can_run_formField()
    {
        $widget = new Widgets;
        $exception = null;

        try {
            $widget->formField("TestWidget", "unique_text_id",[ "type" => "fake_type",  "title" => "Test Field"], null);
        } catch (\Exception $exception) {

        }
        $this->assertEquals($exception->getMessage(), 'Wrong data in options fields =>fake_type');
    }

}
