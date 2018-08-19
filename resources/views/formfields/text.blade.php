<div class="panel">
       <div class="form-group">
              <label for="{{ $id }}">{{ _t('widgets::widgets.' . $name . '.' . $options['title'], $options['title']) }}</label>
              @if(isset($options['prepend'])) <span class="input-group-prepend">{{ $options['prepend'] }}</span> @endif
              @if(isset($options['append'])) <span class="input-group-append">{{ $options['append'] }}</span> @endif
              <div class="input-group-wrap">
                     <input type="text" class="form-control" id="{{ $id }}" name="{{ $id }}"
                            @if(isset($options['placeholder'])) placeholder="{{ _t('widgets.' . $options['placeholder'], 'text field') }} @endif"
                            @if(!is_null($dataContent) && array_key_exists($id, $dataContent)) value="{{ $dataContent[$id] }}"
                            @elseif(isset($options['default'])) value="{{$options['default']}}" @endif>
              </div>
       </div>
</div>