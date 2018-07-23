<div class="panel">
    <h5>{{ _t('widgets.' . $name . '.' . $key, $key) }}</h5>
    <ul class="radio">
        @if(isset($options['options']) && isset($options['default']))
            @foreach($options['options'] as $index => $option)
                <li>
                    <input type="radio" id="option-@if(isset($id)){{ $index }}{{$id}}@endif" name="{{ $key }}" value="{{ $index }}"
                    @if($options['default'] == $index){{ 'checked' }}@elseif(isset($widget->$key) && $widget->$key == $index){{ 'checked' }}@endif>
                    <label class="radio_label" for="option-@if(isset($id)){{ $index }}{{$id}}@endif">{{ $option }}</label>
                </li>
            @endforeach
        @endif
    </ul>
</div>