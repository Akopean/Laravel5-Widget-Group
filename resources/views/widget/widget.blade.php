<div id="widget" class="widget_clone" data-widget="{{ $name }}">
    <div class="widget-top" data-toggle="widget-dropdown" aria-expanded="false">
        <div class="widget-title-action">
            <button type="button" class="widget-action">
                <i class="material-icons">
                    arrow_drop_down
                </i>
            </button>
        </div>
        <div class="widget-title ui-draggable-handle">
            <h3>{{ _t('widgets::widgets.'.$value['placeholder'], $value['placeholder']) }}</h3>
        </div>
    </div>
    <div class="widget-inside row dropdown-menu">
        <div class="col-md-12">
            <form method="post" class="widgetForm" enctype="multipart/form-data">
                <input type="hidden" @if(!empty($id)) value="{{ $id }}" @endif name="id">
                @foreach($value['fields'] as $key => $options)

                    {!! app('widgets')->formField($name, $key, $options, $widget) !!}

               @endforeach
               <button type="button" id="widgetDelete" data-widgetId="@if(!empty($id)){{ $id }}@endif"
                       class="btn btn-danger pull-right">{{ _t('widget.delete', 'Delete') }}</button>
               <button type="submit" id="widgetSubmit"
                       class="btn btn-primary float-right">{{ _t('widget.save', 'Save') }}</button>
           </form>
       </div>
   </div>
</div>
