<?php

namespace Akopean\widgets\Tests;

use Akopean\widgets\Commands\UploadServerFile;
use Akopean\widgets\Models\Widget;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class RouteTest extends TestCase
{

    /**
     * A dummy widget instance.
     *
     * @var \Akopean\widgets\Models\Widget
     */
    protected $widget;
    protected $group;
    protected $config;

    // Метод setUpBeforeClass() выполняется только раз перед созданием объекта тестирующего класса.
    public static function setUpBeforeClass()
    {

    }

    public function setUp()
    {
        parent::setUp();

        $this->config = config('widgets');

        $this->group = key($this->config['group']);

        //config(['widgets.storage.disk' => 'file']);

        $this->withFactories(__DIR__ . '/database/factories');

        $this->widget = factory(Widget::class)->create();
    }

    /**
     * @test
     * @return void
     */
    public function can_route_index()
    {
        $http_widget = $this->call('GET', route('widget.widget'));

        $this->assertEquals(200, $http_widget->status(), route('widget.widget') . ' did not return a 200');

        $http_widget_group = $this->call('GET', route('widget.widget'), ['group' => $this->group]);

        $this->assertEquals(200, $http_widget_group->status(),
            route('widget.widget') . '/' . $this->group . ' did not return a 200');
    }

    /**
     * @test
     * @return void
     */
    public function can_route_create()
    {
        $http_widget_create = $this->call('POST', route('widget.widget.create'), [
            'group' => $this->group,
            'index' => 1,
            'name' => key($this->config['widgets']),
        ]);

        $this->assertEquals(201, $http_widget_create->status(),
            route('widget.widget.create') . ' did not return a 201');

        // missing call params   index, name, group
        $this->call('POST', route('widget.widget.create'));

        $this->assertSessionHasErrors(['group', 'name', 'index']);
    }

    /**
     * @test
     * @return void
     */
    public function can_route_update()
    {
        $http_widget_update = $this->call('POST', route('widget.widget.update'), ['id' => 1]);

        $this->assertEquals(200, $http_widget_update->status(),
            route('widget.widget.update') . ' did not return a 200');
    }

    /**
     * @test
     * @return void
     */
    public function can_route_delete()
    {
        $http_widget_delete = $this->call('POST', route('widget.widget.delete'), ['id' => 1]);

        $this->assertEquals(202, $http_widget_delete->status(),
            route('widget.widget.delete') . ' did not return a 202');

        // missing call params   index, name, group
        $this->call('POST', route('widget.widget.delete'));

        $this->assertSessionHasErrors(['id']);
    }

    /**
     * @test
     * @return void
     */
    public function can_route_sort()
    {
        $widget = factory(Widget::class)->create([
            'index' => 1,
        ]);

        $oldIndex = $widget->index;
        $newIndex = 0;
        $http_widget_sort = $this->call('POST', route('widget.widget.sort'),
            [
                'name' => key($this->config['widgets']),
                'group' => $this->group,
                'index' => $newIndex,
                'oldIndex' => $oldIndex,
            ]);


        $this->assertEquals(202, $http_widget_sort->status(),
            route('widget.widget.sort') . ' did not return a 202');

        $sortWidget = Widget::find($widget->id);

        $this->assertEquals($newIndex, $sortWidget->index, 'did not sorting');


        // missing call params   index, name, group
        $this->call('POST', route('widget.widget.sort'));

        $this->assertSessionHasErrors(['group', 'name', 'oldIndex', 'index']);
    }

    /**
     * @test
     * @return void
     */
    public function can_route_drag()
    {
        $widget = factory(Widget::class)->create([
            'index' => 1,
        ]);

        $newGroup = key($this->config['inactive_group']);

        $http_widget_drag = $this->call('POST', route('widget.widget.drag'),
            [
                'name' => key($this->config['widgets']),
                'group' => $newGroup,
                'oldGroup' => $this->group,
                'index' => 0,
                'oldIndex' => 1,
            ]);


        $this->assertEquals(202, $http_widget_drag->status(),
            route('widget.widget.drag') . ' did not return a 202');


        $dragWidget = Widget::find($widget->id);

        $this->assertEquals($newGroup, $dragWidget->group, 'did not dragging');


        // missing call params   index, name, group
        $this->call('POST', route('widget.widget.drag'));

        $this->assertSessionHasErrors(['group', 'name', 'index', 'oldGroup', 'oldIndex']);
    }

    /**
     * @test
     * @return void
     */
    public function can_route_file_upload()
    {
        Storage::fake('file');
        Bus::fake();

        $widget = $this->widget;


        $fileUpload = $this->call('POST', route('widget.widget.fileUpload'), [
            'name' => 'File',
            'id' => $widget->id,
            'qquuid' => 'aa96222b-311e-4ed0-94f0-9487125392c5',
            'qqfilename' => 'file.png',
            'qqtotalfilesize' => 30856,
            'qqfile' => 'dfgsdf',
        ]);

        $this->assertEquals(201, $fileUpload->status(),
            route('widget.widget.fileUpload') . ' did not return a 201');
    }

    /**
     * @test
     * @return void
     */
    public function can_route_file_delete()
    {
        Storage::fake('file');
        Bus::fake();

        $widget = $this->widget;



        $fileDelete = $this->call('delete',
            route('widget.widget.fileDelete', ['uuid' => 'test']), [
                'id' => $widget->id,
                'name' => 'File',
            ]);

        $this->assertEquals(202, $fileDelete->status(),
            route('widget.widget.fileDelete', ['uuid' => 'test']) . ' did not return a 202');
    }

    /**
     * @test
     * @return void
     */
    public function can_route_file_session()
    {
        $widget = $this->widget;

        $fileSession = $this->call('GET', route('widget.widget.fileSession'), [
            'id' => $widget->id,
            'name' => 'File',
        ]);

        // Assert response status
        $this->assertEquals(200, $fileSession->status(),
            route('widget.widget.fileSession') . ' did not return a 200');
    }

}



/*    Storage::fake('file');
        Bus::fake();

        $widget = $this->widget;



        $fileUpload = $this->call('POST', route('widget.widget.fileUpload'), [
            'name' => 'File',
            'id' => $widget->id,
            'qquuid' => 'aa96222b-311e-4ed0-94f0-9487125392c5',
            'qqfilename' => 'file.png',
            'qqtotalfilesize' => 30856,
            'qqfile' => 'dfgsdf',
        ]);

        Bus::assertDispatched(UploadServerFile::class, function () {
            return true;
        });

        $this->assertResponseStatus($fileUpload->status());

         // Assert a file exist
        //  Storage::disk('file')->assertExists(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');

         // Assert a file does not exist
         Storage::disk('file')->assertMissing('missing.jpg');


         $fileSession = $this->call('GET', route('widget.widget.fileSession'), [
             'id' => $widget->id,
             'name' => 'File',
         ]);
         // Assert response status
         $this->assertResponseStatus($fileSession->status());

         $widget_delete = Widget::find($widget->id);

         $fileSession = $this->call('delete',
             route('widget.widget.fileDelete', ['uuid' => $widget_delete->value['File'][0]['qquuid']]), [
                 'id' => $widget->id,
                 'name' => 'File',
             ]);

         $this->assertResponseStatus($fileSession->status());

         Storage::disk('file')->assertMissing(config('widgets.storage.slug') . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . 'file.png');*/