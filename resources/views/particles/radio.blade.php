<ul class="radio">
    @if(isset($val['options']) && isset($val['default']))
        @foreach($val['options'] as $index => $option)
        <li>
            <input type="radio" id="option-@if(isset($id)){{ $index }}{{$id}}@endif" name="{{ $key }}"
                   value="{{ $index }}" @if($val['default'] == $index){{ 'checked' }}@endif @if(!is_null($widget) && $widget->$key == $index){{ 'checked' }}@endif>
            <label for="option-@if(isset($id)){{ $index }}{{$id}}@endif">{{ $option }}</label>
        </li>
        @endforeach
    @endif
</ul>