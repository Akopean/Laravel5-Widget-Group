<?php

namespace Tests\Unit;

use Akopean\widgets\Commands\DeleteServerFileCommand;
use Akopean\widgets\Commands\UploadServerFileCommand;
use Akopean\widgets\Models\Widget;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Akopean\widgets\Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ServerFileCommandTest extends TestCase
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

        //config(['widgets.storage.disk' => 'file']);

        $this->withFactories(__DIR__ . '/../database/factories');

        $this->widget = factory(Widget::class)->create();
    }

    /**
     * @test
     * @return void
     */
    public function can_upload_file_dispatch()
    {
        Storage::fake($this->config['storage']['disk']);
        $widget = new Widget;

        $request = [
            'name' => 'File',
            'id' => $widget->id,
            'qquuid' => 'aa96222b-311e-4ed0-94f0-9487125392c5',
            'qqfilename' => 'file.png',
            'qqtotalfilesize' => 30856,
            'qqfile' => UploadedFile::fake()->image('./../temp/file.png')->size(100),
        ];

        Bus::dispatch(new UploadServerFileCommand($widget, $request));

        // Assert the file was stored...
        Storage::disk($this->config['storage']['disk'])->assertExists(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');
        // Assert a file does not exist...
        Storage::disk($this->config['storage']['disk'])->assertMissing('file.jpg');


        //Can Delete Server File
        $request = [
            'id' => $widget->id,
            'name' => 'File',
            'uuid' => $widget->value['File'][0]['qquuid'],
        ];

        Bus::dispatch(new DeleteServerFileCommand($widget, $request));

        Storage::disk($this->config['storage']['disk'])->assertMissing(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');

    }
}
