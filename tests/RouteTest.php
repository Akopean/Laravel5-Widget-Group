<?php

namespace Akopean\widgets\Tests;

class RouteTest extends TestCase
{
    protected $withDummy = true;

    public function setUp()
    {
        parent::setUp();

        $this->install();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetRoutes()
    {

        $urls = [
            route('widget.widget'),

        ];

        foreach ($urls as $url) {
            $response = $this->call('GET', $url);

            $this->assertEquals(200, $response->status(), $url.' did not return a 200');
        }
    }
}
