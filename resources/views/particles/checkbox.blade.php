<div class="panel">
    <div class="form-group">
        <label class="form-check-label">
            <input type="hidden" name="{{ $key }}" value="{{ $options['off'] }}">
            <input data-toggle="toggle"
                   value="{{ $options['on'] }}"
                   class="form-check-input"
                   type="checkbox"
                   name="{{$key }}"
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
                   @if(!is_null($widget) && isset($widget[$key]) && $widget[$key] === $options['on']) checked
                   @elseif(empty($id) && $options['checked']) checked @endif>
        </label>
    </div>
</div>