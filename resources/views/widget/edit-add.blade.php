@extends('voyager::master')

@section('page_title', __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height: 100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="@if(isset($dataTypeContent->id))
              {{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}
              @else
              {{ route('voyager.'.$dataType->slug.'.store') }}
              @endif"
              method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="name">Select Widget Group</label>
                            <select class="form-control group" name="group">
                                <option value=""></option>
                                @foreach(config('widgets')['group'] as $group => $value)
                                    <option value="{{ $group }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Select Widget Group</label>
                            <select class="form-control widget-group" name="widget-group">
                                <option value=""></option>
                                @foreach(config('widgets')['widgets'] as $widget => $value)
                                    <option value="{{ $widget }}">{{ $value['placeholder'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>
            <button type="submit" class="btn btn-primary pull-right">
                @if(isset($dataTypeContent->id)){{ __('book.update') }}@else <i
                        class="icon wb-plus-circle"></i> {{ __('book.new') }} @endif
            </button>
        </form>
    </div>


    <div tabindex="-1" id="goup_fields" role="dialog" class="modal modal-info fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title"><i class="voyager-data"></i> widgets</h4></div>
                <div class="modal-body" style="overflow: scroll;">
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-outline pull-right">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop



@section('javascript')
    <script>
        $('.form-group').on('change', '.widget-group', function (e) {
            params = {
                widget:   this.value,
                _token: '{{ csrf_token() }}'
            };
            $.get('{{ route('admin.widget') }}', params, function (response) {
                toastr.success('Success');

            });
            $('#goup_fields').modal('show');
        });

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@stop
