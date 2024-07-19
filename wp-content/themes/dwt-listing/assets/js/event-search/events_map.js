(function ($) {
    "use strict";
    var ajax_url = $("input#dwt_listing_ajax_url").val();
    /*For Category Change*/
    $('#event_cat,#order_by').on('change', function () {
        $('.sk-circle').show();
        $(".masonery_wrap").html('');
        var map_col = 6;
        $("#listing_ajax_pagination").html('');
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize(), map_col: map_col}).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".results strong").html(res[0]);
                $(".masonery_wrap").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
                regenerate_masnory();
                map_regenerate();
            }
        });
    });

    /*For Title & Location*/
    $('#get_title,#get_locz,#get_start_date_filter').on('click', function () {
        $('.sk-circle').show();
        $(".masonery_wrap").html('');
        var map_col = 6;
        $("#listing_ajax_pagination").html('');
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize(), map_col: map_col}).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".results strong").html(res[0]);
                $(".masonery_wrap").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
                regenerate_masnory();
                map_regenerate();
            }
        });
    });




    /* Clear Input */
    $(document).on('input propertychange', '.has-clear input[type="text"]', function () {
        var $this = $(this);
        var visible = Boolean($this.val());
        $this.siblings('.form-control-clear').toggleClass('hidden', !visible);
    }).trigger('propertychange');

    $('.form-control-clear').on('click', function () {
        $(this).siblings('input[type="text"]').val('')
                .trigger('propertychange').focus();
        $('.sk-circle').show();
        $(".masonery_wrap").html('');
        var map_col = 6;
        $("#listing_ajax_pagination").html('');
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize(), map_col: map_col}).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".results strong").html(res[0]);
                $(".masonery_wrap").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
                regenerate_masnory();
                map_regenerate();
            }
        });

    });



    /*Reset All Resutl*/
    $(document).on('click', '#reset_ajax_reslut', function () {
        $("#d_events_filters").trigger('reset');
        $("#listing_ajax_pagination").html('');
        $("#event_cat").select2('destroy').val('').select2({width: '100%'});
        $('input[name="layout_type"]').val('');
        $('.has-clear input[type="text"]').val('');
        $('.sk-circle').show();
        var map_col = 6;
        $(".masonery_wrap").html('');
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize(), map_col: map_col}).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".results strong").html(res[0]);
                $(".masonery_wrap").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
                regenerate_masnory();
                map_regenerate();
            }
        });
    });



