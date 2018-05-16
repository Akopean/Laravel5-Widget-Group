<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Widget;
use Illuminate\Http\Request;
use App\Services\WidgetService;
use TCG\Voyager\Facades\Voyager;
use Response;

class WidgetController extends Controller
{
    protected $config;
    protected $widgets;

    /**
     * WidgetController constructor.
     */
    public function __construct()
    {
        $widgets = Widget::all();
    }

    public function index(Request $request)
    {
        return Voyager::view('voyager::widgets.browse',['widgets' => $this->widgets]);
    }

    public function asd(Request $request)
    {
      /*  $validator = \Validator::make($request->all(), [
            'widget' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $this->widget = new WidgetService($request['widget']);

        if($this->widget->hasErrors()) {
            return response()->json($this->widget->getErrors());
        }

        return response()->json($this->widget->getField());*/
      return "asdad";
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'value' => 'json'
        ]);

        $widget =  Widget::findOrFail($validatedData['id']);

        $widget->value =  $request->input('value');

        $widget->save();

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
        $validatedData = $request->validate([
            'index' => 'required|integer',
            'group' => 'required',
            'name'  => 'required'
        ]);

        $this->sortable($validatedData['group'], $validatedData['index']);

        $widget = new Widget();
        $widget->name  = $validatedData['name'];
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
            'index'     => 'required|integer',
            'oldIndex'  => 'required|integer',
            'group'     => 'required|string',
            'oldGroup'  => 'required|string',
            'name'      => 'required|string',
        ]);
        $widget = Widget::where('group', 'like', $validatedData['oldGroup'])->where('index', '=', $validatedData['oldIndex'])->firstOrFail();

        $widget->index = $validatedData['index'];
        $widget->group = $validatedData['group'];

        $this->sortable($validatedData['group'], $validatedData['index']);

        $widget->save();

        if($validatedData['oldGroup'] !== 0) {
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
            'index'     => 'required|integer',
            'group'     => 'required',
            'name'      => 'required',
            'oldIndex'  => 'required'
        ]);
        $widget = Widget::where('group', 'like', $validatedData['group'])->where('index', '=', $validatedData['oldIndex'])->firstOrFail();

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
        $widgets = Widget::where('group', 'like', $group)->where('index', '!=', $oldIndex)->orderBy('index', 'ASC')->get();

        foreach ($widgets as $widget)
        {
            if($index == $sortIndex){
                $sortIndex++;
            }
            $widget->index = $sortIndex++;
            $widget->save();
        }
    }
}