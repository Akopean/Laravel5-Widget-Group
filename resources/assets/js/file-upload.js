window.jQuery = require('jquery');
window.fineUploader = require('fine-uploader/fine-uploader/fine-uploader.js');

"use strict";

export default class FileUploader {

    /**
     * @param options {Object}
     * {
     *      el: jQuery: element
     *      template: class: string
     *      route: ['upload:'string', 'delete': 'string', 'session':'string']
     *      token: CSRF_TOKEN: string
     *  }
     */
    constructor(options) {
        let el = options.el;
        let session = {};

        if(!jQuery(el).closest('#left').length) {
            session = {
                session: {
                    endpoint: options.route.session,
                    customHeaders: {
                        'X-CSRF-TOKEN': options.token,
                    },
                    params: {
                        id: jQuery(el).parent('.widgetForm').children('input[name="id"]').val(),
                        name: jQuery(el).data('fieldName')
                    }
                }
            };
        }
        this.qq = new fineUploader.FineUploader(Object.assign({
            element: options.el,
            template: options.template,
            //debug: true,
            request: {
                endpoint: options.route.upload,
                customHeaders: {
                    'X-CSRF-TOKEN': options.token,
                },
            },

            deleteFile: {
                enabled: true, // defaults to false
                endpoint: options.route.delete,
                //forceConfirm: true,
                customHeaders: {
                    'X-CSRF-TOKEN': options.token,
                },
                //forceConfirm: true,
            },
            thumbnails: {
                placeholders: {
                    waitingPath: 'https://fineuploader.com/source/placeholders/waiting-generic.png',
                    notAvailablePath: 'https://fineuploader.com/source/placeholders/not_available-generic.png',
                }
            },
            validation: {
                // allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'txt'],
                //itemLimit: 5,
            },
            callbacks: {
                onUpload: function () {
                    let fieldName = jQuery(el).data('fieldName');
                    let fieldId = jQuery(el).parent('.widgetForm').children('input[name="id"]').val();
                    this.setParams({name: fieldName, id: fieldId});
                },
                onValidate: function (fileData) {
                    //console.log('validate');
                    const allowedExts = jQuery(el).data('fieldValidate').split(',');
                    const parts = fileData.name.split('.');
                    const extension = parts[parts.length - 1];

                    if (!allowedExts.includes(extension)) {
                        toastr.error('Error', `${fileData.name} has an invalid extension. Valid extension(s): ` + allowedExts.join(', '));
                        return false;
                    }
                    return true;
                },
                onSubmitDelete: function(id){
                    let fieldName = jQuery(el).data('fieldName');
                    let fieldId = jQuery(el).parent('.widgetForm').children('input[name="id"]').val();
                    this.setDeleteFileParams({name: fieldName, id: fieldId}, id);
                },
                onDeleteComplete: function (e, xhr, isError) {
                    toastr.success('Deleted', `${name} Deleted`);
                  console.log(e, xhr, isError);
                },
                onSubmitted: function (event, id, name) {
                    //console.log('submitted');
                    toastr.success('Saved', `${name} has been uploaded`);

                },
            },
        }, session));
    }
};

/*

onSessionRequestComplete: function (response, success, xhrOrXdr) {
    //console.log('sessionRequestComplete');
    //  console.log(response, success, xhrOrXdr);
},
onAllComplete: function (event, id, name, response) {
    // console.log('allcomplete');
    //console.log(event, id, name, response);
    //uploader.drawThumbnail(fileId, document.getElementById('picture'), 200, true);
},
onComplete: function (event, id, name, response) {
    //console.log('complete');
    // console.log(event, id, name, response);
    //uploader.drawThumbnail(fileId, document.getElementById('picture'), 200, true);
},
*/