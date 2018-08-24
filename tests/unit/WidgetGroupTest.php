<?php

namespace Tests\Unit;

use Akopean\widgets\FineUploaderServer;
use Akopean\widgets\Models\Widget;
use Akopean\widgets\Tests\TestCase;
use Akopean\widgets\WidgetGroup;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class WidgetGroupTest extends TestCase
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

        $this->config = config('widgets');

        $this->group = key($this->config['group']);

        $this->withFactories(__DIR__ . '/../database/factories');

        $this->widget = factory(Widget::class)->create();

    }

    /**
     * @test
     * @return void
     */
    public function can_run()
    {
        $widgetGroup = new WidgetGroup();
        $this->assertNull($widgetGroup->run('fake_widgetzone'));

        $this->assertNotNull(array_keys($this->config['group'])[0]);
    }

}
