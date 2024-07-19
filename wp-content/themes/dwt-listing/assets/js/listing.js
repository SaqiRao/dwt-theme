(function($) {
    "use strict";
    var ajax_url = $("input#dwt_listing_ajax_url").val();
    var yes_rtl;
    if ($('#is_rtl').val() !== "" && $('#is_rtl').val() === "1") {
        yes_rtl = true;
    } else {
        yes_rtl = false;
    }



    /*Make Post on blur of title field*/
    $('#listing_title').on('blur', function() {
        $.post(ajax_url, { action: 'create_new_post', title: $('#listing_title').val(), is_update: $('#is_update').val(), }).done(function(response) {

        });
    });


    if ($('#listing-form').length > 0) {
        $('#listing-form').validator().on('submit', function(e) {
            if (e.isDefaultPrevented()) {
                return false;
            } else {
                 $('.sonu-button').button('loading');
                 var is_update = $('#is_update').val();
                 var curent_lang = $('#lang').val();
                 $.post(ajax_url, {
                     action: 'submit_new_listing',
                     lang: curent_lang,
                     collect_data: $("form#listing-form").serialize(),
                     is_update: $('#is_update').val(),
                 }).done(function(response) {
                     $('.sonu-button').button('reset');
                     if (is_update) {
                    $.alert({
                        title: get_strings.congratulations,
                        rtl: yes_rtl,
                        icon: 'fa fa-smile-o',
                        theme: 'modern',
                        backgroundDismiss: true,
                        animation: 'scale',
                        type: 'green',
                        content: get_strings.lcreated,
                    buttons: {
                        [get_strings.showlisting]: function() {
                            window.open(response);
                        },
                        [get_strings.canclelisting]: function() {
                            window.location.reload();
                        }
                    }
                   });
                    } else {
                        $.alert({
                            title: get_strings.congratulations,
                            rtl: yes_rtl,
                            icon: 'fa fa-smile-o',
                            theme: 'modern',
                            backgroundDismiss: true,
                            animation: 'scale',
                            type: 'green',
                            content: get_strings.lcreated,
                            buttons: {
                               [get_strings.showlisting]: function() {
                                window.open(response);
                                },
                               [get_strings.canclelisting]: function() {     
                                 window.location.reload();

                                }
                            }
                        });
                    }
                    window.setTimeout(function() {
                        //window.location = response;
                    }, 1500);
                });
            }
            return false;
        });


        /* First Level */
        // $(document).on("change", "#d_cats", function () 
        $('#d_cats').on('change', function() {
            $('#dwt_listing_loading').show();
            var cat = $(this).val();
            $.post(ajax_url, { action: 'dwt_listing_get_features', cat_id: cat, }).done(function(response) {
                $('#dwt_listing_loading').hide();
                if ($.trim(response) != "") {
                    $('#cat_features').css("display", "block");
                    $('.category-based-features').html(response);
                    $('.custom-checkbox').iCheck({ checkboxClass: 'icheckbox_flat', radioClass: 'iradio_flat' });
                } else {
                    $('#cat_features').css("display", "none");
                }
                dwt_listing_get_form_fields(cat);
            });
        });

        /* Country */

        $('#d_country').on('change', function() {
            $('#dwt_listing_loading').show();
            var city = $(this).val();
            $.post(ajax_url, {
                action: 'dwt_listing_get_locations',
                city_id: city,
            }).done(function(response) {
                $('#dwt_listing_loading').hide();
                $("#d_state").val('');
                $("#d_city").val('');
                $("#d_town").val('');
                if ($.trim(response) != "") {
                    $('#states').css("display", "block");
                    $('#d_state').html(response);

                } else {
                    $('#states').css("display", "none");
                    $('#city').css("display", "none");
                    $('#town').css("display", "none");
                }
            });

        });
        /* State */

        $('#d_state').on('change', function() {
            $('#dwt_listing_loading').show();
            var city = $(this).val();
            $.post(ajax_url, { action: 'dwt_listing_get_locations', city_id: city, }).done(function(response) {
                $('#dwt_listing_loading').hide();
                $("#d_city").val('');
                $("#d_town").val('');
                if ($.trim(response) != "") {
                    $('#city').css("display", "block");
                    $('#d_city').html(response);
                } else {
                    $('#city').css("display", "none");
                    $('#town').css("display", "none");
                }
            });

        });

        /* City */
        $('#d_city').on('change', function() {
            $('#dwt_listing_loading').show();
            var city = $(this).val();
            $.post(ajax_url, { action: 'dwt_listing_get_locations', city_id: city, }).done(function(response) {
                $('#dwt_listing_loading').hide();
                $("#d_town").val('');
                if ($.trim(response) != "") {
                    $('#town').css("display", "block");
                    $('#d_town').html(response);
                } else {
                    $('#town').css("display", "none");
                }
            });

        });



        function dwt_listing_dropzone() {
            Dropzone.autoDiscover = false;
            var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
            var fileList = new Array;
            var i = 0;

            $("#dropzone").dropzone({
                timeout: 50000000000000,
                maxFilesize: 500000000000000,
                addRemoveLinks: true,
                paramName: "my_file_upload",
                maxFiles: $('#gallery_upload_limit').val(), //change limit as per your requirements
                gallery_limit: $('#gallery_img_size').val(),
                acceptedFiles: '.jpeg,.jpg,.png,.webp',
                dictMaxFilesExceeded: $('#gallery_upload_reach').val(),
                /*acceptedFiles: acceptedFileTypes,*/
                url: ajax_url + "?action=upload_dwt_listing_listing_images&gallery_limit=" + $('#gallery_upload_limit').val() + "&is_update=" + $('#is_update').val(),
                parallelUploads: 1,
                dictDefaultMessage: $('#dictDefaultMessage').val(),
                dictFallbackMessage: $('#dictFallbackMessage').val(),
                dictFallbackText: $('#dictFallbackText').val(),
                dictFileTooBig: $('#dictFileTooBig').val(),
                dictInvalidFileType: $('#dictInvalidFileType').val(),
                dictResponseError: $('#dictResponseError').val(),
                dictCancelUpload: $('#dictCancelUpload').val(),
                dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
                dictRemoveFile: $('#dictRemoveFile').val(),
                dictRemoveFileConfirmation: null,
                init: function() {

                    var thisDropzone = this;
                    $.post(ajax_url, {
                        action: 'get_uploaded_ad_images',
                        is_update: $('#is_update').val()
                    }).done(function(data) {
                        if (data != 0) {
                            $.each(data, function(key, value) {

                                var mockFile = { name: value.dispaly_name, size: value.size };

                                thisDropzone.options.addedfile.call(thisDropzone, mockFile);

                                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.name);
                                $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", value.id);
                                i++;
                                $(".dz-progress").remove();
                            });
                        }
                        if (i > 0)
                            $('.dz-message').hide();
                        else
                            $('.dz-message').show();

                    });

                    this.on("addedfile", function(file) {
                        $('.dz-message').hide();
                    });
                    this.on("success", function(file, responseText) {

                        var res_arr = responseText.split("|");
                        if ($.trim(res_arr[0]) != "0") {
                            $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", responseText);
                            i++;
                            $('.dz-message').hide();
                        } else {
                            if (i == 0)
                                $('.dz-message').show();
                            this.removeFile(file);
                            $("#listing_msgz").show();
                            $("#listing_msgz .custom-alert__content").text(res_arr[1]);
                        }

                    });
                    this.on("removedfile", function(file) {
                        var img_id = file._removeLink.attributes[2].value;
                        if (img_id != "") {
                            i--;
                            if (i == 0)
                                $('.dz-message').show();
                            $.post(ajax_url, {
                                action: 'delete_listing_image',
                                img: img_id,
                                is_update: $('#is_update').val(),
                            }).done(function(response) {
                                if ($.trim(response) == "1") {
                                    $("#listing_msgz").hide();
                                    /*this.removeFile(file);*/
                                }
                            });
                        }
                    });

                },
            });

        }

        dwt_listing_dropzone();
    }


    //brand logos
    function brand_logo_readURL(brand_input) {
        if (brand_input.files && brand_input.files[0]) {
            var reader_brand = new FileReader();
            reader_brand.onload = function(e) {
                $('#brand_imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#brand_imagePreview').hide();
                $('#brand_imagePreview').fadeIn(650);
            };
            reader_brand.readAsDataURL(brand_input.files[0]);
        }
    }

    $("#brand_logos_upload").change(function() {
        $(".brand-delete").addClass("hide");
        $(".s-spinner").show();
        var fdb = new FormData();
        var files_dataz = $('.c-cover-brand');
        $.each($(files_dataz), function(i, obj) {
            $.each(obj.files, function(j, file) {
                fdb.append('c-cover-brand[' + j + ']', file);
            });
        });
        $.ajax({
            type: 'POST',
            url: ajax_url + "?action=dwt_upload_brand_img&is_update=" + $('#is_update').val(),
            data: fdb,
            contentType: false,
            processData: false,
            success: function(ress) {
                var res_arr1 = ress.split("|");
                if ($.trim(res_arr1[0]) == "1") {
                    $(".s-spinner").hide();
                    $(".brand-delete").removeClass("hide");
                    $('.brand-delete').attr("data-brand-cover-id", res_arr1[1]);
                } else {
                    $(".s-spinner").hide();
                    $.alert({ title: get_strings.whoops, closeIcon: true, backgroundDismiss: true, rtl: yes_rtl, icon: 'fa fa-frown-o', theme: 'modern', animation: 'scale', type: 'red', content: res_arr1[1], buttons: { okay: { btnClass: 'btn-blue' } } });
                }
            }
        });
        brand_logo_readURL(this);
    });


    $(document).on('click', '.brand-delete', function() {
        $(".s-spinner").show();
        var brand_img_id = $(this).attr("data-brand-cover-id");
        $.post(ajax_url, { action: 'delete_brand_listing_image', brand_img_id: brand_img_id, listing_id: $('#is_update').val() }).done(function(response) {
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) == "1") {
                $(".s-spinner").hide();
                $('.brand-delete').attr("data-brand-cover-id", '');
                $("#brand-del").addClass("hide");
                $("#brand_imagePreview").css("background-image", "url(" + res_arr[1] + ")");
            }
        });
    });



    /*fetch category template*/
    function dwt_listing_get_form_fields(cat) {
        var cat_id = cat;
        $('#dwt_listing_loading').show();
        $.post(ajax_url, { action: 'dwt_listing_get_custom_fields', cat_id: cat, }).done(function(response) {

            $('#dwt_listing_loading').hide();
            if ($.trim(response) != "") {
                $('#additional_fields').css("display", "block");
                $('.additional_custom_fields').html(response);
                $('.custom-checkbox').iCheck({ checkboxClass: 'icheckbox_flat', radioClass: 'iradio_flat' });
                $('.custom-fields').select2({
                    allowClear: true,
                    width: '100%',
                    language: {
                        noResults: function() {
                            return get_strings.no_msg;
                        }
                    }
                });

                //$('.dwt_listing_hiden-div').show();
            } else {
                $('#additional_fields').css("display", "none");
            }
        });
    }



    function readURL_cover(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        var fd = new FormData();
        var files_data = $('.c-cover-listing');
        $.each($(files_data), function(i, obj) {
            $.each(obj.files, function(j, file) {
                fd.append('c-cover-listing[' + j + ']', file);
            });
        });
        $(".c-delete").addClass("hide");
        $.ajax({
            type: 'POST',
            url: ajax_url + "?action=dwt_upload_cover&is_update=" + $('#is_update').val(),
            data: fd,
            contentType: false,
            processData: false,
            success: function(ress) {
                var res_arr1 = ress.split("|");
                if ($.trim(res_arr1[0]) == "1") {
                    $(".c-delete").removeClass("hide");
                    $('.c-delete').attr("data-cover-id", res_arr1[1]);
                } else {
                    $.alert({ title: get_strings.whoops, closeIcon: true, backgroundDismiss: true, rtl: yes_rtl, icon: 'fa fa-frown-o', theme: 'modern', animation: 'scale', type: 'red', content: res_arr1[1], buttons: { okay: { btnClass: 'btn-blue' } } });
                }

            }
        });
        readURL_cover(this);
    });



    $(document).on('click', '.c-delete', function() {
        var cover_id = $(this).attr("data-cover-id");
        $.post(ajax_url, { action: 'delete_listing_cover_image', cover_id: cover_id, is_update: $('#is_update').val(), }).done(function(response) {
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) == "1") {
                $('.c-delete').attr("data-cover-id", '');
                $("#c-del").addClass("hide");
                $("#imagePreview").css("background-image", "url(" + res_arr[1] + ")");
            }
        });
    });

})(jQuery);