//pagination
    $(document).on('click', '.fetch_result', function () {
        var page_no = $(this).attr("data-page-no");
        $(this).addClass("active");
        $(".fetch_result").not(this).removeClass("active");
        $(".masonery_wrap").height('auto');
        $('.sk-circle').show();
        $(".masonery_wrap").html('');
        var map_col = 6;
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize(), page_no: page_no, map_col: map_col}).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".results strong").html(res[0]);
                $(".masonery_wrap").html(res[1]);
                $("#result_reset").html(res[2]);
                dwt_listing_countDownTimer_ajax();
                regenerate_masnory();
                map_regenerate();
            }
        });
    });


    var map_lat = parseFloat($('#map_lat').val());
    var map_long = parseFloat($('#map_long').val());
    if (map_lat && map_long)
    {
        var my_icons = document.getElementById('theme_path').value + "assets/images/map-pin.png";
        if ($('#map_event').length) {
            var map = L.map('map_event').setView([map_lat, map_long], 12);
            L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
            var myIcon = L.icon({iconUrl: my_icons, iconRetinaUrl: my_icons, iconSize: [38, 64], iconAnchor: [20, 60], popupAnchor: [0, -65]});
            var markerClusters = L.markerClusterGroup();
            if (typeof event_markers != 'undefined')
            {
                for (var i = 0; i < event_markers.length; ++i)
                {
                    var popup = '<div class="events-type-list"><div class="ads-list-archive"><div class="col-md-4 col-sm-4 col-xs-12 nopadding"><div class="ad-archive-img"><div class="event-imagez"><a href="' + event_markers[i].event_link + '"><img src="' + event_markers[i].img + '" alt="" class="img-responsive"></a></div></div></div><div class="col-md-8 col-sm-12 col-xs-12"><div class="ad-archive-desc">' + event_markers[i].cat + '<h3><a href="' + event_markers[i].event_link + '">' + event_markers[i].title + '</a></h3><div class="clearfix visible-xs-block"></div><div class="event-stats"><ul>' + event_markers[i].to + '' + event_markers[i].from + '' + event_markers[i].venue + '</ul></div></div></div></div></div>';
                    var m = L.marker([event_markers[i].lat, event_markers[i].lng], {icon: myIcon}).bindPopup(popup, {minWidth: 471, maxWidth: 471});
                    markerClusters.addLayer(m);
                    map.fitBounds(markerClusters.getBounds());
                    map.addLayer(markerClusters);
                }
                map.scrollWheelZoom.disable();
                map.invalidateSize();
            }
        }
    }



    /*Event timer*/
    function dwt_listing_countDownTimer_ajax() {
        if ($('.dwt_listing_custom-timer').length) {
            $('.dwt_listing_custom-timer').each(function () {
                var countDate = $(this).data('countdown-time'); // getting date
                $(this).countdown(countDate, function (event) {
                    $(this).html('<li> <div class="timer-countdown-box"> <span class="timer-days">' + event.strftime('%D') + '</span> <span class="timer-div">' + get_strings.coupon_days + '</span> </div> </li> <li> <div class="timer-countdown-box"> <span class="timer-hours">' + event.strftime('%H') + '</span> <span class="timer-div color-1">' + get_strings.coupon_hours + '</span> </div> </li> <li> <div class="timer-countdown-box"> <span class="timer-minutes">' + event.strftime('%M') + '</span> <span class="timer-div color-2">' + get_strings.coupon_minutes + '</span> </div> </li> <li> <div class="timer-countdown-box"> <span class="timer-seconds">' + event.strftime('%S') + '</span> <span class="timer-div color-3">' + get_strings.coupon_seconds + '</span> </div> </li>');
                });
            }).on('finish.countdown', function () {
                $(this).hide();
                $('.listing-coupon-block').hide();
            });
        }
    }


    function map_regenerate()
    {
        $('.map-zone').html('');
        $('.map-zone').html('<div id="map_event" class="map_event"></div>');
        var map_lat = parseFloat($('#map_lat').val());
        var map_long = parseFloat($('#map_long').val());
        if (search_strings.s_lat != '' && search_strings.s_lon != '')
        {
            map_lat = search_strings.s_lat;
            map_long = search_strings.s_lon;
        }
        if (map_lat && map_long)
        {
            var my_icons = document.getElementById('theme_path').value + "assets/images/map-pin.png";
            if ($('#map_event').length)
            {
                var map = L.map('map_event').setView([map_lat, map_long], 12);
                L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
                var myIcon = L.icon({iconUrl: my_icons, iconRetinaUrl: my_icons, iconSize: [38, 64], iconAnchor: [20, 60], popupAnchor: [0, -65]});
                var markerClusters = L.markerClusterGroup();
                if (typeof event_markers_ajax != 'undefined')
                {
                    for (var i = 0; i < event_markers_ajax.length; ++i)
                    {
                        var popup = '<div class="events-type-list"><div class="ads-list-archive"><div class="col-md-4 col-sm-4 col-xs-12 nopadding"><div class="ad-archive-img"><div class="event-imagez"><a href="' + event_markers_ajax[i].event_link + '"><img src="' + event_markers_ajax[i].img + '" alt="" class="img-responsive"></a></div></div></div><div class="col-md-8 col-sm-12 col-xs-12"><div class="ad-archive-desc">' + event_markers_ajax[i].cat + '<h3><a href="' + event_markers_ajax[i].event_link + '">' + event_markers_ajax[i].title + '</a></h3><div class="clearfix visible-xs-block"></div><div class="event-stats"><ul>' + event_markers_ajax[i].to + '' + event_markers_ajax[i].from + '' + event_markers_ajax[i].venue + '</ul></div></div></div></div></div>';
                        var m = L.marker([event_markers_ajax[i].lat, event_markers_ajax[i].lng], {icon: myIcon}).bindPopup(popup, {minWidth: 471, maxWidth: 471});
                        markerClusters.addLayer(m);
                        map.fitBounds(markerClusters.getBounds());
                        map.addLayer(markerClusters);
                    }
                    map.scrollWheelZoom.disable();
                    map.invalidateSize();
                }
            }
        }
    }

    function regenerate_masnory()
    {

        // init Isotope
        var $item = $('.masonery_wrap');
        $item.isotope('destroy');
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
    }


    function tip()
    {
        $('[data-toggle="tooltip"]').tooltip();
    }

})(jQuery);


