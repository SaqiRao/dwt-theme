var is_rtlz;
if (search_strings.rtlz !== "" && search_strings.rtlz === "1") {
    is_rtlz = true;
} else {
    is_rtlz = false;
}
(function ($) {
    "use strict";
    var ajax_url = $("input#dwt_listing_ajax_url").val();
    /*For Title & Location*/
    $('#get_title,#l_loc').on('click', function () {
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $(".feat_slider").html('');
        $("#listing_ajax_pagination").html('');
        $.post(ajax_url, {
            action: 'dwt_ajax_search',
            collect_data: $("form#search_form_ajax").serialize(),
        }).done(function (response) {
            $('.sk-circle').hide();
            if ($.trim(response) != "") {
                var res = response.split("|");
                $(".filters-option-bar .heading strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                $(".feat_slider").html(res[4]);
                regenerate_slider();
                regenerate_masnory();
                regenerate_tiksy();
            }
        });
    });

    /*For Category Change*/
    $('#l_category,#l_tag, #cost_range,#rated,#listing_status,#region').on('change', function () {
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $(".feat_slider").html('');
        $(".amenties").hide();
        $("#listing_ajax_pagination").html('');
        var cat_id = $('#l_category').val();
        var sort_by = $("#order_by").val();
        $.post(ajax_url, {
            action: 'dwt_ajax_search',
            collect_data: $("form#search_form_ajax").serialize(),
            sort_by: sort_by,
            search_filter_type : 'topbar_filter'
        }).done(function (response) {
            $('.sk-circle').hide();
            if ($.trim(response) != "") {
                var res = response.split("|");
                $(".filters-option-bar .heading strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                $(".feat_slider").html(res[4]);
                $("form#search_form_ajax #dynamic_fields_topbar_on").html('');
                $("form#search_form_ajax #dynamic_fields_topbar_on").html(res[5]);
                $('.custom-checkbox').iCheck({checkboxClass: 'icheckbox_flat', radioClass: 'iradio_flat'});
                $('.dynamic_field_select').select2({allowClear: true});
                regenerate_slider();
                regenerate_masnory();
                regenerate_tiksy();
            }
        });
        dwt_listing_get_category_features(cat_id);
    });

    /*Sort*/
    $('#order_by').on('change', function () {
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $(".feat_slider").html('');
        $(".amenties").hide();
        var sort_by = $(this).val();
        $("#listing_ajax_pagination").html('');
        $.post(ajax_url, {
            action: 'dwt_ajax_search',
            collect_data: $("form#search_form_ajax").serialize(),
            sort_by: sort_by
        }).done(function (response) {
            $('.sk-circle').hide();
            if ($.trim(response) != "") {
                var res = response.split("|");
                $(".filters-option-bar .heading strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                $(".feat_slider").html(res[4]);
                regenerate_slider();
                regenerate_masnory();
                regenerate_tiksy();
            }
        });
    });


    //for filters
    $(document).on('click', '#d_getfilters', function () {
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $(".feat_slider").html('');
        $("#listing_ajax_pagination").html('');
        var sort_by = $("#order_by").val();
        $.post(ajax_url, {
            action: 'dwt_ajax_search',
            collect_data: $("form#search_form_ajax").serialize(),
            sort_by: sort_by
        }).done(function (response) {
            $('.sk-circle').hide();
            if ($.trim(response) != "") {
                var res = response.split("|");
                $(".filters-option-bar .heading strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                $(".feat_slider").html(res[4]);
                regenerate_slider();
                regenerate_masnory();
                regenerate_tiksy();
            }
        });
    });


    $('.has-clear input[type="text"]').on('input propertychange', function () {
        var $this = $(this);
        var visible = Boolean($this.val());
        $this.siblings('.form-control-clear').toggleClass('hidden', !visible);
    }).trigger('propertychange');

    $('.form-control-clear').on('click', function () {
        $(this).siblings('input[type="text"]').val('')
            .trigger('propertychange').focus();
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $(".feat_slider").html('');
        $("#listing_ajax_pagination").html('');
        $.post(ajax_url, {
            action: 'dwt_ajax_search',
            collect_data: $("form#search_form_ajax").serialize(),
        }).done(function (response) {
            $('.sk-circle').hide();
            if ($.trim(response) != "") {
                var res = response.split("|");
                $(".filters-option-bar .heading strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                $(".feat_slider").html(res[4]);
                regenerate_slider();
                regenerate_masnory();
                regenerate_tiksy();
            }
        });
    });

    if ($('.for_search_pages ').is('.specific_search')) {
        $('.for_search_pages').typeahead({
            minLength: 1,
            hint: true,
            maxItem: 15,
            order: "asc",
            dynamic: true,
            delay: 200,
            emptyTemplate: $("#no_s_result").val() + "{{query}}",
            source: {
                ajax: {type: "GET", url: ajax_url, data: {q: '{{query}}', action: 'fetch_listing_suggestions_search'}},
            },
            callback: {
                onCancel: function (node, event) {
                    $('.sk-circle').show();
                    $(".s_ajax").html('');
                    $(".feat_slider").html('');
                    $("#listing_ajax_pagination").html('');
                    $.post(ajax_url, {
                        action: 'dwt_ajax_search',
                        collect_data: $("form#search_form_ajax").serialize(),
                    }).done(function (response) {
                        $('.sk-circle').hide();
                        if ($.trim(response) != "") {
                            var res = response.split("|");
                            $(".filter-zone h3 strong").html(res[0]);
                            $(".s_ajax").html(res[1]);
                            $("#result_reset").html(res[2]);
                            $("#listing_ajax_pagination").html(res[3]);
                            $(".feat_slider").html(res[4]);
                            regenerate_masnory();
                            regenerate_tiksy();
                            regenerate_slider();
                        }
                    });
                }
            },
        });
    }


    /* Region */
    $('#region').select2({
        allowClear: true, width: '100%', rtl: is_rtlz,
        ajax: {
            url: ajax_url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search query
                    action: 'dwt_listingzones'
                };
            },
            processResults: function (data) {
                var options = [];
                if (data) {
                    $.each(data, function (index, text) {
                        options.push({id: text[0], text: text[1]});
                    });
                }
                return {
                    results: options
                };
            },
            cache: true
        },
        "language": {
            "errorLoading": function () {
                return search_strings.errorLoading;
            },
            "inputTooShort": function () {
                return search_strings.inputTooShort;
            },
            "searching": function () {
                return search_strings.searching;
            },
            "noResults": function () {
                return search_strings.noResults;
            }
        },
        minimumInputLength: 3,
    });

    /*Reset All Resutl*/
    $(document).on('click', '#reset_ajax_reslut', function () {
        $(".feat_slider").html('');
        $("#listing_ajax_pagination").html('');
        $("select").select2('destroy').val('').select2({width: '100%'});
        $('input[name="cost_range"]').attr('checked', false);
        $('input[name="l_price_type"]').val('');
        $('input[name="by_title"]').val('');
        $('input[name="street_address"]').val('');
        $('.has-clear input[type="text"]').val('');
        $('input[type="radio"]').removeAttr('checked').iCheck('update');
        $('input[type="checkbox"]').removeAttr('checked').iCheck('update');
        $('.sk-circle').show();
        dwt_listing_get_category_features('');
        $(".s_ajax").html('');
        $('.btn').removeClass('active');
        $.post(ajax_url, {
            action: 'dwt_ajax_search',
            collect_data: $("form#search_form_ajax").serialize(),
        }).done(function (response) {
            $('.sk-circle').hide();
            if ($.trim(response) != "") {
                var res = response.split("|");
                $(".filters-option-bar .heading strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                $(".feat_slider").html(res[4]);
                regenerate_slider();
                regenerate_masnory();
                regenerate_tiksy();
            }
        });
        return false;
    });

    /* pagination */
    $(document).on('click', '.fetch_result', function () {
        var page_no = $(this).attr("data-page-no");
         $(".s_ajax").height('auto');
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $(".feat_slider").html('');
        $("#listing_ajax_pagination").html('');
        var sort_by = $("#order_by").val();
        $.post(ajax_url, {
            action: 'dwt_ajax_search',
            collect_data: $("form#search_form_ajax").serialize(),
            page_no: page_no,
            sort_by: sort_by
        }).done(function (response) {
            $('.sk-circle').hide();
            if ($.trim(response) != "") {
                var res = response.split("|");
                $(".filters-option-bar .heading strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $(".feat_slider").html(res[4]);
                $("#listing_ajax_pagination").html(res[3]);
                regenerate_slider();
                regenerate_masnory();
                regenerate_tiksy();
            }
        });
    });

    /*fetch category features*/
    function dwt_listing_get_category_features(cat_id) {
        var category_id = cat_id;
        if (category_id != 'all') {
            $.post(ajax_url, {
                action: 'dwt_listing_get_cat_featurez_sidebar',
                category_id: category_id,
            }).done(function (response) {
                if ($.trim(response) != "") {
                    $(".amenties_ajax").show();
                    $(".amenties_ajax").html(response);
                    $('.custom-checkbox').iCheck({checkboxClass: 'icheckbox_flat', radioClass: 'iradio_flat'});
                } else {
                    $(".amenties").hide();
                    $(".amenties_ajax").hide();
                    $("#amenties-dropdown").html('');
                }
            });
        }
    }

    /* dynamic fields search with sidebar */
    $(document).on('ifChecked', '.multicheckbox_custom, .checkbox_radio', function () {
        dwt_dynamic_fields_search_filter(this);
    });

    /*Custom fields for uncheck checkbox, radio filter*/
    $(document).on('ifUnchecked', '.multicheckbox_custom', function () {
        dwt_dynamic_fields_search_filter(this);
    });
    /* Custom fields for Select filter */
    $(document).on('change', '.dynamic_field_select', function () {
        dwt_dynamic_fields_search_filter(this);
    });

    function dwt_dynamic_fields_search_filter() {
        var page_no = $(this).attr("data-page-no");
        $(".s_ajax").height('auto');
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $(".feat_slider").html('');
        $("#listing_ajax_pagination").html('');
        var sort_by = $("#order_by").val();
        $.post(ajax_url, {
            action: 'dwt_ajax_search',
            collect_data: $("form#search_form_ajax").serialize(),
            page_no: page_no,
            sort_by: sort_by
        }).done(function (response) {
            $('.sk-circle').hide();
            if ($.trim(response) != "") {
                var res = response.split("|");
                $(".filters-option-bar .heading strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                $(".feat_slider").html(res[4]);
                regenerate_masnory();
                regenerate_tiksy();
                regenerate_slider();
            }
        });
    }
})(jQuery);

function regenerate_masnory() {
    "use strict";
    // init Isotope
    var $item = $('.masonery_wrap');
    $item.imagesLoaded(function () {
        $item.isotope({
            itemSelector: '.masonery_item',
            percentPosition: true,
            originLeft: 'is_rtlz',
            layoutMode: 'fitRows',
            transitionDuration: '0.7s',
            masonry: {
                columnWidth: '.masonery_item'
            }
        });
    });
    window.sr = ScrollReveal({duration: 700, reset: false, mobile: false});
    sr.reveal('.foo');
}

function regenerate_tiksy() {
    "use strict";
    $('.tool-tip').tipsy({
        arrowWidth: 10,
        attr: 'data-tipsy',
        cls: null,
        duration: 150,
        offset: 7,
        position: 'top-center',
        trigger: 'hover',
    });
}

function regenerate_slider() {
    "use strict";
    if ($('#slider_type_2').length) {
        $("#slider_type_2").owlCarousel({
            rtl: is_rtlz,
            loop: true,
            margin: 0,
            dots: false,
            responsiveClass: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            nav: true,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 3,
                }
            }
        });
    }
}