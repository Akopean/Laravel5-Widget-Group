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

    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../database/factories');

        $this->widget = factory(Widget::class)->create();
    }

    /** @test */
    public function can_get_value_to_array()
    {
        //Create
        $this->widget->value = ['id' => 2, 'Text' => 'text'];


        // Act
        $value = $this->widget->value;

        // Assert
        $this->assertEquals(['id' => 2, 'Text' => 'text'], $value);

    }

    /** test */
    public function testCanGetOptions()
    {
        //Create
        $options = $this->widget->getOptions();

        //Assert
        $this->assertEquals("Akopean\widgets\widgets\TextWidget", $options['namespace']);
        $this->assertEquals("Text Widget", $options['placeholder']);
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
        $options = $this->widget->getFieldOptions('Text Field');

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
