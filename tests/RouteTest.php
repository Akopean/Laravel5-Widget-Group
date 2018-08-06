<?php

namespace Akopean\widgets\Tests;

use Akopean\widgets\Models\Widget;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RouteTest extends TestCase
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
        config(['widgets.storage.disk' => 'file']);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetRoutes()
    {
        $urls = [
            ['url' => route('widget.widget'), 'method' => 'GET'],
            [
                'url' => route('widget.widget.create',
                    [
                        'group' => "leftSidebar",
                        'index' => 0,
                        'name' => "TextWidget",
                    ]),
                'method' => 'POST',
            ],
            [
                'url' => route('widget.widget.sort',
                    [
                        'group' => "leftSidebar",
                        'index' => 1,
                        'name' => "TextWidget",
                        'oldIndex' => 0,
                    ]),
                'method' => 'POST',
            ],
            [
                'url' => route('widget.widget.drag', [
                    'group' => 'footer',
                    'index' => 0,
                    'name' => 'TextWidget',
                    'oldGroup' => 'leftSidebar',
                    'oldIndex' => 1,
                ]),
                'method' => 'POST',
            ],
            ['url' => route('widget.widget.delete', ['id' => 1]), 'method' => 'POST'],
        ];

        foreach ($urls as $url) {
            $response = $this->call($url['method'], $url['url']);

            $this->assertEquals(200, $response->status(), $url['url'] . ' did not return a 200');
        }
    }

    /** test */
    public function testManipulateFileRoutes()
    {
        Storage::fake('file');

        $widget = new Widget([
            'name' => 'TextWidget',
            'group' => 'test-group',
            'value' => ['id' => 2, 'Text' => 'text'],
            'index' => 2,
        ]);
        $widget->save();

        $fileUpload = $this->call('POST', route('widget.widget.fileUpload'), [
            'name' => 'File',
            'id' => $widget->id,
            'qquuid' => 'aa96222b-311e-4ed0-94f0-9487125392c5',
            'qqfilename' => 'file.png',
            'qqtotalfilesize' => 30856,
            'qqfile' => UploadedFile::fake()->image(realpath(__DIR__ . '/temp/file.png')),
        ]);

        $this->assertResponseStatus($fileUpload->status());

        Storage::disk('file')->assertExists(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');

        // Assert a file does not exist...
        Storage::disk('file')->assertMissing('missing.jpg');


        $fileSession = $this->call('GET', route('widget.widget.fileSession'), [
            'id' => $widget->id,
            'name' => 'File',
        ]);

        $this->assertResponseStatus($fileSession->status());

        $widget_delete = Widget::find($widget->id);

        $fileSession = $this->call('delete', route('widget.widget.fileDelete',  ['uuid' => $widget_delete->value['File'][0]['qquuid']]), [
            'id' => $widget->id,
            'name' => 'File',
        ]);

        $this->assertResponseStatus($fileSession->status());

        Storage::disk('file')->assertMissing(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');
    }
}
