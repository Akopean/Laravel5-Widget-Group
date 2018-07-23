<!-- Fine Uploader DOM Element
====================================================================== -->
<div class="fine-uploader-gallery"
     data-field-validate=
     "@if(isset($options['rules']['mimes']) && !empty($options['rules']['mimes'])){{ $options['rules']['mimes'] }}@else{{ \config('widgets.file.rules')['mimes'] }}@endif"
     data-field-name=
     "@if(isset($key)){{$key}}@endif">
</div>