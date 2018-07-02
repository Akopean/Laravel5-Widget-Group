<div class="panel">
    <div class="form-group">
        <label for="{{ $key }}"> {{ _t('widgets.' . $name . '.' . $key, $key) }}</label>
        <textarea
                class="form-control"
                name="{{ $key }}"
                @if(isset($val['placeholder'])) placeholder="{{ _t('widgets.' . $val['placeholder'], 'text area') }} @endif"
        >@if(!is_null($widget) && isset($widget->$key)){{ $widget->$key }}@elseif(isset($val['default'])){{$val['default']}}@endif</textarea>
    </div>
</div>