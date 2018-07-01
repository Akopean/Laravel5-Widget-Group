<div class="panel">
    <div class="form-group">
        <label for="{{ $key }}"> {{ _t('widgets.' . $name . '.' . $key, $key) }}</label>
        <input type="text" class="form-control" id="{{ $key }}" name="{{ $key }}" placeholder="{{ _t('Text', 'Text') }}"
        @if(!is_null($widget) && isset($widget->$key)) value="{{ $widget->$key }}" @endif>
    </div>
</div>