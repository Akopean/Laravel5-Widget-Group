window.jQuery = require('jquery');
window.fineUploader = require('fine-uploader/jquery.fine-uploader/jquery.fine-uploader.js');

"use strict";

export default class qqUploader {

    // this.qq = fineUploader()

    /**
     * @param options {Object}
     * {
     *      el: jQuery,
     *      tempalate: html class
     *      route: ['upload:'string', 'delete': 'string'}
     *      token: CSRF_TOKEN
     *  }
     */
    constructor(options) {
       this.qq = options.el.fineUploader({
            template: options.template,
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
            },
            thumbnails: {
                placeholders: {
                    waitingPath: 'https://fineuploader.com/source/placeholders/waiting-generic.png',
                    notAvailablePath: 'https://fineuploader.com/source/placeholders/not_available-generic.png',
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
            },
        });
    }
};



