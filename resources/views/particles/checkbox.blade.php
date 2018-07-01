


<div class="panel">
    <div class="form-group">
        <input type="hidden" name="{{$key }}" value="off">
        <label for="{{ $key }}"> {{ _t('widgets.' . $name . '.' . $key, $key) }}</label>
        <input type="checkbox" name="{{$key }}" @if(!is_null($widget) && isset($widget->$key) && $widget->$key === 'on') checked @endif>
    </div>
</div>