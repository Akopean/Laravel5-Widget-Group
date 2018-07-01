window.jQuery = window.$ = require('jquery');
window.axios = require('axios');
window.toastr = require('toastr');
require('bootstrap');
//window.TinyMCE = window.tinymce  = require('tinymce');
//require('./widgets_tinymce');
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/modern/theme';


window.tinyMCE = window.tinymce = tinymce;
window._sortable = require('sortablejs/Sortable');
window.widget = require('./widget');

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

