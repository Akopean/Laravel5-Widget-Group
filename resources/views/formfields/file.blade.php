<!-- Fine Uploader DOM Element
====================================================================== -->

<div class="fine-uploader-gallery"
     data-field-validate=
     "@if(isset($options['rules']['mimes']) && !empty($options['rules']['mimes'])){{ $options['rules']['mimes'] }}@else{{ \config('widgets.file.rules')['mimes'] }}@endif"
     data-field-name=
     "@if(isset($id)){{$id}}@endif">
     <h5>{{ _t('widgets::widgets.' . $name . '.' . $options['title'], $options['title']) }}</h5>
</div>