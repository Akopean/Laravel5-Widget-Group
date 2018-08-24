<?php

namespace Tests\Unit;

use Akopean\widgets\FineUploaderServer;
use Akopean\widgets\Models\Widget;
use Akopean\widgets\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FineUploadServerTest extends TestCase
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
    public function can_upload_file()
    {
        Storage::fake($this->config['storage']['disk']);

        $request = [
            'name' => 'Image',
            'id' => $this->widget->id,
            'qquuid' => 'aa96222b-311e-4ed0-94f0-9487125392c5',
            'qqfilename' => 'file.png',
            'qqtotalfilesize' => 30856,
            'qqfile' => UploadedFile::fake()->image('./../temp/file.png')->size(100),
        ];

        $upload = new FineUploaderServer($this->widget);

        $upload->upload($request, $this->config['storage']['disk'],$this->config['storage']['slug']);

        // Assert the file was stored...
        Storage::disk($this->config['storage']['disk'])->assertExists(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');

        //Assert widget file name  file.png
        $this->assertEquals($this->widget->value['Image'][0]['qqfilename'],'file.png');

        //upload duplicate file.png
        $upload->upload($request, $this->config['storage']['disk'],$this->config['storage']['slug']);
        //Assert its widget file name not file.png
        $this->assertNotEquals($this->widget->value['Image'][1]['qqfilename'],'file.png');

        //Delete widget file.png
        $upload->delete($this->widget->value['Image'][0], $this->config['storage']['disk']);

        //Assert is missing file
        Storage::disk($this->config['storage']['disk'])->assertMissing(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');

        $upload->delete($this->widget->value['Image'][0], $this->config['storage']['disk']);
    }

    /**
     * @test
     * @expectedException \Exception
     * @return void
     */
    public function can_not_upload_file()
    {
        Storage::fake($this->config['storage']['disk']);

        $request = [
            'name' => 'Image',
            'id' => $this->widget->id,
            'qquuid' => 'aa96222b-311e-4ed0-94f0-9487125392c5',
            'qqfilename' => 'file.png',
            'qqtotalfilesize' => 30856,
            'qqfile' => UploadedFile::fake()->image('./../temp/fake.fake'),
        ];

        $upload = new FineUploaderServer($this->widget);


        $upload->upload($request, $this->config['storage']['disk'],$this->config['storage']['slug']);

     }

    /**
     * @test
     * @return void
     */
    public function can_upload_file_if_field_no_have_rules()
    {
        Storage::fake($this->config['storage']['disk']);

        $request = [
            'name' => 'File',
            'id' => $this->widget->id,
            'qquuid' => 'aa96222b-311e-4ed0-94f0-9487125392c5',
            'qqfilename' => 'file.png',
            'qqtotalfilesize' => 30856,
            'qqfile' => UploadedFile::fake()->image('./../temp/file.png')->size(100),
        ];

        $upload = new FineUploaderServer($this->widget);

        $upload->upload($request, $this->config['storage']['disk'],$this->config['storage']['slug']);

        // Assert the file was stored...
        Storage::disk($this->config['storage']['disk'])->assertExists(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');
    }
}
