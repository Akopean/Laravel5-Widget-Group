<div id="widget" class="widget_clone" data-widget="{{ $name }}">
    <div class="widget-top" data-toggle="widget-dropdown" aria-expanded="false">
        <div class="widget-title-action">
            <button type="button" class="widget-action">
                <i class="material-icons">
                    arrow_drop_down
                </i>
            </button>
        </div>
        <div class="widget-title ui-draggable-handle">
            <h3>{{ _t($value['placeholder'], $value['placeholder']) }}</h3>
        </div>
    </div>
    <div class="widget-inside row dropdown-menu">
        <div class="col-md-12">
            <form method="post" class="widgetForm">
                <input type="hidden" @if(!empty($id)) value="{{ $id }}" @endif name="id">
                @foreach($value['fields'] as $key => $val)
                    @if ($val['type'] == "text")
                        @include('widgets::particles.text')
                    @elseif ($val['type'] == "number")
                        @include('widgets::particles.number')
                    @elseif($val['type'] == "text_area")
                        @include('widgets::particles.text_area')
                    @elseif($val['type'] == "rich_text_box")
                        @include('widgets::particles.rich_text_box')
                    @elseif($val['type'] == "image" || $val['type'] == "file")
                        @include('widgets::particles.image_file')
                    @elseif($val['type'] == "checkbox")
                        @include('widgets::particles.checkbox')
                    @elseif($val['type'] == "radio")
                        @include('widgets::particles.radio')
                    @endif
                @endforeach
                <button type="button" id="widgetDelete" data-widgetId="@if(!empty($id)){{ $id }}@endif" class="btn btn-danger pull-right">{{ _t('widget.delete', 'Delete') }}</button>
                <button type="submit" id="widgetSubmit" class="btn btn-primary float-right">{{ _t('widget.save', 'Save') }}</button>
            </form>
        </div>
    </div>
</div>
