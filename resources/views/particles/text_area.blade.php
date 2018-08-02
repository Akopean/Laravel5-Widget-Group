<div class="panel">
    <div class="form-group">
        <label for="{{ $key }}"> {{ _t('widgets::widgets.' . $name . '.' . $key, $key) }}</label>
        <textarea
                class="form-control"
                name="{{ $key }}"
                @if(isset($options['placeholder'])) placeholder="{{ _t('widgets.' . $options['placeholder'], 'text area') }} @endif"
        >@if(!is_null($widget) && isset($widget->$key)){{ $widget->$key }}@elseif(isset($options['default'])){{$options['default']}}@endif</textarea>
    </div>
</div>