<?php

namespace Akopean\widgets\test\features;

use Akopean\widgets\Models\Widget;
use Akopean\widgets\Tests\TestCase;

class WidgetTest extends TestCase
{
    /**
     * A dummy widget instance.
     *
     * @var \Akopean\widgets\Models\Widget
     */
    protected $widget;

    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../database/factories');

        $this->widget = factory(Widget::class)->create([
            'name' => 'TextWidget',
            'group' => 'test-group',
            'value' => ['id' => 2, 'Text' => 'text'],
            'index' => 2,
        ]);
    }

    /** @test */
    public function can_create_a_widget()
    {
        $this->widget->save();

        $widget = $this->widget;

        // Act
        $assert = Widget::find($widget->id);

        // Assert

        $this->assertEquals('TextWidget', $assert->name);
        $this->assertEquals('test-group', $assert->group);
        $this->assertEquals(['id' => 2, 'Text' => 'text'], $assert->value);
        $this->assertEquals(2, $assert->index);
    }
}
