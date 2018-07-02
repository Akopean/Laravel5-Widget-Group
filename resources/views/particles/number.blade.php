<div class="panel">
    <div class="form-group">
        <label for="{{ $key }}"> {{ _t('widgets.' . $name . '.' . $key, $key) }}</label>
        @if(isset($val['prepend'])) <span class="input-group-prepend">{{ $val['prepend'] }}</span> @endif
        @if(isset($val['append'])) <span class="input-group-append">{{ $val['append'] }}</span> @endif
        <div class="input-group-wrap">
            <input type="number" class="form-control" id="{{ $key }}" name="{{ $key }}"
                   @if(isset($val['placeholder'])) placeholder="{{ _t('widgets.' . $val['placeholder'], 'number field') }} @endif"
                   @if(!is_null($widget) && isset($widget->$key)) value="{{ $widget->$key }}"
                   @elseif(isset($val['default'])) value="{{$val['default']}}" @endif>
        </div>
    </div>
</div>
