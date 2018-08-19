<div class="panel">
    <div class="form-group">
        <h5>{{ _t('widgets::widgets.' . $name . '.' . $options['title'], $options['title']) }}</h5>
        <label class="form-check-label">
            <input type="hidden" name="{{ $id }}" value="{{ $options['off'] }}">
            <input data-toggle="toggle"
                   value="{{ $options['on'] }}"
                   class="form-check-input"
                   type="checkbox"
                   name="{{$id }}"
                   data-on="{{ $options['on'] }}"
                   data-off="{{ $options['off'] }}"
                   @if(isset($options['width']) && !empty($options['width']))
                   data-size="{{ $options['width'] }}"
                   @endif
                   @if(isset($options['onstyle']) && !empty($options['onstyle']))
                   data-onstyle="{{ $options['onstyle'] }}"
                   @endif
                   @if(isset($options['offstyle']) && !empty($options['offstyle']))
                   data-offstyle="{{ $options['offstyle'] }}"
                   @endif
                   @if(isset($options['width']) && !empty($options['width']))
                   data-width="{{ $options['width'] }}"
                   @endif
                   @if(!is_null($dataContent) && array_key_exists($id, $dataContent) && $dataContent[$id] === $options['on']) checked
                   @elseif(!is_null($dataContent && array_key_exists($id, $dataContent)) && $options['checked']) checked @endif>
        </label>
    </div>
</div>