
<div class="panel">
       <div class="form-group">
              <label for="{{ $id }}">{{ _t('widgets::widgets.' . $name . '.' . $options['title'], $options['title']) }}</label>
              <div class="input-group-wrap">
                     <input type="text"
                            class="form-control"
                            data-googleMapTitle="google"
                            id="{{ $id }}"
                            name="{{ $id }}"
                            @if(!is_null($dataContent) && array_key_exists($id, $dataContent)) value="{{ $dataContent[$id] }}"@endif>
                     <input hidden type="text"
                            data-cord="google"
                            name="cord_{{ $id }}"
                            @if(!is_null($dataContent) && array_key_exists('cord_' . $id, $dataContent)) value="{{ $dataContent['cord_' .$id] }}"@endif>
              </div>
              <div class="google_map_init" id="{{ $id }}_{{$dataContent['id']}}" style="height: 400px"></div>
       </div>
</div>
