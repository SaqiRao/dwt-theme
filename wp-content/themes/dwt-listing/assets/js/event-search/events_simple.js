(function ($) {
    "use strict";
    var ajax_url = $("input#dwt_listing_ajax_url").val();
    $('button[name=type]').on('click', function () {
        $('input[name=layout_type]').val($(this).val());
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $("#listing_ajax_pagination").html('');
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize()}).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".listing-sort__result strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
            }
        });
    });


    /*For Title & Location*/
    $('#get_title,#get_locz,#get_start_date_filter,#get_end_date_filter').on('click', function () {
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $("#listing_ajax_pagination").html('');
        var curent_lang = $('#lang').val();
        $.post(ajax_url, {action: 'dwt_ajax_search_events', lang: curent_lang, collect_data: $("form#d_events_filters").serialize(), }).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".listing-sort__result strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
            }
        });
    });


    /*For Category Change*/
    $('#event_cat,#order_by').on('change', function () { 
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $("#listing_ajax_pagination").html('');
        var curent_lang = $('#lang').val();
        $.post(ajax_url, {action: 'dwt_ajax_search_events', lang: curent_lang, collect_data: $("form#d_events_filters").serialize(), }).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".listing-sort__result strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
            }
        });
    });




//pagination
    $(document).on('click', '.fetch_result', function () {
        var page_no = $(this).attr("data-page-no");
        $(this).addClass("active");
        $(".fetch_result").not(this).removeClass("active");
        $(".s_ajax").height('auto');
        $('.sk-circle').show();
        $(".s_ajax").html('');
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize(), page_no: page_no}).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".listing-sort__result strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                dwt_listing_countDownTimer_ajax();
            }
        });
    });



    /* Clear Input */
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
        $("#listing_ajax_pagination").html('');
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize(), }).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".listing-sort__result strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
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
        $(".s_ajax").html('');
        $.post(ajax_url, {action: 'dwt_ajax_search_events', collect_data: $("form#d_events_filters").serialize(), }).done(function (response)
        {
            $('.sk-circle').hide();
            if ($.trim(response) != "")
            {
                var res = response.split("|");
                $(".listing-sort__result strong").html(res[0]);
                $(".s_ajax").html(res[1]);
                $("#result_reset").html(res[2]);
                $("#listing_ajax_pagination").html(res[3]);
                dwt_listing_countDownTimer_ajax();
            }
        });
    });

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



})(jQuery);
