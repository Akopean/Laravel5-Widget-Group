module.exports = (function () {
    "use strict";
    const version = 0.3;
    console.log('Init Laravel Widget!!! version: ', version);
    const w = {};

    /**
     * Init TinyMCE Editor
     * string el    // element selector
     * object setting // initialization params
     */
    w.tinyMceInit = function (el, setting = {}) {
        window.tinymce.init(Object.assign(setting, {
            menubar: false,
            selector: el,
            skin: 'voyager',
            //cache_suffix: '?v=4.1.6',
            min_height: 250,
            resize: 'vertical',
            plugins: 'link, code',
            content_css: "",
            content_style: "div {margin: 10px; border: 5px solid red; padding: 3px}",
            extended_valid_elements: 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
            setup: function (editor) {
                editor.on('change', function () {
                    window.tinymce.triggerSave();
                })
            },
            toolbar: 'bold italic underline | link | code',
            convert_urls: false,
        }));
    };

    /**
     * ReInstall TinyMCE Editor
     */
    w.tinyMceReInstall = function ($this) {
        return new Promise((resolve, reject) => {
            let settings = [];
            let editorIds = [];
            /* for (let id in window.tinyMCE.editors) {
             editorIds.push(id);
             }*/
            $this.find('[data-rich="richTextBox"]').each(function () {
                editorIds.push(this.id);
            });
            if (editorIds.length) {
                let editors = $('#' + editorIds.join(', #'));
                editors.each(function () {
                    settings[this.id] = window.tinyMCE.get(this.id).settings;
                    window.tinyMCE.get(this.id).remove();
                });

                // Re-initialize editors
                editors.each(function () {
                    let setting = settings[this.id];
                    w.tinyMceInit('.widgetRichTextBox', setting);
                });
            }
        });
    };

    /**
     * Create Widget Sortable Left Group;
     * string el    // element selector
     * url // send server link
     */
    w.createLeftGroup = function (el, url) {
        //const el = document.getElementById('left');
        //   url   : '{{ route('admin.widget.create') }}',
        window._sortable.create(el, {
            group: {
                name: 'l',
                animation: 100,
                pull: "clone"
            },
            handle: ".ui-draggable-handle",
            sort: false,
            animation: 100,

            // Element dragging ended
            onEnd: function (evt) {
                const itemEl = evt.item;  // dragged HTMLElement
                const $this = $(evt.to);
                const $that = $(evt.from);


                //disable  left widget zone  dragging
                if ($this.data('group') === 'left') {
                    return false;
                }
                //fix tinyMCE drag disabled
                $(itemEl).find('[data-rich="richTextBox"]').each(function () {
                    let cls = 'class' + Math.floor((Math.random() * 1000) + 1);
                    $(this).addClass(cls).addClass('widgetRichTextBox');
                    w.tinyMceInit('.' + cls);
                });
                //console.log(el);
                const data = {
                    'index': evt.newIndex,
                    'group': $this.data('group'),
                    'name': $(itemEl).data('widget')
                };

                window.axios({
                    method: 'post',
                    url: url,
                    data: data
                }).then(function (response) {
                    // console.log(response);
                    let data = response.data;
                    if (data) {
                        $(itemEl).find('.widgetForm input[name=id]').val(data.id);
                        toastr.success('Saved');
                    }
                    else {
                        toastr.error('Error', error);
                    }
                }).catch(function (error) {
                    toastr.error('Error', error);
                    itemEl.remove();
                });
            }
        });
    };

    // Create Widget Sortable Group;
    w.createGroup = function ($group, $value, urlDrag, urlSort) {
        window._sortable.create(document.getElementById($group), {
            group: {
                name: 'left',
                put: ['l', 'left']
            },
            animation: 100,
            handle: ".ui-draggable-handle",
            // Element dragging ended
            onEnd: function (evt) {
                const itemEl = evt.item;  // dragged HTMLElement
                const $this = $(evt.to);
                const $that = $(evt.from);

                if ($this.data('group') === $that.data('group')) {
                    return false;
                }

                const data = {
                    'name': $(itemEl).data('widget'),
                    'group': $this.data('group'),
                    'oldGroup': $that.data('group'),
                    'index': evt.newIndex,
                    'oldIndex': evt.oldIndex
                };

                window.axios({
                    method: 'post',
                    url: urlDrag,
                    data: data
                }).then(function (response) {
                    w.tinyMceReInstall($this);
                }).then(function (response) {
                    toastr.success('Saved');
                }).catch(function (error) {
                    toastr.error('Error', error);
                });


            },            // Element dragging started
            onStart: function (evt) {
                //evt.oldIndex;  // element index within parent
                $(evt.item).removeClass('open');
            },
            // Changed sorting within list
            onUpdate: function (evt) {
                console.log("drag update");
                const itemEl = evt.item;  // dragged HTMLElement
                const $this = $(evt.to);
                const $that = $(evt.from);

                if ($this.data('group') !== $that.data('group')) {
                    return false;
                }

                const data = {
                    'name': $(itemEl).data('widget'),
                    'group': $this.data('group'),
                    'index': evt.newIndex,
                    'oldIndex': evt.oldIndex
                };

                window.axios({
                    method: 'post',
                    url: urlSort,
                    data: data
                }).then(function (response) {
                    w.tinyMceReInstall($this);
                }).then(function (response) {
                    toastr.success('Saved');
                }).catch(function (error) {
                    toastr.error('Error', error);
                });
            }
        });
    };
    return w;
})();
