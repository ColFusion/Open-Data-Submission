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

    var failed = false;

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'server/',
        disableImageResize: true,
        maxFileSize: 100000000
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

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

    function submitMetadata() {
        var formData = $('#fileupload').serializeArray();

        $.ajax({            
            url: $('#fileupload').fileupload('option', 'url') + '?payload=metadata',
            method: 'POST',
            dataType: 'json',
            data: formData
        }).done(function (result) {
            var id = JSON.parse(result);
            console.log(id);

            failed = false;
            submitFiles(id);
        })
        .fail(function(e) {
            alert("Something went wrong. Please try again or let us know.");
        });
    }

    function submitFiles(id) {
        $(".files").find(".template-upload").each(function(){
            var data = $(this).data('data');
            if (data && data.submit) {
                data.formData = id;
                data.submit();
            }
        });
    }   

    $("#submit").click(function(){
        // var form = $('#fileupload').parsley();

        form.validate();

        if (!form.isValid()) {
            $("#errorMessageNextToSubmit").show();

            return;
        }
        
        $("#errorMessageNextToSubmit").hide();

        submitMetadata();
    });

    $('#fileupload').bind('fileuploadstop', function(e, data) {
        if (!failed) {
            $('#formContainer').hide();
            $('#submitMessage').show();
        } 
        else {
            alert("Something went wrong. Please try again or let us know.");
        }     
    });

    $('#fileupload').bind('fileuploadfail', function(e, data) {
        failed = true;        
    });

    window.ParsleyValidator.addValidator('minfiles', function validateFiles(value, requirement) {
        return $('.files tr').length >= 1;
    }, 512)
    .addMessage('en', 'minfiles', 'At least one file must be added.');

    window.form = $('#fileupload').parsley();
});
