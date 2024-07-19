(function ($) {
    "use strict";
    var ajax_url = $("input#dwt_listing_ajax_url").val();

    /*--- Registration Form Action ---*/
    $('#register-form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented())
        {
            return false;
        }
        else
        {
            $('.sonu-button').button('loading');
            var pack_type = $('#pack_type').val();
            var pack_id = $('#pack_id').val();
            $.post(ajax_url, {
                action: 'dwt_listing_register_user',
                package_type: pack_type,
                package_id: pack_id,
                sb_data: $("form#register-form").serialize(), 
            }).done(function (response)
            {
                $('.sonu-button').button('reset');
                var get_r = response.split('|');

                if ($.trim(get_r[0]) == '1')
                {
                    $('#info-messages').hide();
                    $('#success-messages').show();
                    $('#register-form').hide();
                    window.setTimeout(function ()
                    {
                        window.location = $('#profile_page').val();
                    }, 1500);
                }
                else if ($.trim(get_r[0]) == '2')
                {
                    $('#warning-messages').show();
                    $('#register-form').hide();
                    $('.social-media-group').hide();
                }
                else if ($.trim(get_r[0]) == '3')
                {
                    $('#success-messages').show();
                    $('#register-form').hide();
                    $('#woo-pack').hide();
                    $('.social-media-group').hide();
                    window.setTimeout(function ()
                    {
                        window.location = get_r[1];
                    }, 1500);
                }
                else if ($.trim(get_r[0]) == '4')
                {
                    $('#success-messages').show();
                    $('#register-form').hide();
                    $('#woo-pack').hide();
                    $('.social-media-group').hide();
                    window.setTimeout(function ()
                    {
                        window.location = get_r[1];
                    }, 1500);
                }
                else if ($.trim(get_r[0]) == '5')
                {
                    $('#captcha-messages').show();
                }
                else
                {
                    $('#info-messages').show();
                }

            });
            /*--- stop submitting ---*/
            return false;
        }
    });

    /*Resend Email On Registration */
    $('#resend_email').on('click', function ()
    {
        var usr_email = $('#user-email').val();
        $.post(ajax_url, {action: 'dwt_listing_resend_email', usr_email: usr_email, }).done(function (response)
        {
            $('#warning-messages').hide();
            $('#not-getting-emails').show();

        });
    });

    /*--- Login Form Action ---*/

    $('#login-form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented())
        {
            return false;
        }
        else
        {
            $('.sonu-button').button('loading');
            $.post(ajax_url, {action: 'dwt_listing_login_user', collect_data: $("form#login-form").serialize(), }).done(function (response)
            {
                $('.sonu-button').button('reset');
                if ($.trim(response) == '1')
                {
                    $('#login-info-messages').hide();
                    $('#login-form').hide();
                    $('#login-success-messages').show();
                    window.setTimeout(function ()
                    {
                        window.location = $('#profile_page').val();
                    }, 1500);
                }
                else
                {
                    $('#login-info-messages').show();
                }
            });
            /*--- stop submitting ---*/
            return false;
        }
    });

    /*--- Forget Password ---*/
    $('#forget-password').validator().on('submit', function (e) {
        if (e.isDefaultPrevented())
        {
            return false;
        }
        else
        {
            $('.sonu-button').button('loading');
            $.post(ajax_url, {action: 'dwt_listing_forgot_password', collect_data: $("form#forget-password").serialize(), }).done(function (response)
            {
                $('.sonu-button').button('reset');
                if ($.trim(response) == '1')
                {
                    $('#not-responding').hide();
                    $('#not-exist').hide();
                    $('#forget-password').hide();
                    $('#forget-messages').show();
                }
                else if ($.trim(response) == '2')
                {
                    $('#not-exist').hide();
                    $('#not-responding').show();
                }
                else
                {
                    $('#not-responding').hide();
                    $('#not-exist').show();
                }
            });
        }
        return false;
    });

    /*--- Hide Login Model ---*/
    $("#modal_to_hide").on('click', function () {
        $('#myModal').modal('hide');
    });


    $(window).on('load', function () {
        $('#dwt_listing_reset_password_modal').modal('show');
    });


    /*--- Reset Password ---*/
    $('#dwt_listing_reset-password-form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented())
        {
            return false;
        }
        else
        {
            $('.sonu-button').button('loading');
            $.post(ajax_url, {action: 'dwt_listing_reset_password', collect_data: $("form#dwt_listing_reset-password-form").serialize(), }).done(function (response)
            {
                $('.sonu-button').button('reset');
                var get_r = response.split('|');
                if ($.trim(get_r[0]) == '1')
                {
                    $('#dwt_listing_reset-password-form').hide();
                    $('#token-expire').hide();
                    $('#password-success').show();
                    window.setTimeout(function ()
                    {
                        window.location = get_r[1];
                    }, 1500);
                }
                else
                {
                    $('#dwt_listing_reset-password-form').hide();
                    $('#token-expire').show();
                }

            });
        }
        return false;
    });

    /*--- Social Login Handlers ---*/
    if ($('#facebook_key').val() != "" && $('#google_key').val() != "")
    {
        // Hello JS
        hello.init({
            facebook: $('#facebook_key').val(),
            google: $('#google_key').val(),
        }, {redirect_uri: $('#redirect_uri').val()});
    }
    else if ($('#facebook_key').val() != "" && $('#google_key').val() == "")
    {
        // Hello JS
        hello.init({
            facebook: $('#facebook_key').val(),
        }, {redirect_uri: $('#redirect_uri').val()});
    }
    else if ($('#google_key').val() != "" && $('#facebook_key').val() == "")
    {
        // Hello JS
        hello.init({
            google: $('#google_key').val(),
        }, {redirect_uri: $('#redirect_uri').val()});
    }
    // Hello JS Hander
    $('.social a.circle').on('click', function ()
    {
        var pack_type = $('#pack_type').val();
        var pack_id = $('#pack_id').val();
        hello.on('auth.login', function (auth) {
            console.log(auth);
            // Call user information, for the given network
            hello(auth.network).api('me').then(function (r) {
                $('#for-social').show();
                $('#for-social').button('loading');
                $('#login-form').hide();
                $('#register-form').hide();
				
				var access_token = hello(auth.network).getAuthResponse().access_token;
                var sb_network = hello(auth.network).getAuthResponse().network;
				
                $.post(ajax_url, {
					action: 'dwt_listing_social_login',
					package_type: pack_type,
					package_id: pack_id,
					email: r.email,
					name: r.name,
					access_token: access_token,
                    sb_network: sb_network,
					}).done(function (response)
                {
                    $('#for-social').button('reset');

                    var get_r = response.split('|');
                    if ($.trim(get_r[0]) == '1')
                    {
                        $('.social-media-group').hide();
                        $('#social-success-login').show();
                        $('#woo-pack').hide();
                        $('#for-social').hide();
                        window.setTimeout(function ()
                        {
                            window.location = $('#profile_page').val();
                        }, 1500);
                    }
                    else if ($.trim(get_r[0]) == '2')
                    {
                        $('.social-media-group').hide();
                        $('#social-success-login').show();
                        $('#woo-pack').hide();
                        $('#for-social').hide();
                        window.setTimeout(function ()
                        {
                            window.location = get_r[1];
                        }, 1500);
                    }
                    else if ($.trim(get_r[0]) == '3')
                    {
                        $('.social-media-group').hide();
                        $('#social-success-login').show();
                        $('#woo-pack').hide();
                        $('#for-social').hide();
                        window.setTimeout(function ()
                        {
                            window.location = get_r[1];
                        }, 1500);
                    }
                    else
                    {
                        $('#woo-pack').hide();
                        $('#for-social').hide();
                        $('.social-media-group').hide();
                        $('#social-success-register').show();
                        window.setTimeout(function ()
                        {
                            window.location = $('#profile_page').val();
                        }, 1500);
                    }
                });
            });
        });
    });

    /*	LOGIN MODAL*/

    $(document.getElementsByClassName("register-form-swipe")[0]).click(function () {
        $('.loginBox').fadeOut('fast', function () {
            $('.registerBox').fadeIn('fast');
            $('.login-footer').fadeOut('fast', function () {
                $('.register-footer').fadeIn('fast');
            });
            $('.modal-title').html(get_strings.regz);
        });
    });

    $(document.getElementsByClassName("login-form-swipe")[0]).click(function () {
        $('.registerBox').fadeOut('fast', function () {
            $('.loginBox').fadeIn('fast');
            $('.register-footer').fadeOut('fast', function () {
                $('.login-footer').fadeIn('fast');
            });
            $('.modal-title').html(get_strings.logz);
        });
    });
})(jQuery);