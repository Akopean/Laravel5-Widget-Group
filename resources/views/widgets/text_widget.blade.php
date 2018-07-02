<div id="text-widget" class="text-widget">
    @if(!empty($title))
        <h4 class="text-widget__title">{{ $title }}</h4>
    @endif
     @if(!empty($body))
     <p class="text-widget__body">
        {{ $body }}
     </p>
    @endif
</div>