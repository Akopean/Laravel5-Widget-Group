<div class="panel">
    <div class="form-group">
        @if(!is_null($widget) && isset($widget->$key))
            <img src="/storage/{{$widget->$key}}" alt="" style="max-width: auto;max-height: 200px">

        @endif
        <label for="{{ $key }}"> {{ _t('widgets.' . $name . '.' . $key, $key) }}</label>
        <input type="file" id="{{ $key }}" name="{{ $key }}" />
    </div>
</div>