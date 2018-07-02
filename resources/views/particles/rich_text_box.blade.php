<div class="panel">
    <div class="form-group">
        <label for="{{ $key }}"> {{ _t('widgets.' . $name . '.' . $key, $key) }}</label>
        <textarea data-rich="richTextBox" class="form-control @if(!empty($id)) widgetRichTextBox @endif"
                  name="{{ $key }}">@if(!empty($widget) && !empty($id)){{ $widget->$key }}@elseif(isset($val['default'])){{$val['default']}}@endif</textarea>
    </div>
</div>