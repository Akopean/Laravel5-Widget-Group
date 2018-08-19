<div class="panel">
    <h5>{{ _t('widgets::widgets.' . $name . '.' . $options['title'], $options['title']) }}</h5>
    <ul class="radio">
        @if(isset($options['options']) && isset($options['default']))
            @foreach($options['options'] as $index => $option)
                <li>
                    <label class="radio_label">
                        <input type="radio" name="{{ $id }}" value="{{ $index }}"
                        @if($options['default'] == $index){{ 'checked' }}@elseif(!is_null($dataContent) && array_key_exists($id, $dataContent) && $dataContent[$id] == $index){{ 'checked' }}@endif>
                        {{ $option }}
                    </label>
                </li>
            @endforeach
        @endif
    </ul>
</div>