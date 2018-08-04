<div id="text-widget" class="text-widget">
    @if(!empty($title))
        <h4 class="text-widget__title">{{ $title }}</h4>
    @endif
     @if(!empty($Text_Field))
     <p class="text-widget__body">
        {{ $Text_Field }}
     </p>
    @endif
</div>
