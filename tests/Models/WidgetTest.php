<?php

namespace Akopean\widgets\Tests;

use Akopean\widgets\models\Widget;

class WidgetTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->install();
    }

    /** @test */
    public function can_create_a_widget()
    {

        $widget = new Widget();

        $widget->name = 'Test Title';
        $widget->group = 'test-group';
        $widget->value = json_encode(['id' => 2, 'Text' => 'text']);
        $widget->index = 2;

        // Act
        $widget->update();

        // Assert
        $this->assertEquals('test-group', $widget->group);
        $this->assertEquals('Test Title', $widget->name);

        $this->assertEquals(json_encode(['id' => 2, 'Text' => 'text']), $widget->value);
        $this->assertEquals(2, $widget->index);
    }
}
