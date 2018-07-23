<div class="panel">
    <div class="form-group">
        <label for="{{ $key }}"> {{ _t('widgets.' . $name . '.' . $key, $key) }}</label>
        @if(isset($options['prepend'])) <span class="input-group-prepend">{{ $options['prepend'] }}</span> @endif
        @if(isset($options['append'])) <span class="input-group-append">{{ $options['append'] }}</span> @endif
        <div class="input-group-wrap">
            <input type="text" class="form-control" id="{{ $key }}" name="{{ $key }}"
                   @if(isset($options['placeholder'])) placeholder="{{ _t('widgets.' . $options['placeholder'], 'text field') }} @endif"
                   @if(!is_null($widget) && isset($widget[$key])) value="{{ $widget[$key] }}"
                   @elseif(isset($options['default'])) value="{{$options['default']}}" @endif>
        </div>
    </div>
</div>