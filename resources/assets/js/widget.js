window.jQuery = require('jquery');
"use strict";

/**
 * Widget Class
 */
export default class Widget {

    /**
     * @param {string} el - HTMl Element selector
     * @param {object} settings
     */
    constructor(el, settings) {
        this.tinyMceInit(el, settings);
    }

    /**
     * Init TinyMCE Editor
     * @param {string} el -  HTMl Element selector
     * @param {object} settings - init. params
     */
    tinyMceInit(el, settings = {}) {
        window.tinymce.init(Object.assign(settings, {
            menubar: false,
            selector: el,
            skin: 'widget',
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
    }

    /**
     * ReInstall TinyMCE Editor
     * @param $this
     * @returns {Promise}
     */
    tinyMceReInstall($this) {
        let that = this;
        return new Promise((resolve, reject) => {
            let settings = [];
            let editorIds = [];

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
                    that.tinyMceInit('.widgetRichTextBox', setting);
                });
            }
        });
    }

    /**
     * Send Widget form
     * @param {string} el - Html Element selector
     * @param {string} route - address to delete
     */
    sendWidgetForm(el, route) {
        $(el).submit(function (e) {
            e.preventDefault();
            e.stopPropagation();
            const $this = $(this);
            const data = new FormData($this[0]);

            data.has('qqfile') && data.delete('qqfile');//remove file-input if exist

            window.axios({
                method: 'post',
                cache: false,
                contentType: 'multipart/form-data',
                url: route,
                data: data
            }).then(function (response) {
                // console.log('server:', response);

                /*    // here we will handle errors and validation messages
                 if ( ! data.success) {

                 // handle errors for name ---------------
                 if (data.errors.name) {
                 $('#name-group').addClass('has-error'); // add the error class to show red input
                 $('#name-group').append('<div class="help-block">' + data.errors.name + '</div>'); // add the actual error message under our input
                 }

                 // handle errors for email ---------------
                 if (data.errors.email) {
                 $('#email-group').addClass('has-error'); // add the error class to show red input
                 $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // add the actual error message under our input
                 }

                 // handle errors for superhero alias ---------------
                 if (data.errors.superheroAlias) {
                 $('#superhero-group').addClass('has-error'); // add the error class to show red input
                 $('#superhero-group').append('<div class="help-block">' + data.errors.superheroAlias + '</div>'); // add the actual error message under our input
                 }
                 }
                 */
                $this.closest('#widget').removeClass("open");
                toastr.success('Saved');
            })
                .catch(function (error) {
                    console.log(error);
                    toastr.error('Error', 'Inconceivable!');
                });
        })
    }

    /**
     * Delete Widget
     * @param {string} el - Html Element selector
     * @param {string} route - address to delete
     */
    deleteWidget(el, route) {
        // Widget Form Delete
        window.jQuery(document).on('click', el, function (e) {
            const $this = $(this);
            const data = {
                'id': $this.parent('.widgetForm').children('input[name="id"]').val(),
            };
            window.axios({
                method: 'post',
                cache: false,
                url: route,
                data: data
            }).then(function (response) {
                $this.closest('#widget').toggleClass("open");
                $this.closest('#widget').remove();
                toastr.success('Deleted');
            }).catch(function (error) {
                console.log(error);
                toastr.error('Error', 'Inconceivable!');
            });
        });
    }

    /**
     * Create Widget Sortable Left Group;
     * @param {string} el - Html element selector
     * @param {string} route - address to send
     */
    createLeftGroup(el, route) {
        let that = this;
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
                    that.tinyMceInit('.' + cls);
                });

                const data = {
                    'index': evt.newIndex,
                    'group': $this.data('group'),
                    'name': $(itemEl).data('widget')
                };

                window.axios({
                    method: 'post',
                    url: route,
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
    }

    /**
     * Create Widget Sortable Group
     * @param $group
     * @param $value
     * @param urlDrag - server drag adress
     * @param urlSort - server sort adress
     */
    createGroup($group, $value, urlDrag, urlSort) {
        let that = this;
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
                    that.tinyMceReInstall($this);
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
                    that.tinyMceReInstall($this);
                }).then(function (response) {
                    toastr.success('Saved');
                }).catch(function (error) {
                    toastr.error('Error', error);
                });
            }
        });
    }
};
