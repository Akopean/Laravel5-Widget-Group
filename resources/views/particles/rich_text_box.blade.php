<div class="panel">
    <div class="form-group">
        <label for="{{ $key }}"> {{ _t('widgets::widgets.' . $name . '.' . $key, $key) }}</label>
        <textarea data-rich="richTextBox" class="form-control @if(!empty($id)) widgetRichTextBox @endif"
                  name="{{ $key }}">@if(isset($widget[$key]) && !is_null($widget[$key]) && !empty($id)){{ $widget[$key] }}@elseif(isset($options['default'])){{$options['default']}}@endif</textarea>
    </div>
</div>