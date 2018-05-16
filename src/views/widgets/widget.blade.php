<div id="widget" class="widget_clone" data-widget="{{ $name }}">
    <div class="widget-top" data-toggle="dropdown" aria-expanded="false">
        <div class="widget-title-action">
            <button type="button" class="widget-action">
                <span class="caret"></span>
            </button>
        </div>
        <div class="widget-title ui-draggable-handle">
            <h3><i style="color: #76838f" class="icon voyager-puzzle"></i>{{ $value['placeholder'] }}</h3>
        </div>
    </div>
    <div class="widget-inside row dropdown-menu">
        <div class="col-md-12">
            <form method="post" class="widgetForm">
                <input type="hidden" @if(!empty($id)) value="{{ $id }}" @endif name="id">
                @foreach($value['fields'] as $key => $val)
                    @if ($val['type'] == "text")
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    {{ __('admin.widgets.' . $name . '.' . $key) }}
                                </h3>
                                <div class="panel-actions">
                                    <a class="panel-action panel-collapsed voyager-angle-down"
                                       data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body" style="display: none;">
                                <input type="text" class="form-control" id="{{ $key }}" name="{{ $key }}"
                                       placeholder="Text"
                                       @if(!is_null($widget) && isset($widget->$key)) value="{{ $widget->$key }}" @endif>
                            </div>
                        </div>
                    @elseif ($val['type'] == "number")
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    {{ __('admin.widgets.' . $name . '.' . $key) }}
                                </h3>
                                <div class="panel-actions">
                                    <a class="panel-action panel-collapsed voyager-angle-down"
                                       data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body" style="display: none;">
                                <input type="number" class="form-control" id="{{ $key }}" name="{{ $key }}"
                                       @if(!is_null($widget) && isset($widget->$key)) value="{{ $widget->$key }}" @endif>
                            </div>
                        </div>
                    @elseif($val['type'] == "text_area")
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    {{ __('admin.widgets.' . $name . '.' . $key) }}
                                </h3>
                                <div class="panel-actions">
                                    <a class="panel-action panel-collapsed voyager-angle-down"
                                       data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body" style="display: none;">
                                <textarea class="form-control"
                                          name="{{ $key }}">@if(!is_null($widget) && isset($widget->$key)){{ $widget->$key }}@endif</textarea>
                            </div>
                        </div>
                    @elseif($val['type'] == "rich_text_box")
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Excerpt
                                    <small>Small description of this post</small>
                                </h3>
                                <div class="panel-actions">
                                    <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                       aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <textarea data-rich="richTextBox" class="form-control @if(!empty($id)) ?: widgetRichTextBox @endif"
                                          name="{{ $key }}">@if(!empty($widget)){{ $widget->body }}@endif</textarea>
                            </div>
                        </div>
                    @elseif($val['type'] == "image" || $val['type'] == "file")
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="icon wb-image"></i> Post Image</h3>
                                <div class="panel-actions">
                                    <a class="panel-action panel-collapsed voyager-angle-down"
                                       data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body" style="display: none;">
                                <img src="http://laravel-teaching.local/storage/posts/post1.jpg" style="width:100%">
                                <input type="file" name="{{ $key }}">
                            </div>
                        </div>
                    @endif
                @endforeach
                <button type="submit" class="btn btn-primary pull-right">{{ __('admin.save') }}</button>
            </form>
        </div>
    </div>
</div>
