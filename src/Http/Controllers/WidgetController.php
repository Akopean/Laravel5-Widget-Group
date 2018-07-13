<?php

namespace Akopean\laravel5WidgetsGroup\Http\Controllers;


use Akopean\laravel5WidgetsGroup\Events\UpdateWidgetEvent;
use Akopean\laravel5WidgetsGroup\Repository\FileRepository;
use App\Http\Controllers\Controller;
use Akopean\laravel5WidgetsGroup\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;


class WidgetController extends Controller
{
    protected $config;
    protected $widgets;
    protected $file;

    /**
     * WidgetController constructor.
     * @param FileRepository $fileRepository
     */
    public function __construct(FileRepository $fileRepository)
    {
        $this->file = $fileRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('widgets::widget.browse', ['widgets' => $this->widgets]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $widget = Widget::findOrFail($request->post()['id']);

        return event(new UpdateWidgetEvent($widget, $request));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function fileUpload(Request $request)
    {
        return '{"success":true}';


        $validatedData = $request->validate([
            'id' => 'required|integer',
        ]);

        $widget = Widget::findOrFail($validatedData['id']);

        $file = Input::all();
        unset($file['id']);

        if (!count($file)) {
            return Response::json([
                'error' => true,
                'message' => 'Server error while uploading',
                'code' => 500,
            ], 500);
        }

        $response = $this->file->upload($file, $widget);

        return $response;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function fileDelete(Request $request, $uuid)
    {
        return response()->json(['success' => 'success'], 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $id = $request->all()['id'];

        $widget = Widget::findOrFail($id);
        $widget->delete();

        return $widget->toJson();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    /*   public function store(Request $request)
       {
           $id = $request->all()['id'];

           $widget =  Widget::findOrFail($id);
           $widget->name  = 'Text';
           $widget->group = 'leftSidebar';
           $widget->value =  json_encode($request->all());

           $widget->update();

           return $widget->toJson();
       }
   */
    /**
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        // return abort(500, 'Unauthorized action.');
        $validatedData = $request->validate([
            'index' => 'required|integer',
            'group' => 'required',
            'name' => 'required',
        ]);

        $this->sortable($validatedData['group'], $validatedData['index']);

        $widget = new Widget();
        $widget->name = $validatedData['name'];
        $widget->group = $validatedData['group'];
        $widget->index = $validatedData['index'];

        $widget->save();

        return $widget->toJson();
        //return Response::json($$validatedData->errors(), 500);
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
        $widget = Widget::where('group', 'like', $validatedData['oldGroup'])->where('index', '=',
            $validatedData['oldIndex'])->firstOrFail();

        $widget->index = $validatedData['index'];
        $widget->group = $validatedData['group'];

        $this->sortable($validatedData['group'], $validatedData['index']);

        $widget->save();

        if ($validatedData['oldGroup'] !== 0) {
            $this->sortable($validatedData['oldGroup']);
        }

        return $widget->toJson();
        //return Response::json($$validatedData->errors(), 500);
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
        $widget = Widget::where('group', 'like', $validatedData['group'])->where('index', '=',
            $validatedData['oldIndex'])->firstOrFail();

        $widget->index = $validatedData['index'];

        $this->sortable($validatedData['group'], $validatedData['index'], $validatedData['oldIndex']);

        $widget->save();

        return $widget->toJson();
        //return Response::json($$validatedData->errors(), 500);
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
        $widgets = Widget::where('group', 'like', $group)->where('index', '!=', $oldIndex)->orderBy('index',
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