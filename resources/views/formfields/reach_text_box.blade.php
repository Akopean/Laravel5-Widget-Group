<div class="panel">
    <div class="form-group">
        <label for="{{ $id }}"> {{ _t('widgets::widgets.' . $name . '.' . $options['title'], $options['title']) }}</label>
            <textarea data-rich="richTextBox" class="form-control @if(!is_null($dataContent) && array_key_exists('id', $dataContent)) widgetRichTextBox @endif"
                  name="{{ $id }}">@if(!is_null($dataContent) && array_key_exists($id, $dataContent)){{ $dataContent[$id] }}@elseif(isset($options['default'])){{$options['default']}}@endif</textarea>
    </div>
</div>