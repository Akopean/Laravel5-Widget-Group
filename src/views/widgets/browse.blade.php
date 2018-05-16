@extends('voyager::master')

@section('page_title', ' Widgets')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
              Widgets
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-4">
                <div class="widget-holder">
                    <div class="sidebar-description">
                        <h3>{{ __('admin.widgets.available') }}</h3>
                        <p class="description">{{ __('admin.widgets.available-desc') }}
                        </p>
                    </div>
                    <div class="widget-list">
                        <div id="left" data-group="left">
                            @foreach(config('widgets')['widgets'] as $widget => $value)
                               @include('admin.widgets.widget', ['widget' => null, 'name' => $widget, 'value' => config('widgets')['widgets'][$widget]])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    @foreach(config('widgets')['group'] as $group => $value)
                        <div class="col-md-6">
                            <h3> {{ $value }} </h3>
                            <div class="widget-inner" data-group="{{ $group }}" id="{{ $group }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop



@section('css')
    @if( config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop


@section('javascript')
    <script>

        // remove action active dropdown in widget-holder
        $(".widget-holder").on('click', function (){
            return false;
        });

        // remove action close dropdown
        $(document).on('click', '.widget-inner .dropdown-menu', function (e) {
            e.stopPropagation();
        });
    </script>
    <script type="text/javascript" src="{!! asset('js/admin.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/tinymce.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/widget.js') !!}"></script>
    <script>
        //init all Tiny editor
        adminWidget.tinyMceInit('textarea.widgetRichTextBox');

        const el = document.getElementById('left');
        adminWidget.createLeftGroup(el, '{{ route('admin.widget.create') }}');

        // Create Widget Sortable Group;
        @foreach(config('widgets')['group'] as $group => $value)
            adminWidget.createGroup('{{ $group }}', '{{ $value }}', '{{ route("admin.widget.drag") }}', '{{ route("admin.widget.sort") }}');
        @endforeach

         // Insert Widgets from widget zone
        @foreach(config('widgets')['group'] as $group => $value)
            $html = $('#{{$group}}');
            @foreach(\App\Widget::where('group', '=', $group)->orderBy('index', 'ASC')->get() as $widget)
                $html.append(`@include('admin.widgets.widget', [
                    'id' => $widget['id'],
                    'widget' => json_decode($widget['value']),
                    'name' => $widget['name'],
                    'value' => config('widgets')['widgets'][$widget['name']]
                ])`);
            @endforeach
        @endforeach


        // widget form send
        $('.widgetForm').submit(function(e) {
            const $this = $(this);
            const value = {};

            $this.serializeArray().forEach( function (str) {
                value[str['name']] = str['value'];
            });
            console.log($this.serializeArray());

            const data = {
                'id'    : $this.children('input[name="id"]').val(),
                'value' : JSON.stringify(value)
            };

            window.axios({
                method: 'post',
                cache: false,
                contentType: 'multipart/form-data',
                url   : '{{ route('admin.widget') }}',
                data  : data
            })
                .then(function (response) {
                    console.log('server:', response);

                    /*    // here we will handle errors and validation messages
                     if ( ! data.success) {

                     // handle errors for name ---------------
                     if (data.errors.name) {
                     $('#name-group').addClass('has-error'); // add the error class to show red input
                     $('#name-group').append('<div class="help-block">' + data.errors.name + '</div>'); // add the actual error message under our input
                     }

                     // handle errors for email ---------------
                     if (data.errors.email) {
                     $('#email-group').addClass('has-error'); // add the error class to show red input
                     $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // add the actual error message under our input
                     }

                     // handle errors for superhero alias ---------------
                     if (data.errors.superheroAlias) {
                     $('#superhero-group').addClass('has-error'); // add the error class to show red input
                     $('#superhero-group').append('<div class="help-block">' + data.errors.superheroAlias + '</div>'); // add the actual error message under our input
                     }
                     }
                     */
                    $this.closest('#widget').toggleClass("open");
                    toastr.success('Saved');
                })
                .catch(function (error) {
                    console.log(error);
                    toastr.error('Error', 'Inconceivable!');
                });
            event.preventDefault();
        });
    </script>
@stop
