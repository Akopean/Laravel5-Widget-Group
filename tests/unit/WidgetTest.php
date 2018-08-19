<?php

namespace Akopean\widgets\Tests\unit;

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
    protected $group;
    protected $config;

    public function setUp()
    {
        parent::setUp();

        $this->config = config('widgets');

        $this->group = key($this->config['group']);

        $this->withFactories(__DIR__.'/../database/factories');

        $this->widget = factory(Widget::class)->create();
    }

    /** @test */
    public function can_create_widget_model()
    {
        //Create
        $widget = new Widget();

        $widget->fill([
            'name'  => key(config('widgets.widgets')),
            'group' => 'test',
            'value' => ['id' => 1, 'test' => 'test'],
            'index' => 0,
        ]);

        // Act
        $widget->save();

        // Assert
        $this->assertEquals(0, $widget->index);
        $this->assertEquals('test', $widget->group);
        $this->assertEquals(key(config('widgets.widgets')), $widget->name);
        $this->assertEquals(['id' => 1, 'test' => 'test'], $widget->value);
    }

    /** test */
    public function testCanGetOptions()
    {
        //Create
        $options = $this->widget->getOptions();

        //Assert
        $this->assertEquals("Akopean\widgets\Tests\stubs\TestWidget", $options['namespace']);
        $this->assertEquals("Test Widget", $options['placeholder']);
        $this->assertEquals(true, is_array($options['fields']));
    }

    /** test */
    public function testGetOptionsNull()
    {
        //Create
        $this->widget->name = 'Fake Name';
        $options = $this->widget->getOptions();

        //Assert
        $this->assertNull($options);
    }


    /** test */
    public function testCanGetFieldOptions()
    {
        //Create
        $options = $this->widget->getFieldOptions('Test Field');

        //Assert
        $this->assertNotNull($options);
    }

    /** test */
    public function testCanGetFieldOptionsNull()
    {
        //Create
        $options = $this->widget->getFieldOptions('faker_name');

        //Assert
        $this->assertNull($options);
    }
}
