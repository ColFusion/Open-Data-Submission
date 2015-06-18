/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    // $('#fileupload').fileupload({
    //     // Uncomment the following to send cross-domain cookies:
    //     //xhrFields: {withCredentials: true},
    //     url: 'server/',
    //     disableImageResize: true,
    //     maxFileSize: 100000000
    // });

    // // Enable iframe cross-domain access via redirect option:
    // $('#fileupload').fileupload(
    //     'option',
    //     'redirect',
    //     window.location.href.replace(
    //         /\/[^\/]*$/,
    //         '/cors/result.html?%s'
    //     )
    // );

    // Load existing files:
    // $('#fileupload').addClass('fileupload-processing');
    // $.ajax({
    //     // Uncomment the following to send cross-domain cookies:
    //     //xhrFields: {withCredentials: true},
    //     url: $('#fileupload').fileupload('option', 'url'),
    //     dataType: 'json',
    //     context: $('#fileupload')[0]
    // }).always(function () {
    //     $(this).removeClass('fileupload-processing');
    // }).done(function (result) {
    //     $(this).fileupload('option', 'done')
    //         .call(this, $.Event('done'), {result: result});
    // });

    // function submitMetadata() {
    //     var formData = $('#fileupload').serializeArray();

    //     $.ajax({            
    //         url: $('#fileupload').fileupload('option', 'url') + '?payload=metadata',
    //         method: 'POST',
    //         dataType: 'json',
    //         data: formData
    //     }).done(function (result) {
    //         var id = JSON.parse(result);
    //         console.log(id);
    //         submitFiles(id);
    //     });
    // }

    function getAllSubmission() {
        $.ajax({
            url: 'server/manager.php?action=submissions',
            method: 'GET',
            dataType: 'json'
        })
        .done(function(data) {            
            $("#submissionList").html(tmpl("template-submissionList", data));
        })
        .fail(function(e) {
            debugger;
        });
    }

    window.getFilesList = function(id) {
        $.ajax({
            url: 'server/manager.php?action=filesList&id=' + id,
            method: 'GET',
            dataType: 'json'
        })
        .done(function(data) {
            $("#filesListContainer-" + id).html(tmpl("template-download", data));
        })
        .fail(function(e) {
            debugger;
        });
    }

    window.formatFileSize = function(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }
        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }
        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }
        return (bytes / 1000).toFixed(2) + ' KB';
    };

    getAllSubmission();
});
