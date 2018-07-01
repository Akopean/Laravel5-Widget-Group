<div class="panel">
    <div class="form-group">
        <label for="{{ $key }}"> {{ _t('widgets.' . $name . '.' . $key, $key) }}</label>
        <textarea class="form-control" name="{{ $key }}">@if(!is_null($widget) && isset($widget->$key)){{ $widget->$key }}@endif</textarea>
    </div>
</div>