<?php

namespace Akopean\widgets\Http\Controllers;


use Akopean\widgets\Models\Widget;
use Akopean\widgets\Rules\ExistsGroup;
use Akopean\widgets\Commands\UploadServerFileCommand;
use Akopean\widgets\Commands\DeleteServerFileCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Validator;

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
        $this->config = config('widgets');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $collection = $this->widgets->All();
        $groups = array_merge(['inactive' => 'Inactive'], $this->config['group']);

        return view('widgets::widget.browse', compact('collection', 'groups'));
    }

    /**
     * Get Widget Group
     * @param string $select_group
     * @throws \Exception
     * @return \Illuminate\View\View
     */
    public function group($select_group)
    {

        $validate = Validator::make(['group' => $select_group], [
            'group' => ['required', 'string', new ExistsGroup()],
        ]);

        if ($validate->fails()) {
            abort(404);
        }

        $collection = $this->widgets->where(['group' => $select_group])->orwhere(['group' => 'inactive'])->get();
        $groups = ['inactive' => 'Inactive', $select_group => $this->config['group'][$select_group]];

        return view('widgets::widget.browse', compact('collection', 'groups'))->with(['selected' => $select_group]);
    }

    /**
     * Update Widget Data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|integer',
            ]);

            $widget = $this->widgets->findOrFail($validatedData['id']);

            $widget->value = array_merge((array)$widget->value, $request->post());

            $widget->update();

            return response()->json($widget->toJson(), 200);

        } catch (\Exception $e) {

            return Response::json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'index' => 'required|integer',
            'group' => ['required', 'string', new ExistsGroup()],
            'name' => 'required',
        ]);

        $this->sortable($validatedData['group'], $validatedData['index']);

        $widget = $this->widgets;
        $widget->name = $validatedData['name'];
        $widget->group = $validatedData['group'];
        $widget->index = $validatedData['index'];

        $widget->save();

        return response()->json($widget->toJson(), 201);

    }

    /**
     * Delete Widget
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
        ]);

        $widget = $this->widgets->findOrFail($validatedData['id']);

        $widget->delete();

        return response()->json($widget->toJson(), 202);
    }

    /**
     * Upload File for Widget
     * @param Request $request
     * @return mixed
     */
    public function fileUpload(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|integer',
            ]);

            $widget = $this->widgets->findOrFail($validatedData['id']);

            $this->dispatch(new UploadServerFileCommand($widget, $request->all()));

            return Response::json([
                'success' => true,
            ], 201);

        } catch (\Exception $e) {

            return Response::json([
                'message' => $e->getMessage(),
                "success" => false,
            ], 400);
        }
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
                'thumbnailUrl' => isset($value['paths']['icon']['url'])
                    ? $value['paths']['icon']['url']
                    : asset('vendor/Akopean/widgets/assets/css/fine_uploader_gif/file.png'),
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
        try {
            $validatedData = $request->validate([
                'id' => 'required|integer',
                'name' => 'required|string',
            ]);

            $widget = $this->widgets->findOrFail($validatedData['id']);

            $this->dispatch(new DeleteServerFileCommand($widget, array_merge($request->all(), ['uuid' => $uuid])));

            return response()->json(['success' => 'success'], 202);

        } catch (\Exception $e) {

            return Response::json([
                'message' => $e->getMessage(),
                "success" => false,
            ], 400);
        }

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
            'group' => ['required', 'string', new ExistsGroup()],
            'oldGroup' => ['required', 'string', new ExistsGroup()],
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

        return response()->json($widget->toJson(), 202);
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

        return response()->json($widget->toJson(), 202);
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
            $widget->update();
        }
    }
}