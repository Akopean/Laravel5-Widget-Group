<div class="panel">
    <div class="form-group">
        <label for="{{ $id }}"> {{ _t('widgets::widgets.' . $name . '.' . $options['title'], $options['title']) }}</label>
        <textarea
                rows = @if(isset($options['rows'])) {{$options['rows']}} @else 4 @endif
                class="form-control"
                name="{{ $id }}"
                @if(isset($options['placeholder'])) placeholder="{{ _t('widgets.' . $options['placeholder'], 'text area') }} @endif"
        >@if(!is_null($dataContent) && array_key_exists($id, $dataContent)){{ $dataContent[$id] }}@elseif(isset($options['default'])){{$options['default']}}@endif</textarea>
    </div>
</div>