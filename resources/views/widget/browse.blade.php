@extends('widgets::layouts.app')

@section('page_title', ' Widgets')

@section('css')
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ widgets_asset('css/app.css') }}">
@stop

@section('page_header')
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title text-center">
                Widgets
            </h1>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget-holder">
                            <div class="sidebar-description">
                                <h3>{{ _t('widget.available', 'Available Widgets') }}</h3>
                                <p class="description">{{ _t('widget.available-desc', 'To activate a widget drag it to a sidebar or click on it. To deactivate a widget and delete its settings, drag it back.') }}
                                </p>
                            </div>
                            <div class="widget-list">
                                <div id="left" data-group="left">
                                    @foreach(config('widgets')['widgets'] as $widget => $value)
                                        @include('widgets::widget.widget', ['widget' => null, 'name' => $widget, 'value' => config('widgets')['widgets'][$widget]])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="sidebar-description">
                            <h3>{{ _t('widget.inactive', 'Inactive Widgets') }}</h3>
                            <p class="description">{{ _t('widget.inactive-desc', 'Drag widgets here to remove them from the sidebar but keep their settings.') }}</p>
                        </div>
                        <div class="widget-list">
                            <div class="widget-inactive">
                                <div class="widget-inner" data-group="inactive" id="inactive"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    @foreach(config('widgets')['group'] as $group => $value)
                        @if($group === 'inactive')
                            @continue
                        @endif
                        <div class="col-md-6">
                            <h3> {{ $value }} </h3>
                            <div class="widget-inner" data-group="{{ $group }}" id="{{ $group }}">
                                @foreach(\Akopean\laravel5WidgetsGroup\Models\Widget::where('group', '=', $group)->orderBy('index', 'ASC')->get() as $widget)
                                    @include('widgets::widget.widget', [
                                        'id' => $widget['id'],
                                        'widget' => json_decode($widget['value']),
                                        'name' => $widget['name'],
                                        'value' => config('widgets')['widgets'][$widget['name']]
                                    ])
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop


@section('javascript')
    <script>
        window.route = {
            'file_upload': '{{ route('widget.widget.fileUpload') }}',
            'file_delete': '{{ route('widget.widget.fileDelete', '') }}',
            'widget_create': '{{ route('widget.widget.create') }}',
            'widget_drag': '{{ route("widget.widget.drag") }}',
            'widget_sort': '{{ route("widget.widget.sort") }}',
            'widget_delete': '{{ route('widget.widget.delete') }}'
        };
    </script>
    <script src="{{ widgets_asset('js/app.js') }}"></script>
    <script>
        /// FileUploader
        fileUploader = new FileUploader({
            'el': $('.fine-uploader-gallery'),
            'template': 'qq-template-gallery',
            'route': {
                'upload': route['file_upload'],
                'delete': route['file_delete'],
            },
            'token': '{{ csrf_token() }}'
        });

        fileUploader.qq.on('upload', function (event, id, name) {
            //let fileItemContainer = $(this).fineUploader('getItemByFileId', id);
            let fieldName = $(this).data('fieldName');
            let fieldId = $(this).parent('.widgetForm').children('input[name="id"]').val();

            $(this).fineUploader('setParams', {name: fieldName, id: fieldId});
        }).on('submitted', function (event, id, name) {
            console.log('submitted')
        }).on('delete', function (event, id, name) {
            console.log('deleted')
        });
        /// END FileUploader

        //Wiget Init
        const widget = new Widget('textarea.widgetRichTextBox');

        //Create Default(left) Group - serves as a constructor
        const el = document.getElementById('left');
        widget.createLeftGroup(el, route.widget_create);

        // Create All Sortable Widget Group;
        @foreach(config('widgets')['group'] as $group => $value)
            widget.createGroup('{{ $group }}', '{{ $value }}', route.widget_drag, route.widget_sort);
        @endforeach

        // Widget Form Delete
        widget.deleteWidget('.widgetForm #widgetDelete', route.widget_delete);

        // Send Widget Form
        widget.sendWidgetForm('.widgetForm', route.widget_delete);
        /// END Widget
    </script>
@stop
