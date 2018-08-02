window.jQuery = window.$ = require('jquery');
window.axios = require('axios');
window.toastr = require('toastr');
window.bootstraptoggle = require('bootstrap-toggle');

import FileUploader from './file-upload';
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/modern/theme';
import Widget from './widget';

require('bootstrap');
//window.TinyMCE = window.tinymce  = require('tinymce');
//require('./widgets_tinymce');


window.tinyMCE = window.tinymce = tinymce;
window._sortable = require('sortablejs/Sortable');
window.Widget = Widget;
window.FileUploader = FileUploader;


window.$(document).ready(function () {
    window.$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': window.$('meta[name="csrf-token"]').attr('content')
        }
    });
});


// add dropdown
window.$(document).on('click', '[data-toggle="widget-dropdown"]', function (e) {
    jQuery(this).parent().toggleClass('open');
    return false;
});

