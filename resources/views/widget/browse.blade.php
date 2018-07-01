@extends('widgets::layouts.app')

@section('page_title', ' Widgets')

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
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop



@section('css')

@stop

@section('javascript')
    <script>
        //init all Tiny editor
        widget.tinyMceInit('textarea.widgetRichTextBox');

        const el = document.getElementById('left');
        widget.createLeftGroup(el, '{{ route('widget.widget.create') }}');

        // Create Widget Sortable Group;
        @foreach(config('widgets')['group'] as $group => $value)
            widget.createGroup('{{ $group }}', '{{ $value }}', '{{ route("widget.widget.drag") }}', '{{ route("widget.widget.sort") }}');
        @endforeach

        // Insert Widgets from widget zone
        @foreach(config('widgets')['group'] as $group => $value)

            $html = $('#{{$group}}');
            @foreach(\Akopean\laravel5WidgetsGroup\Models\Widget::where('group', '=', $group)->orderBy('index', 'ASC')->get() as $widget)
                        $html.append(`@include('widgets::widget.widget', [
                            'id' => $widget['id'],
                            'widget' => json_decode($widget['value']),
                            'name' => $widget['name'],
                            'value' => config('widgets')['widgets'][$widget['name']]
                        ])`);
            @endforeach
        @endforeach

        // Widget Form Delete
        window.$(document).on('click', '.widgetForm #widgetDelete', function (e) {
            const $this = $(this);
            const data = {
                'id'    : $this.parent('.widgetForm').children('input[name="id"]').val(),
            };

            window.axios({
                method: 'post',
                cache: false,
                url   : '{{ route('widget.widget.delete') }}',
                data  : data
            }) .then(function (response) {
                $this.closest('#widget').toggleClass("open");
                $this.closest('#widget').remove();
                toastr.success('Deleted');
            }) .catch(function (error) {
                    console.log(error);
                    toastr.error('Error', 'Inconceivable!');
            });
        });
        // widget form send
        $('.widgetForm').submit(function(e) {
            const $this = $(this);
            const value = {};
;
            $this.serializeArray().forEach( function (str) {
                value[str['name']] = str['value'];
            });
            //console.log($this.serializeArray());

            const data = {
                'id'    : $this.children('input[name="id"]').val(),
                'value' : JSON.stringify(value)
            };

            window.axios({
                method: 'post',
                cache: false,
                contentType: 'multipart/form-data',
                url   : '{{ route('widget.widget') }}',
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
                    $this.closest('#widget').removeClass("open");
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
