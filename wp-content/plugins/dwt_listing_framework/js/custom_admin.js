(function ($) {
    "use strict";

    if ($('select').length > 0) {
        $('.custom-fields').select2({width: '100%', allowClear: true,});
        $(".admin-select").select2({width: '60%'});
        $(".admin-select-full").select2({width: '100%'});
    }

    if ($('.custom-checkbox').length) {
        $('.custom-checkbox').iCheck({checkboxClass: 'icheckbox_flat', radioClass: 'iradio_flat'});
    }

    if ($('.admin-ul.for_one input[type="radio"]').is(':checked')) {

        var selected_val = $('#hours_type').val();
        if (selected_val == 2) {
            $("#for_timezones").removeClass("none");
            $("#for_timezones_selective").removeClass("none");
        }
    }

    $(document).on('ifChecked', '.admin-ul.for_one input[type="radio"]', function () {
        var valz = $(this).val();
        $('input[name=hours_type]').val(valz);
        if (valz == 2) {
            $("#for_timezones").removeClass("none");
            $("#for_timezones_selective").removeClass("none");
        } else {
            $("#for_timezones").addClass("none");
            $("#for_timezones_selective").addClass("none");
        }
    });

//For featured listing
    $('.admin-ul.for-featured input[type="radio"]').on('ifChecked', function () {
        var featured_val = $(this).val();
        if (featured_val == 1) {
            $("#featured-for").removeClass("none");
            $("input#featured_for_days").prop('required', true);
        } else {
            $("#featured-for").addClass("none");
            $("input#featured_for_days").prop('required', false);
        }
    });
    if ($('.admin-ul.for-featured input[type="radio"]').is(':checked')) {
        var selected_val = $('#hours_type').val();
        if (selected_val == 2) {
            $("#for_timezones").removeClass("none");
            $("#for_timezones_selective").removeClass("none");
        }
    }
    if ($('.for_specific_page').is('.timepicker')) {
        $('.timepicker').timeselect({'step': 15, autocompleteSettings: {autoFocus: true}});
    }

    /* Fields selection on request */
    $("#field_type").on('change', function () {
        var option_val = this.value;
        if (option_val === 'multiplecheck') {
            $("#custom_multi_ckeck").show();
            $("#custom_radio_opt").hide();
            $("#custom_select_opt").hide();
        } else if (option_val === 'radio') {
            $("#custom_radio_opt").show();
            $("#custom_multi_ckeck").hide();
            $("#custom_select_opt").hide();
        } else if (option_val === 'dropdownselect') {
            $("#custom_select_opt").show();
            $("#custom_multi_ckeck").hide();
            $("#custom_radio_opt").hide();
        } else {
            $("#custom_multi_ckeck").hide();
            $("#custom_radio_opt").hide();
            $("#custom_select_opt").hide();
        }
        return false;
    });


    /* Select All Cats */
    $("#select_all_cats").on('click', function () {
        $('.custom-checkbox').iCheck('check');
    });


    /* Un Select All Cats */
    $("#unselect_all_cats").on('click', function () {
        $('.custom-checkbox').iCheck('uncheck');
    });


    var admin_lat = $('#d_latt').val();
    var admin_long = $('#d_long').val();
    if (admin_lat && admin_long) {
        var chk_container = document.getElementById('submit-map-open');
        if (typeof (chk_container) != 'undefined' && chk_container != null) {
            var mymap = L.map(chk_container).setView([admin_lat, admin_long], 13);
            L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 18,
            }).addTo(mymap);
            var markerz = L.marker([admin_lat, admin_long], {draggable: true}).addTo(mymap);
            var searchControl = new L.Control.Search({
                url: '//nominatim.openstreetmap.org/search?format=json&q={s}',
                jsonpParam: 'json_callback',
                propertyName: 'display_name',
                propertyLoc: ['lat', 'lon'],
                marker: markerz,
                autoCollapse: true,
                autoType: true,
                minLength: 2,
            });
            searchControl.on('search:locationfound', function (obj) {
                var lt = obj.latlng + '';
                var res = lt.split("LatLng(");
                res = res[1].split(")");
                res = res[0].split(",");
                document.getElementById('d_latt').value = res[0];
                document.getElementById('d_long').value = res[1];
            });
            mymap.addControl(searchControl);
            markerz.on('dragend', function (e) {
                document.getElementById('d_latt').value = markerz.getLatLng().lat;
                document.getElementById('d_long').value = markerz.getLatLng().lng;
            });
        }
    }

    //for map
    var ip_type = $('#admin_ip_type').val();
    if (typeof ip_type != 'undefined') {
        $('.get-loc  i.detect-me').on('click', function (e) {
            e.preventDefault();
            $(this).addClass('fa-circle-o-notch fa-spin extra-spin');
            $(this).removeClass('fa-crosshairs');
            if (ip_type == "geo_ip") {
                $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?').done(function (location) {
                    $("#address_location").val(location.city + ", " + location.country_name);
                    document.getElementById('d_latt').value = location.latitude;
                    document.getElementById('d_long').value = location.longitude;
                    mymap.setView(new L.LatLng(location.latitude, location.longitude), 13);
                    markerz.setLatLng([location.latitude, location.longitude]);
                    $('.get-loc i.detect-me').fadeOut('slow');
                });
            } else {
                $.get("https://ipapi.co/json", function (location) {
                    $("#address_location").val(location.city + ", " + location.country_name);
                    document.getElementById('d_latt').value = location.latitude;
                    document.getElementById('d_long').value = location.longitude;
                    mymap.setView(new L.LatLng(location.latitude, location.longitude), 13);
                    markerz.setLatLng([location.latitude, location.longitude]);
                    $('.get-loc i.detect-me').fadeOut('slow');
                }, "json");
            }
        });
    }

    $('#event_end').datepicker({
        language: {
            days: [admin_varible.Sunday, admin_varible.Monday, admin_varible.Tuesday, admin_varible.Wednesday, admin_varible.Thursday, admin_varible.Friday, admin_varible.Saturday],
            daysShort: [admin_varible.Sun, admin_varible.Mon, admin_varible.Tue, admin_varible.Wed, admin_varible.Thu, admin_varible.Fri, admin_varible.Sat],
            daysMin: [admin_varible.Su, admin_varible.Mo, admin_varible.Tu, admin_varible.We, admin_varible.Th, admin_varible.Fr, admin_varible.Sa],
            months: [admin_varible.January, admin_varible.February, admin_varible.March, admin_varible.April, admin_varible.May, admin_varible.June, admin_varible.July, admin_varible.August, admin_varible.September, admin_varible.October, admin_varible.November, admin_varible.December],
            monthsShort: [admin_varible.Jan, admin_varible.Feb, admin_varible.Mar, admin_varible.Apr, admin_varible.May, admin_varible.Jun, admin_varible.Jul, admin_varible.Aug, admin_varible.Sep, admin_varible.Oct, admin_varible.Nov, admin_varible.Dec],
            today: admin_varible.Today,
            clear: admin_varible.Clear,
            dateFormat: 'mm/dd/yyyy',
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
        minDate: new Date(),
        timepicker: true
    });

    $('#event_start').datepicker({
        language: {
            days: [admin_varible.Sunday, admin_varible.Monday, admin_varible.Tuesday, admin_varible.Wednesday, admin_varible.Thursday, admin_varible.Friday, admin_varible.Saturday],
            daysShort: [admin_varible.Sun, admin_varible.Mon, admin_varible.Tue, admin_varible.Wed, admin_varible.Thu, admin_varible.Fri, admin_varible.Sat],
            daysMin: [admin_varible.Su, admin_varible.Mo, admin_varible.Tu, admin_varible.We, admin_varible.Th, admin_varible.Fr, admin_varible.Sa],
            months: [admin_varible.January, admin_varible.February, admin_varible.March, admin_varible.April, admin_varible.May, admin_varible.June, admin_varible.July, admin_varible.August, admin_varible.September, admin_varible.October, admin_varible.November, admin_varible.December],
            monthsShort: [admin_varible.Jan, admin_varible.Feb, admin_varible.Mar, admin_varible.Apr, admin_varible.May, admin_varible.Jun, admin_varible.Jul, admin_varible.Aug, admin_varible.Sep, admin_varible.Oct, admin_varible.Nov, admin_varible.Dec],
            today: admin_varible.Today,
            clear: admin_varible.Clear,
            dateFormat: 'mm/dd/yyyy',
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
        minDate: new Date(),
        timepicker: true
    });


    if ($('#for_timezones').is('.my-zones')) {
        var my_timezones = admin_varible.p_path + "js/zones.json";
        $.get(my_timezones, function (data) {
            typeof $.typeahead === 'function' && $.typeahead({
                input: ".timezone_typeahead",
                minLength: 0,
                emptyTemplate: "no result for {{query}}",
                searchOnFocus: true,
                blurOnTab: true,
                order: "asc",
                hint: true,
                source: data,
                debug: false,
            });
        }, 'json');
    }


    $('#d_cats').on('change', function () {
        $('#dwt_listing_loading').show();
        var cat = $(this).val();
        $.post(ajaxurl, {action: 'dwt_listing_get_features', cat_id: cat,}).done(function (response) {
            $('#dwt_listing_loading').hide();
            if ($.trim(response) != "") {
                $("#cat_features").removeClass("none");
                $('.category-based-features').html(response);
                $('.custom-checkbox').iCheck({checkboxClass: 'icheckbox_flat', radioClass: 'iradio_flat'});
            } else {
                $("#cat_features").addClass("none");
            }
        });
        dwt_listing_get_form_fields(cat);
    });

    /* Country */

    $('#d_country').on('select2:closing', function ()

        // $('#d_country').on('click', function()
    {
        $('#dwt_listing_loading').show();
        var city = $(this).val();
        $.post(ajaxurl, {action: 'dwt_listing_get_locations', city_id: city,}).done(function (response) {
            $('#dwt_listing_loading').hide();
            $("#d_state").val('');
            $("#d_city").val('');
            $("#d_town").val('');
            if ($.trim(response) != "") {
                $("#states").removeClass("none");
                $('#d_state').html(response);

            } else {
                $("#states").addClass("none");
                $("#city").addClass("none");
                $("#town").addClass("none");
            }
        });
    });


    /* State */
    $('#d_state').on('select2:closing', function () {
        $('#dwt_listing_loading').show();
        var city = $(this).val();
        $.post(ajaxurl, {action: 'dwt_listing_get_locations', city_id: city,}).done(function (response) {
            $('#dwt_listing_loading').hide();
            $("#d_city").val('');
            $("#d_town").val('');
            if ($.trim(response) != "") {
                $("#city").removeClass("none");
                $('#d_city').html(response);
            } else {
                $("#city").addClass("none");
                $("#town").addClass("none");
                $('#town').css("display", "none");
            }
        });

    });

    /* City */
    $('#d_city').on('select2:closing', function () {
        $('#dwt_listing_loading').show();
        var city = $(this).val();
        $.post(ajaxurl, {action: 'dwt_listing_get_locations', city_id: city,}).done(function (response) {
            $('#dwt_listing_loading').hide();
            $("#d_town").val('');
            if ($.trim(response) != "") {
                $("#town").removeClass("none");
                $('#d_town').html(response);
            } else {
                $("#town").addClass("none");
            }
        });
    });

    /*fetch category template*/
    function dwt_listing_get_form_fields(cat) {
        var cat_id = cat;
        $('#dwt_listing_loading').show();
        $.post(ajaxurl, {action: 'dwt_listing_get_custom_fields', cat_id: cat,}).done(function (response) {

            $('#dwt_listing_loading').hide();
            if ($.trim(response) != "") {
                $("#additional_fields").removeClass("none");
                $('.additional_custom_fields').html(response);
                $('.custom-checkbox').iCheck({checkboxClass: 'icheckbox_flat', radioClass: 'iradio_flat'});
                $('.custom-fields').select2({allowClear: true, width: '100%'});
            } else {
                $("#additional_fields").addClass("none");
            }
        });
    }

    /*===================
     Gallery Image Upload
     ====================*/
    var meta_gallery_frame;
    $('#dwt_listing_gallery_button').on('click', function (e) {
        // sonu code here.
        if (meta_gallery_frame) {
            meta_gallery_frame.open();
            return;
        }
        // Sets up the media library frame
        meta_gallery_frame = wp.media.frames.meta_gallery_frame = wp.media({
            title: admin_varible.select_imgz,
            button: {text: dwt_listing_gall_idz.button},
            library: {type: 'image'},
            multiple: true
        });
        // Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
        meta_gallery_frame.states.add([
            new wp.media.controller.Library({
                priority: 20,
                toolbar: 'main-gallery',
                filterable: 'uploaded',
                library: wp.media.query(meta_gallery_frame.options.library),
                multiple: meta_gallery_frame.options.multiple ? 'reset' : false,
                editable: true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);
        var idsArray;
        var attachment;
        meta_gallery_frame.on('open', function () {
            var selection = meta_gallery_frame.state().get('selection');
            var library = meta_gallery_frame.state('gallery-edit').get('library');
            var ids = $('#dwt_listing_gall_idz').val();
            if (ids) {
                idsArray = ids.split(',');
                idsArray.forEach(function (id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
            }
        });
        meta_gallery_frame.on('ready', function () {
            $('.media-modal').addClass('no-sidebar');
        });
        var images;
        // When an image is selected, run a callback.
        //meta_gallery_frame.on('update', function() {
        meta_gallery_frame.on('select', function () {
            var imageIDArray = [];
            var imageHTML = '';
            var metadataString = '';
            images = meta_gallery_frame.state().get('selection');
            imageHTML += '<ul class="dwt_listing_gallery">';
            images.each(function (attachment) {
                //sonu get image object
                console.debug(attachment.attributes);
                imageIDArray.push(attachment.attributes.id);
                imageHTML += '<li><div class="dwt_listing_gallery_container"><span class="dwt_listing_delete_icon"><img id="' + attachment.attributes.id + '" src="' + attachment.attributes.url + '"></span></div></li>';
            });
            imageHTML += '</ul>';
            metadataString = imageIDArray.join(",");
            if (metadataString) {
                $("#dwt_listing_gall_idz").val(metadataString);
                $("#dwt_listing_gall_render").html(imageHTML);
            }
        });

        // Finally, open the modal
        meta_gallery_frame.open();

    });


    /*------ Delete the Gallery Image ------*/
    $(document.body).on('click', '.dwt_listing_delete_icon', function (event) {
        event.preventDefault();
        if (confirm(admin_varible.img_del)) {
            var removedImage = $(this).children('img').attr('id');
            var oldGallery = $("#dwt_listing_gall_idz").val();
            var newGallery = oldGallery.replace(',' + removedImage, '').replace(removedImage + ',', '').replace(removedImage, '');
            //var newGallery = oldGallery.replace(','+removedImage,'');
            $(this).parents().eq(1).remove();
            $("#dwt_listing_gall_idz").val(newGallery);
        }
    });

    /*===============
    Brand logo Upload
    ================*/
    var meta_gallery_frame_brand;
    $('#dwt_listing_brand_btn').on('click', function (e) {
        // sonu code here.
        if (meta_gallery_frame_brand) {
            meta_gallery_frame_brand.open();
            return;
        }
        // Sets up the media library frame
        meta_gallery_frame_brand = wp.media.frames.meta_gallery_frame_brand = wp.media({
            title: admin_varible.select_imgz,
            button: {text: dwt_listing_b_logo_id.button},
            library: {type: 'image'},
            multiple: false
        });
        // Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
        meta_gallery_frame_brand.states.add([
            new wp.media.controller.Library({
                priority: 20,
                toolbar: 'main-gallery',
                filterable: 'uploaded',
                library: wp.media.query(meta_gallery_frame_brand.options.library),
                multiple: meta_gallery_frame_brand.options.multiple ? 'reset' : false,
                editable: true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);
        var idsArray;
        var attachmentz;
        meta_gallery_frame_brand.on('open', function () {
            var selection = meta_gallery_frame_brand.state().get('selection');
            var library = meta_gallery_frame_brand.state('gallery-edit').get('library');
            var ids = $('#dwt_listing_b_logo_id').val();
        });
        meta_gallery_frame_brand.on('ready', function () {
            $('.media-modal').addClass('no-sidebar');
        });
        var imagesz;
        // When an image is selected, run a callback.
        //meta_gallery_frame.on('update', function() {
        meta_gallery_frame_brand.on('select', function () {
            var imageIDArrayz = [];
            var imageHTMLz = '';
            var metadataStringz = '';
            imagesz = meta_gallery_frame_brand.state().get('selection');
            imageHTMLz += '<ul class="dwt_listing_gallery">';
            imagesz.each(function (attachmentz) {
                //sonu get image object
                console.debug(attachmentz.attributes);
                imageIDArrayz.push(attachmentz.attributes.id);
                imageHTMLz += '<li><div class="dwt_listing_gallery_container"><span class="dwt_listing_delete_icon_brand"><img id="' + attachmentz.attributes.id + '" src="' + attachmentz.attributes.url + '"></span></div></li>';
            });
            imageHTMLz += '</ul>';
            metadataStringz = imageIDArrayz.join(",");
            if (metadataStringz) {
                $("#dwt_listing_b_logo_id").val(metadataStringz);
                $("#dwt_listing_gall_render_html").html(imageHTMLz);
            }
        });
        // Finally, open the modal
        meta_gallery_frame_brand.open();
    });
    /*------ Delete the logo Icon ------*/
    $(document.body).on('click', '.dwt_listing_delete_icon_brand', function (event) {
        event.preventDefault();
        if (confirm(admin_varible.img_del)) {
            var removedImagez = $(this).children('img').attr('id');
            var oldGalleryz = $("#dwt_listing_b_logo_id").val();
            var newGalleryz = oldGalleryz.replace(',' + removedImagez, '').replace(removedImagez + ',', '').replace(removedImagez, '');
            $(this).parents().eq(1).remove();
            $("#dwt_listing_b_logo_id").val(newGalleryz);
        }
    });


    var meta_gallery_frame_event;
    $('#dwt_listing_event_button').on('click', function (e) {
        if (meta_gallery_frame_event) {
            meta_gallery_frame_event.open();
            return;
        }
        meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
            title: admin_varible.select_imgz,
            button: {text: dwt_listing_event_idz.button},
            library: {type: 'image'},
            multiple: true
        });
        meta_gallery_frame_event.states.add([
            new wp.media.controller.Library({
                priority: 20,
                toolbar: 'main-gallery',
                filterable: 'uploaded',
                library: wp.media.query(meta_gallery_frame_event.options.library),
                multiple: meta_gallery_frame_event.options.multiple ? 'reset' : false,
                editable: true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);
        var idsArray_events;
        var attachment_eventz;
        meta_gallery_frame_event.on('open', function () {
            var event_selection = meta_gallery_frame_event.state().get('selection');
            var library_event = meta_gallery_frame_event.state('gallery-edit').get('library');
            var event_ids = $('#dwt_listing_event_idz').val();
            if (event_ids) {
                idsArray_events = event_ids.split(',');
                idsArray_events.forEach(function (id) {
                    attachment_eventz = wp.media.attachment(id);
                    attachment_eventz.fetch();
                    event_selection.add(attachment_eventz ? [attachment_eventz] : []);
                });
            }
        });
        meta_gallery_frame_event.on('ready', function () {
            $('.media-modal').addClass('no-sidebar');
        });
        var images_event;
        meta_gallery_frame_event.on('select', function () {
            var imageIDArray = [];
            var imageHTML = '';
            var metadataString = '';
            images_event = meta_gallery_frame_event.state().get('selection');
            imageHTML += '<ul class="dwt_listing_gallery">';
            images_event.each(function (attachment_eventz) {
                console.debug(attachment_eventz.attributes);
                imageIDArray.push(attachment_eventz.attributes.id);
                imageHTML += '<li><div class="dwt_listing_gallery_container"><span class="dwt_event_delete_icon"><img id="' + attachment_eventz.attributes.id + '" src="' + attachment_eventz.attributes.url + '"></span></div></li>';
            });
            imageHTML += '</ul>';
            metadataString = imageIDArray.join(",");
            if (metadataString) {
                $("#dwt_listing_event_idz").val(metadataString);
                $("#dwt_listing_gall_render_event").html(imageHTML);
            }
        });
        meta_gallery_frame_event.open();
    });
    

    $(document.body).on('click', '.dwt_event_delete_icon', function (event) {
        event.preventDefault();
        if (confirm(admin_varible.img_del)) {
            var removedImage = $(this).children('img').attr('id');
            var oldGallery = $("#dwt_listing_event_idz").val();
            var newGallery = oldGallery.replace(',' + removedImage, '').replace(removedImage + ',', '').replace(removedImage, '');
            $(this).parents().eq(1).remove();
            $("#dwt_listing_event_idz").val(newGallery);
        }
    });


    $('#renew_expired_listings').on('click', function(){
        $.ajax({
            url: ajaxurl,
            data: { action: 'renew_expired_listingssss',}
            }).done(function(response) {
                alert("All Expired Listings have been reactivated.");
            });
            return false;
    });  
    
    })(jQuery);

function dwt_listing_fresh_install() {
    var is_fresh_copy = confirm("Are you installating it with fresh copy of WordPress? Please only select OK if it is fresh installation.");
    if (is_fresh_copy) {
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action: 'demo_data_start', is_fresh: 'yes'}
        }).done(function (msg) {
        });

    }
}