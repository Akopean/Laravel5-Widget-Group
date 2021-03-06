<div class="panel">
    <div class="form-group">
        <h5>{{ _t('widgets::widgets.' . $name . '.' .  $options['title'],  $options['title']) }}</h5>
        @if(isset($options['prepend'])) <span class="input-group-prepend">{{ $options['prepend'] }}</span> @endif
        @if(isset($options['append'])) <span class="input-group-append">{{ $options['append'] }}</span> @endif
        <div class="input-group-wrap">
            <input type="number" class="form-control" id="{{ $id }}" name="{{ $id }}"
                   @if(isset($options['placeholder'])) placeholder="{{ _t('widgets.' . $options['placeholder'], 'number field') }} @endif"
                   @if(!is_null($dataContent) && array_key_exists($id, $dataContent)) value="{{ $dataContent[$id] }}"
                   @elseif(isset($options['default'])) value="{{$options['default']}}" @endif>
        </div>
    </div>
</div>
