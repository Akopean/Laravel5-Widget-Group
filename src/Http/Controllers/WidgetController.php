<?php

namespace Akopean\widgets\Http\Controllers;

use Akopean\widgets\Events\UpdateWidgetEvent;
use Akopean\widgets\FineUploaderServer;
use Akopean\widgets\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class WidgetController extends Controller
{
    protected $config;
    protected $widgets;
    protected $file;

    /**
     * @param Widget $widgets
     * WidgetController constructor.
     */
    public function __construct(Widget $widgets)
    {

        $this->widgets = $widgets;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $group = null)
    {
        $query = null;

        if (!$group) {
            $query = $this->widgets;
        } else {
            $query  = $this->widgets->where(['group' => $group])->where(['group' => 'inactive']);
        }
        $collection =  $query->get();

        return view('widgets::widget.browse', ['collection' => $collection]);
    }

    /**
     * Update Widget Data
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $widget = $this->widgets->findOrFail($request->post()['id']);

        return event(new UpdateWidgetEvent($widget, $request));
    }


    /**
     * Delete Widget
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $widget = $this->widgets->findOrFail($request->all()['id']);
        $widget->delete();

        return $widget->toJson();
    }

    /**
     * Upload File for Widget
     * @param Request $request
     * @return mixed
     */
    public function fileUpload(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
        ]);

        $widget = $this->widgets->findOrFail($validatedData['id']);

        $file = Input::all();
        $this->file = new FineUploaderServer($widget);

        $this->file->upload($file);

        return Response::json([
            'error' => false,
            'code' => 200,
            'success' => 'success',
        ], 200);
    }

    /**
     * Get Last Widget File Session
     * @param Request $request
     * @return mixed
     */
    public function fileSession(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
        ]);

        $response = [];
        $name = $validatedData['name'];
        $widget = $this->widgets->findOrFail($validatedData['id']);
        $value = $widget['value'];

        //if no has data or no  has images
        if (!$value || !array_key_exists($name, $value)) {
            return $response;
        }

        foreach ($value[$name] as $key => $value) {
            $response[] = [
              //  'id' =>  $this->widget->id,
                'name' => $value['qqfilename'],
                'size' => $value['qqtotalfilessize'],
                'url' => $value['paths']['original']['url'],
                'thumbnailUrl' => isset($value['paths']['icon']['url']) ? $value['paths']['icon']['url'] : '',
                'uuid' => $value['qquuid'],
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function fileDelete(Request $request, $uuid)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string'
        ]);

        $widget = $this->widgets->findOrFail($validatedData['id']);
        $data = $widget->value;

        $id = null;
        $file_data = null;

        if (isset($data[$validatedData['name']])) {
            foreach ($data[$validatedData['name']] as $key => $value) {
                if ($value['qquuid'] === $uuid) {
                    $file_data = array_splice($data[$validatedData['name']], $key,1)[0];
                    break;
                }

            }
        }
        $widget->value = $data;

        if(Storage::disk(config('widgets.storage.disk', 'public'))->has(($file_data['paths']['original']['path'])))
        {
            Storage::disk(config('widgets.storage.disk', 'public'))->delete($file_data['paths']['original']['path']);
        }

        if(isset($file_data['paths']['icon']) && Storage::disk(config('widgets.storage.disk', 'public'))->has(($file_data['paths']['icon']['path'])))
        {
            Storage::disk(config('widgets.storage.disk', 'public'))->delete($file_data['paths']['icon']['path']);
        }

        $widget->update();
        return response()->json(['success' => 'success'], 200);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'index' => 'required|integer',
            'group' => 'required',
            'name' => 'required',
        ]);

        $this->sortable($validatedData['group'], $validatedData['index']);

        $widget = $this->widgets;
        $widget->name = $validatedData['name'];
        $widget->group = $validatedData['group'];
        $widget->index = $validatedData['index'];

        $widget->save();

        return $widget->toJson();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function drag(Request $request)
    {
        $validatedData = $request->validate([
            'index' => 'required|integer',
            'oldIndex' => 'required|integer',
            'group' => 'required|string',
            'oldGroup' => 'required|string',
            'name' => 'required|string',
        ]);

        $widget = $this->widgets->where('group', 'like', $validatedData['oldGroup'])->where('index', '=',
            $validatedData['oldIndex'])->firstOrFail();

        $widget->index = $validatedData['index'];
        $widget->group = $validatedData['group'];

        $this->sortable($validatedData['group'], $validatedData['index']);

        $widget->save();

        if ($validatedData['oldGroup'] !== 0) {
            $this->sortable($validatedData['oldGroup']);
        }

        return $widget->toJson();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sort(Request $request)
    {
        $validatedData = $request->validate([
            'index' => 'required|integer',
            'group' => 'required',
            'name' => 'required',
            'oldIndex' => 'required',
        ]);

        $widget = $this->widgets->where('group', 'like', $validatedData['group'])->where('index', '=',
            $validatedData['oldIndex'])->firstOrFail();

        $widget->index = $validatedData['index'];

        $this->sortable($validatedData['group'], $validatedData['index'], $validatedData['oldIndex']);

        $widget->save();

        return $widget->toJson();
    }

    /**
     * Sorting a group of widgets by index
     * Сортируем группу виджетов по индексу
     * @param $group
     * @param $index
     * @param null $oldIndex
     */
    protected function sortable($group, $index = -1, $oldIndex = null)
    {
        $sortIndex = 0;
        $widgets = $this->widgets->where('group', 'like', $group)->where('index', '!=', $oldIndex)->orderBy('index',
            'ASC')->get();

        foreach ($widgets as $widget) {
            if ($index == $sortIndex) {
                $sortIndex++;
            }
            $widget->index = $sortIndex++;
            $widget->save();
        }
    }
}