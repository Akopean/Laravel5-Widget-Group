<div id="text-widget" class="text-widget">
    @if(!empty($data['unique_text_id']))
        <h4 class="text-widget__title">{{ $data['unique_text_id'] }}</h4>
    @endif
     @if(!empty($data['unique_text_area_id']))
     <p class="text-widget__body">
        {{ $data['unique_text_area_id'] }}
     </p>
    @endif
</div>
