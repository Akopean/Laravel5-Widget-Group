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
                                        'widget' => $widget['value'],
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
    <!-- Fine Uploader Gallery template
  ====================================================================== -->
    <script type="text/template" id="qq-template-gallery">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite"
                aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                             class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"
                                  aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
@stop


@section('javascript')
    <script>
        window.route = {
            'file_upload': '{{ route('widget.widget.fileUpload') }}',
            'file_session': '{{ route('widget.widget.fileSession') }}',
            'file_delete': '{{ route('widget.widget.fileDelete', '') }}',
            'widget_create': '{{ route('widget.widget.create') }}',
            'widget_update': '{{ route('widget.widget') }}',
            'widget_drag': '{{ route("widget.widget.drag") }}',
            'widget_sort': '{{ route("widget.widget.sort") }}',
            'widget_delete': '{{ route('widget.widget.delete') }}',

        };
    </script>
    <script src="{{ widgets_asset('js/app.js') }}"></script>
    <script>

        let fileUploader = [];
        /// FileUploader
        $('.fine-uploader-gallery').each(function () {
            fileUploader = new FileUploader({
                'el': $(this)[0],
                'template': 'qq-template-gallery',
                'route': {
                    'upload': route['file_upload'],
                    'delete': route['file_delete'],
                    'session': route['file_session'],
                },
                'token': '{{ csrf_token() }}'
            });
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
        widget.sendWidgetForm('.widgetForm', route.widget_update);
        /// END Widget
    </script>
@stop
