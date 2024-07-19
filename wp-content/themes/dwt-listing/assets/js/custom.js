(function ($) {
  "use strict";

  var ajax_url = $("input#dwt_listing_ajax_url").val();
  var yes_rtl;
  if ($("#is_rtl").val() !== "" && $("#is_rtl").val() === "1") {
    yes_rtl = true;
  } else {
    yes_rtl = false;
  }
  $(".top-loc-selection").on("click", function () {
    var loc_id = $(this).attr("data-loc-id");
    Cookies.set("dwt_cookie_location", loc_id, { expires: 365 });
    window.location.reload();
  });
  $("#sort-author").on("change", function () {
    $("#dwt_listing_loading").show();
  });
  $("#reset_a_filterz").on("click", function () {
    window.location.href = window.location.href.split("?")[0];
  });
  $("#fancyLaunch").on("click", function () {
    $(".minimal.fancybox").eq(0).click();
    $(".minimal.fancybox").fancybox();
  });
  /* Delete Menu Type */
  $(document).on("click", ".delete-lmenu", function () {
    var listing_id = $(this).attr("data-id");
    var key = $(this).attr("data-key");
    $(".delete-button-" + key).button("loading");
    var el = this;
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      closeIcon: false,
      content: get_strings.content,
      closeAnimation: "scale",
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "dwt_delete_menutype",
              listing_id: listing_id,
              key: key,
            }).done(function (response) {
              $(".delete-button-" + key).button("reset");
              $(el).closest("tr").css("background", "tomato");
              $(el)
                .closest("tr")
                .fadeOut(800, function () {
                  $(this).remove();
                });
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
          action: function () {
            $(".delete-button-" + key).button("reset");
          },
        },
      },
    });
    return false;
  });
  /* Delete Menu Items */
  $(document).on("click", ".delete-inner-menu", function () {
    var listing_id = $(this).attr("data-listing_id");
    var key = $(this).attr("data-refer_key");
    $(".delete-buttonz-" + key).button("loading");
    var el = this;
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      closeIcon: false,
      content: get_strings.content,
      closeAnimation: "scale",
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "dwt_listing_delete_inner_menutype",
              listing_id: listing_id,
              key: key,
            }).done(function () {
              $(".delete-buttonz-" + key).button("reset");
              $(el).closest("tr").css("background", "tomato");
              $(el)
                .closest("tr")
                .fadeOut(800, function () {
                  $(this).remove();
                });
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
          action: function () {
            $(".delete-buttonz-" + key).button("reset");
          },
        },
      },
    });
    return false;
  });
  $(document).on("click", ".hide_me", function () {
    $("body").addClass("modal-open-noscroll");
    $(".menu_item_history").modal("hide");
    $(".menu_modalz_itemz").modal("show");
  });
  $(document).on("click", ".added_new_itemz", function () {
    $("body").addClass("modal-open-noscroll");
  });
  if ($("#timezone").is(".my-zones")) {
    var tzones =
      document.getElementById("theme_path").value + "assets/js/zones.json";
    $.get(
      tzones,
      function (data) {
        typeof $.typeahead === "function" &&
          $.typeahead({
            input: ".myzones-t",
            minLength: 0,
            emptyTemplate: get_strings.no_r_for + "{{query}}",
            searchOnFocus: true,
            blurOnTab: true,
            order: "asc",
            hint: true,
            source: data,
            debug: false,
          });
      },
      "json"
    );
  }

  if ($(".for_sp_home").is(".dwt-search")) {
    $(".dwt-search").typeahead({
      minLength: 1,
      hint: true,
      maxItem: 15,
      order: "asc",
      dynamic: true,
      delay: 200,
      emptyTemplate: get_strings.no_r_for + "{{query}}",
      source: {
        listings: {
          href: "{{link}}",
          display: ["with_title"],
          ajax: [
            {
              type: "GET",
              url: ajax_url,
              data: { q: "{{query}}", action: "fetch_suggestions" },
            },
            "data.listings",
          ],
          template:
            '<span class="row">' +
            '<span class="search-avatar">' +
            '<img src="{{img}}" alt="{{with_title}}" >' +
            "</span>" +
            '<span class="l-title">{{with_title}} </span>' +
            "</span>",
        },
        categories: {
          display: ["cat_name"],
          ajax: [
            {
              type: "GET",
              url: ajax_url,
              data: { q: "{{query}}", action: "fetch_suggestions" },
            },
            "data.categories",
          ],
          template:
            '<span class="search-catz"><i class="{{cat_icon}}"></i></span> <span>{{cat_name}}</span>',
        },
        tags: {
          display: ["tag_name"],
          ajax: [
            {
              type: "GET",
              url: ajax_url,
              data: { q: "{{query}}", action: "fetch_suggestions" },
            },
            "data.tags",
          ],
          template:
            '<span class="tags"><i class="{{tag_icon}}"></i></span> <span>{{tag_name}}</span>',
        },
      },
      callback: {
        onCancel: function (node, event) {
          $("input#l_category_home").val("");
          $("input[name='by_title']").val("");
          $("input#l_tag_home").val("");
        },
        onResult: function (node, q, result, resultCount) {
          if (q === "") return;
          if (result.length > 0) {
            $("input#by_title_home").val(q);
            $("input#l_category_home").val("");
            $("input#l_tag_home").val("");
          } else {
            $("input#by_title_home").val(q);
            $("input#l_category_home").val("");
            $("input#l_tag_home").val("");
          }
        },
        onClickAfter: function (node, a, item, event) {
          $("input#l_category_home").val("");
          $("input#by_title_home").val("");
          $("input#l_tag_home").val("");
          if (item.group === "categories") {
            $("input[name='by_title_home']").val("");
            $("input#l_category_home").val(item.id);
          } else if (item.group === "tags") {
            $("input[name='by_title_home']").val("");
            $("input#l_tag_home").val(item.id);
          } else {
            $("input#l_category_home").val("");
            $("input[name='by_title_home']").val("");
            $("input#l_tag_home").val("");
          }
        },
      },
    });
  }

  if ($(".typed").is(".typed-words")) {
    var typed3 = new Typed(".typed-words", {
      strings: get_typed.type_strings,
      typeSpeed: 80,
      backSpeed: 80,
      backDelay: 3000,
      startDelay: 1000,
      loop: true,
      showCursor: true,
    });
  }

  if ($(".dget_listings ").is(".for_s_home")) {
    $(".dget_listings").typeahead({
      minLength: 1,
      hint: true,
      maxItem: 15,
      order: "asc",
      dynamic: true,
      delay: 200,
      emptyTemplate: get_strings.no_r_for + "{{query}}",
      source: {
        listings: {
          display: ["with_title"],
          href: "{{link}}",
          ajax: [
            {
              type: "GET",
              url: ajax_url,
              data: { q: "{{query}}", action: "fetch_listing_suggestions" },
            },
            "data.listings",
          ],
          template:
            '<span class="row">' +
            '<span class="search-avatar">' +
            '<img src="{{img}}" alt="{{with_title}}" >' +
            "</span>" +
            '<span class="l-title">{{with_title}} </span>' +
            "</span>",
        },
      },
    });
  }

  var ip_type = $("#ip_type").val();
  if (typeof ip_type != "undefined") {
    console.log("ip_type", ip_type);
    $(".specific-search > i.detect-me").on("click", function (e) {
      e.preventDefault();
      $(this).addClass("fa-circle-o-notch fa-spin extra-spin");
      $(this).removeClass("fa-crosshairs");
      if (ip_type == "geo_ip") {
        $.ajax({
          type: "POST",
          url: ajax_url,
          data: { action: "check_my_key" },
          success: function (data) {
            if (data.success) {
              var city = data.data.city;
              var latitude = data.data.latitude;
              var longitude = data.data.longitude;
              $("input#address_location").val(city);
              if (get_strings.map_type == "open_street") {
                $("input#search_lat").val(latitude);
                $("input#search_lon").val(longitude);
                console.log("openstreet");
              }
              $(".specific-search > i").fadeOut("slow");
            } else {
              $.getJSON("http://ip-api.com/json/?callback=?").done(function (
                location
              ) {
                $("input#address_location").val(location.city);
                if (get_strings.map_type == "open_street") {
                  $("input#search_lat").val(location.latitude);
                  $("input#search_lon").val(location.longitude);
                }
                $(".specific-search > i").fadeOut("slow");
              });
            }
          },
          error: function (xhr, status, error) {
            console.error("Error occurred:", error);
          },
        });
      } else {
        $.get(
          "https://ipapi.co/json",
          function (location) {
            $("input#address_location").val(location.city);

            if (get_strings.map_type == "open_street") {
              $("input#search_lat").val(location.latitude);
              $("input#search_lon").val(location.longitude);
            }
            $(".specific-search > i").fadeOut("slow");
          },
          "json"
        );
      }
    });

    if (
      $(".home-main-2").is(".for-my-locz") ||
      $(".event-hero-intro").is(".for-my-locz")
    ) {
      if (ip_type == "geo_ip") {
        $.getJSON("https://geoip-db.com/json/geoip.php?jsonp=?").done(function (
          location
        ) {
          $(".my-current-location").text(location.city);
          $("input#address_location").val(location.city);
        });
      } else {
        $.get(
          "https://ipapi.co/json",
          function (location) {
            $(".my-current-location").text(location.city);
            $("input#address_location").val(location.city);
          },
          "json"
        );
      }
    }
  }

  if ($(".sticky-event").length) {
    $(".sticky-event").theiaStickySidebar({
      // Settings
      additionalMarginBottom: 40,
    });
  }

  if ($(".custom-checkbox").length) {
    $(".custom-checkbox").iCheck({
      checkboxClass: "icheckbox_flat",
      radioClass: "iradio_flat",
    });
  }

  if ($("#listing_tags").length) {
    $("#listing_tags").tagEditor({ placeholder: get_strings.tagz });
  }

  $('[data-toggle="tooltip"]').tooltip();
  /* Report Listing */
  $("#dwt_listing_news_latter")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var user_email = $("#news_email").val();
        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "dwt_listing_mailchimp_subcribe",
          user_email: user_email,
        }).done(function (response) {
          $(".sonu-button").button("reset");
          if (response == 1) {
            $.alert({
              title: get_strings.congratulations,
              closeIcon: true,
              rtl: yes_rtl,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: get_strings.newsletter_success,
              backgroundDismiss: true,
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          } else {
            $.alert({
              title: get_strings.whoops,
              closeIcon: true,
              rtl: yes_rtl,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              backgroundDismiss: true,
              content: get_strings.newsletter_error,
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
        return false;
      }
    });

  if ($("a.play-video").length) {
    $("a.play-video").YouTubePopUp();
  }

  /* Expire My Listing */
  $(".delete-my-account").on("click", function () {
    var user_id = $(this).attr("data-userid");
    $(".delete-my-account").button("loading");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.del,
      closeAnimation: "scale",
      type: "red",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "dwt_listing_delete_myaccount",
              user_id: user_id,
            }).done(function (response) {
              $(".delete-my-account").button("reset");
              if ($.trim(response) == "1") {
                $.alert({
                  title: get_strings.whoops,
                  closeIcon: true,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  content: get_strings.admin_cant,
                  backgroundDismiss: true,
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              } else {
                $.alert({
                  title: get_strings.miss,
                  closeIcon: true,
                  backgroundDismiss: true,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "green",
                  content: get_strings.acn_deleted,
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
                window.setTimeout(function () {
                  window.location = response;
                }, 1500);
              }
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
          action: function () {
            $(".sonu-button").button("reset");
          },
        },
      },
    });
    return false;
  });
  $(".show-more-button").on("click", function () {
    $("li.show_more").slideToggle("fast");
    $("i", this).toggleClass("ti-angle-down ti-angle-up");
  });
  /* Header Menu Category */
  $(".menuz-categories").on("click", function () {
    var category_id = $(this).attr("data-category-id");
    $("input[name=l_category]").val(category_id);
  });
  /* Expire My Listing */
  $(".expire-my-listings").on("click", function () {
    var listing_id = $(this).attr("data-listing-id");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.expiry,
      closeAnimation: "scale",
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "expire_my_listing",
              listing_id: listing_id,
            }).done(function (response) {
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $.alert({
                  title: get_strings.congratulations,
                  closeIcon: true,
                  rtl: yes_rtl,
                  icon: "fa fa-smile-o",
                  theme: "modern",
                  animation: "scale",
                  type: "green",
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
                window.setTimeout(function () {
                  location.reload();
                }, 1500);
              } else {
                $.alert({
                  title: get_strings.whoops,
                  closeIcon: true,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  backgroundDismiss: true,
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              }
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
        },
      },
    });
    return false;
  });
  /* Expire My Listing */
  $(".reactive-my-listings").on("click", function () {
    var listing_id = $(this).attr("data-listing-id");
    $(".sonu-buttonz-" + listing_id).button("loading");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.content,
      closeAnimation: "scale",
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "reactive_my_listing",
              listing_id: listing_id,
            }).done(function (response) {
              $(".sonu-buttonz-" + listing_id).button("reset");
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $.alert({
                  title: get_strings.congratulations,
                  closeIcon: true,
                  rtl: yes_rtl,
                  icon: "fa fa-smile-o",
                  theme: "modern",
                  animation: "scale",
                  type: "green",
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
                window.setTimeout(function () {
                  location.reload();
                }, 1500);
              } else {
                $.alert({
                  title: get_strings.whoops,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  closeIcon: true,
                  backgroundDismiss: true,
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              }
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
          action: function () {
            $(".sonu-buttonz-" + listing_id).button("reset");
          },
        },
      },
    });
    return false;
  });

  /* Track user activity analytics */

  $(".track-me").on("click", function () {
    var web_clicks = $(this).attr("data-web-clicks");
    var con_clicks = $(this).attr("data-con-clicks");
    var total_views = $(this).attr("data-view-clicks");
    var total_clicks = $(this).attr("data-total-clicks");
    $("#myChart").remove();
    $(".loginBox").append('<canvas  id="myChart"  height="250" ></canvas>');
    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: [
          get_strings.views,
          get_strings.webclick,
          get_strings.contactclick,
          get_strings.total,
        ],
        datasets: [
          {
            label: "",
            data: [total_views, web_clicks, con_clicks, total_clicks],
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(255, 206, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
            ],
            borderColor: [
              "rgba(255,99,132,1)",
              "rgba(54, 162, 235, 1)",
              "rgba(255, 206, 86, 1)",
              "rgba(75, 192, 192, 1)",
            ],
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
            },
          ],
        },
      },
    });
  });
  /* Track user activity */

  var is_tracking_on = $("#is_tracking_on").val();
  if (is_tracking_on == "1") {
    $(".track-me a").on("click", function () {
      var listing_id = $(this).attr("data-listing-id");
      var lead_choice = $(this).attr("data-reaction");
      $.ajax({
        type: "POST",
        url: ajax_url,
        async: false,
        data: {
          action: "track_my_leadz",
          listing_id: listing_id,
          lead_type: lead_choice,
        },
        success: function (data) {},
      });
    });
  }

  /* Delete My Submitted Reviews */
  $(".delete-my-sub-rev").on("click", function () {
    var comment_id = $(this).attr("data-comment-id");
    var listing_id = $(this).attr("data-listing-id");
    $(".sonu-button-" + comment_id).button("loading");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.content,
      closeAnimation: "scale",
      closeIcon: true,
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "remove_my_submitted_reviews",
              comment_id: comment_id,
              listing_id: listing_id,
            }).done(function (response) {
              $(".sonu-button-" + comment_id).button("reset");
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $(".unique-key-" + comment_id).fadeOut("slow");
              } else {
                $.alert({
                  title: get_strings.whoops,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  closeIcon: true,
                  backgroundDismiss: true,
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              }
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
          action: function () {
            $(".sonu-button-" + comment_id).button("reset");
          },
        },
      },
    });
    return false;
  });
  /* Delete My Listings */
  $(".delete-my-listings").on("click", function () {
    var listing_id = $(this).attr("data-listing-id");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.content,
      closeAnimation: "scale",
      closeIcon: true,
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "remove_my_listing",
              listing_id: listing_id,
            }).done(function (response) {
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $(".unique-key-" + listing_id).fadeOut("slow");
              } else {
                $.alert({
                  title: get_strings.whoops,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  closeIcon: true,
                  backgroundDismiss: true,
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              }
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
        },
      },
    });
    return false;
  });
  /*== remove listing from timekit booking ==*/
  $(".delete-my-listings-timekit").on("click", function () {
    var listing_id = $(this).attr("data-listing-id");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.content,
      closeAnimation: "scale",
      closeIcon: true,
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "remove_my_listing_timekit",
              listing_id: listing_id,
            }).done(function (response) {
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $(".unique-key-" + listing_id).fadeOut("slow");
              } else {
                $.alert({
                  title: get_strings.whoops,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  closeIcon: true,
                  backgroundDismiss: true,
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              }
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
        },
      },
    });
    return false;
  });

  /*== remove listing from reservation booking admin-side ==*/

  $(".delete-my-reservation-listings").on("click", function () {
    var listing_id = $(this).attr("data-listing-id");
    $(".sonu-button-" + listing_id).button("loading");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      closeIcon: true,
      content: get_strings.content,
      closeAnimation: "scale",
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "remove_my_reservation_listing",
              listing_id: listing_id,
            }).done(function (response) {
              // $('.sonu-button-' + listing_id).button('reset');
              var get_r = response.split("|");

              if ($.trim(get_r[0]) == "1") {
                $.alert({
                  title: get_strings.congratulations,
                  rtl: yes_rtl,
                  icon: "fa fa-smile-o",
                  theme: "modern",
                  animation: "scale",
                  type: "green",
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
                window.setTimeout(function () {
                  location.reload();
                }, 1500);
              } else {
                $.alert({
                  title: get_strings.whoops,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  closeIcon: true,
                  backgroundDismiss: true,
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              }
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
          // action: function() {
          //     $('.sonu-button-' + listing_id).button('reset');
          //   }
        },
      },
    });
    return false;
  });

  /*== Initialize Air Datepicker ==*/
  new AirDatepicker(".datepicker-here-custom", {
    multipleDates: true,
    dateFormat: "yyyy-mm-dd",
    locale: {
      days: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
      daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
      months: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      monthsShort: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      today: "Today",
      clear: "Clear",
      dateFormat: "mm/dd/yyyy",
      timeFormat: "hh:ii aa",
      firstDay: 0,
    },
    position: "right center",
  });

  /*== Edit listing Reservation */
  $(".edit-booking").click(function () {
    var listing_id = $(this).attr("data-listing-id");
    $.post(ajax_url, {
      action: "edit_booking_reservation_action",
      listing_id: listing_id,
    }).done(function (response) {
      // console.log(response);
      if (response.success) {
        let title = response.data.title;
        let type_of_ads = response.data.type_of_ads;
        // console.log(response.data.price_of_table[0]);

        // code title
        let menu_parent = $("#menu_parent_listingz");
        var option = new Option(title, listing_id, true, true);
        menu_parent.append(option).trigger("change");

        // code for subscription
        $("#subscription").val(response.data.type_of_ads);
        // console.log(response.data.type_of_ads[0]);
        var priceField = $(".table_reservation_price");
        if (type_of_ads === "paid") {
          priceField.show();
          $("#table_price").val(response.data.price_of_table);
          $("#table_slot_duration").val(response.data.table_slot_duration);

          // code converting date types
          let dates = response.data.restricted_days;

          var datesArray = dates.split(",").map((date) => date.trim());

          // console.log("datesArray", datesArray);

          const convertedDates = datesArray.map((dateString) => {
            const [day, month, year] = dateString.split(".");
            const formattedDate = new Date(`${month}/${day}/${year}`);
            const formattedDateString = `${formattedDate.getFullYear()}-${(
              "0" +
              (formattedDate.getMonth() + 1)
            ).slice(-2)}-${("0" + formattedDate.getDate()).slice(-2)}`;
            return formattedDateString;
          });

          $(".datepicker-here-custom .air-datepicker").remove();
          // air datepicker
          new AirDatepicker(".datepicker-here-custom", {
            multipleDates: true,
            locale: {
              days: [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
              ],
              daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
              daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
              months: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
              ],
              monthsShort: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
              ],
              today: "Today",
              clear: "Clear",
              firstDay: 0,
            },
            position: "right center",
            selectedDates: convertedDates,
          });
        } else {
          priceField.hide();
        }
      } else {
        alert("request failed");
      }
    });
  });

  /*== Add timekit booking after button click admin-side. ==*/
  $("#make-boking-form")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var select_list_id = $("#select-timekitListing").val();
        var form_code = $("#timekitwidget").val();
        $.confirm({
          title: get_strings.confirmation,
          icon: "fa fa-question-circle",
          theme: "supervan",
          animation: "scale",
          content: get_strings.content,
          closeAnimation: "scale",
          closeIcon: true,
          type: "green",
          buttons: {
            confirm: {
              text: get_strings.ok,
              action: function () {
                $(".sonu-button").button("loading");
                $.post(ajax_url, {
                  action: "add_timekit_form_with_listing",
                  select_list_id: select_list_id,
                  form_code: form_code,
                }).done(function (response) {
                  $(".sonu-button").button("reset");
                  var get_r = response.split("|");
                  if ($.trim(get_r[0]) == "1") {
                    $("#make-boking-form")[0].reset();
                    $.alert({
                      title: get_strings.congratulations,
                      rtl: yes_rtl,
                      icon: "fa fa-smile-o",
                      theme: "modern",
                      animation: "scale",
                      type: "green",
                      content: get_r[1],
                      buttons: { okay: { btnClass: "btn-blue" } },
                    });
                    window.setTimeout(function () {
                      location.reload();
                    }, 1500);
                  } else if ($.trim(get_r[0]) == "2") {
                    $.alert({
                      title: get_strings.whoops,
                      rtl: yes_rtl,
                      icon: "fa fa-frown-o",
                      theme: "modern",
                      animation: "scale",
                      type: "red",
                      closeIcon: true,
                      backgroundDismiss: true,
                      content: get_r[1],
                      buttons: { okay: { btnClass: "btn-blue" } },
                    });
                  } else {
                    $.alert({
                      title: get_strings.whoops,
                      rtl: yes_rtl,
                      icon: "fa fa-frown-o",
                      theme: "modern",
                      animation: "scale",
                      type: "red",
                      closeIcon: true,
                      backgroundDismiss: true,
                      content: get_r[1],
                      buttons: { okay: { btnClass: "btn-blue" } },
                    });
                  }
                });
              },
            },
            cancle: {
              text: get_strings.cancle,
            },
          },
        });
        return false;
      }
    });

  /* Delete Favourite Bookmark Listings */
  $(".delete-bookmark-listings").on("click", function () {
    var listing_id = $(this).attr("data-listing-id");
    $(".sonu-button-" + listing_id).button("loading");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      closeIcon: true,
      content: get_strings.content,
      closeAnimation: "scale",
      type: "green",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "remove_fav_bookmark",
              listing_id: listing_id,
            }).done(function (response) {
              $(".sonu-button-" + listing_id).button("reset");
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $.alert({
                  title: get_strings.congratulations,
                  rtl: yes_rtl,
                  icon: "fa fa-smile-o",
                  theme: "modern",
                  animation: "scale",
                  type: "green",
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
                window.setTimeout(function () {
                  location.reload();
                }, 1500);
              } else {
                $.alert({
                  title: get_strings.whoops,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  closeIcon: true,
                  backgroundDismiss: true,
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              }
            });
          },
        },
        cancle: {
          text: get_strings.cancle,
          action: function () {
            $(".sonu-button-" + listing_id).button("reset");
          },
        },
      },
    });
    return false;
  });
  /* Business Hours Selection */
  $(".tab-pane .custom-checkbox").on("ifChecked", function (event) {
    var checkbox = $(this).attr("value");
    if ($(this).is(":checked")) {
      $("#to-" + checkbox).prop("readonly", true);
      $("#from-" + checkbox).prop("readonly", true);
    } else {
      $("#to-" + checkbox).prop("readonly", false);
      $("#from-" + checkbox).prop("readonly", false);
    }
  });
  /*For Business Hours*/
  $(document).on(
    "ifChecked",
    '.frontend_hours input[type="radio"]',
    function () {
      var valzz = $(this).val();
      $("input[name=hours_type]").val(valzz);
      if (valzz == 2) {
        $("#timezone").removeClass("none");
        $("#business-hours-fields").removeClass("none");
        $("input#timezones").prop("required", true);
      } else {
        $("#timezone").addClass("none");
        $("#business-hours-fields").addClass("none");
        $("input#timezones").prop("required", false);
      }
    }
  );
  if ($('.frontend_hours input[type="radio"]').is(":checked")) {
    var selected_valz = $("#hours_type").val();
    if (selected_valz == 2) {
      $("#timezone").removeClass("none");
      $("#business-hours-fields").removeClass("none");
      $("input#timezones").prop("required", true);
    } else {
      $("#timezone").addClass("none");
      $("#business-hours-fields").addClass("none");
      $("input#timezones").prop("required", false);
    }
  }
  if ($('.frontend_hours input[type="radio"]').is(":checked")) {
    $(".reservation_section").css("display", "none");
  }

  if ($(".for_specific_page").is(".timepicker")) {
    $(".timepicker").timeselect({
      step: 15,
      autocompleteSettings: { autoFocus: true },
    });
  }

  $("#review-formz").on("click", function () {
    $("html, body").animate(
      {
        scrollTop: $("#review-form").offset().top,
      },
      2000
    );
  });
  /* Emoji Reaction Against Reviews  */
  $(".Emoji").on("click", function () {
    var reaction_id = $(this).data("reaction");
    var c_id = $(this).data("cid");
    $("#reaction-loader-" + c_id).show();
    $.post(ajax_url, {
      action: "dwt_listing_listing_reaction",
      r_id: reaction_id,
      c_id: c_id,
    }).done(function (response) {
      $("#reaction-loader-" + c_id).hide();
      var get_r = response.split("|");
      if ($.trim(get_r[0]) == "0") {
        $.alert({
          title: get_strings.whoops,
          closeIcon: true,
          rtl: yes_rtl,
          backgroundDismiss: true,
          icon: "fa fa-frown-o",
          theme: "modern",
          animation: "scale",
          type: "red",
          content: get_r[1],
          buttons: { okay: { btnClass: "btn-blue" } },
        });
        return false;
      } else {
        if (reaction_id === 1) {
          $(".emoji-count.likes-" + c_id).text(response);
        }
        if (reaction_id === 2) {
          $(".emoji-count.loves-" + c_id).text(response);
        }
        if (reaction_id === 3) {
          $(".emoji-count.wows-" + c_id).text(response);
        }
        if (reaction_id === 4) {
          $(".emoji-count.angrys-" + c_id).text(response);
        }
      }
    });
    return false;
  });
  /*Mark As Featured*/
  $(".btn-confirm").on("click", function () {
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      content: get_strings.content,
      closeIcon: true,
      animation: "scale",
      type: "green",
      buttons: {
        ok: {
          text: get_strings.ok,
          action: function () {
            $(".sonu-button").button("loading");
            var listing_id = $(".btn-confirm").attr("data-id");
            $.post(ajax_url, {
              action: "make_listing_featured",
              listing_id: listing_id,
            }).done(function (response) {
              $(".sonu-button").button("reset");
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $.alert({
                  title: get_strings.congratulations,
                  rtl: yes_rtl,
                  icon: "fa fa-smile-o",
                  theme: "modern",
                  animation: "scale",
                  type: "green",
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
                window.setTimeout(function () {
                  location.reload();
                }, 1500);
              } else {
                $.alert({
                  title: get_strings.whoops,
                  closeIcon: true,
                  backgroundDismiss: true,
                  rtl: yes_rtl,
                  icon: "fa fa-frown-o",
                  theme: "modern",
                  animation: "scale",
                  type: "red",
                  content: get_r[1],
                  buttons: { okay: { btnClass: "btn-blue" } },
                });
              }
            });
          },
        },
        cancle: { text: get_strings.cancle },
      },
    });
  });
  /*Lisitng Images Sorting*/
  $("#sortable").sortable({
    stop: function (event, ui) {
      $("#listing_img_ids").val("");
      var current_img = "";
      $(".ui-state-default img").each(function (index) {
        current_img = current_img + $(this).attr("data-img-id") + ",";
      });
      $("#listing_img_ids").val(current_img.replace(/,\s*$/, ""));
    },
  });
  /*Lisitng Images Sorting*/
  $("#listing_sort_images").on("click", function () {
    $(".sonu-button").button("loading");
    $.post(ajax_url, {
      action: "dwt_listing_sort_listing_images",
      ids: $("#listing_img_ids").val(),
      listing_id: $("#current_listing_id").val(),
    }).done(function (response) {
      $(".sonu-button").button("reset");
      location.reload();
    });
  });
  /*Lisitng Slider*/
  $(".flexslider").flexslider({
    rtl: yes_rtl,
    animation: "slide",
    controlNav: "thumbnails",
  });
  $(".jqte-test").jqte();
  if (get_strings.map_type == "google_map" && get_strings.google_key == "1") {
    var listing_latt = $("#listing_latt").val();
    var listing_long = $("#listing_long").val();
    if (listing_latt && listing_long) {
      var map = "";
      var latlng = new google.maps.LatLng(listing_latt, listing_long);
      var myOptions = {
        zoom: 13,
        center: latlng,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
      };
      map = new google.maps.Map(document.getElementById("map"), myOptions);
      var marker = new google.maps.Marker({
        map: map,
        position: latlng,
        animation: google.maps.Animation.BOUNCE,
      });
    }
    if (listing_latt && listing_long) {
      $(".listing_street_address").on("click", function () {
        var panorama;
        panorama = new google.maps.StreetViewPanorama(
          document.getElementById("map"),
          {
            position: {
              lat: parseFloat(listing_latt),
              lng: parseFloat(listing_long),
            },
            pov: { heading: 165, pitch: 0 },
            zoom: 1,
          }
        );
      });
    }
  }

  if (
    get_strings.map_type == "open_street" &&
    get_strings.is_map_enabled == "1"
  ) {
    var listing_latt = parseFloat($("#listing_latt").val());
    var listing_long = parseFloat($("#listing_long").val());
    if (listing_latt && listing_long) {
      var my_icons =
        document.getElementById("theme_path").value +
        "assets/images/map-pin.png";
      var myIconz = L.icon({
        iconUrl: my_icons,
        iconRetinaUrl: my_icons,
        iconSize: [38, 64],
        iconAnchor: [20, 60],
        popupAnchor: [0, -65],
      });
      var tileLayer = new L.TileLayer(
        "https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png"
      );

      var singlemap = new L.Map("static_map", {
        center: [listing_latt, listing_long],
        zoom: 14,
        layers: [tileLayer],
        scrollWheelZoom: "center", // zoom to center regardless where mouse is
        doubleClickZoom: "center",
        touchZoom: "center",
      });
      singlemap.scrollWheelZoom.disable();
      var single_marker = L.marker(
        [listing_latt, listing_long],
        { icon: myIconz },
        { draggable: false }
      ).addTo(singlemap);

      singlemap.invalidateSize();
    }

    //listings
    if (get_valzz.d_map_lat && get_valzz.d_map_long) {
      var chk_container = document.getElementById("submit-map-open");
      if (typeof chk_container != "undefined" && chk_container != null) {
        var mymap = L.map(chk_container).setView(
          [get_valzz.d_map_lat, get_valzz.d_map_long],
          13
        );
        L.tileLayer(
          "https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png",
          {
            maxZoom: 18,
          }
        ).addTo(mymap);
        var markerz = L.marker([get_valzz.d_map_lat, get_valzz.d_map_long], {
          draggable: true,
        }).addTo(mymap);
        var searchControl = new L.Control.Search({
          url: "//nominatim.openstreetmap.org/search?format=json&q={s}",
          jsonpParam: "json_callback",
          propertyName: "display_name",
          propertyLoc: ["lat", "lon"],
          marker: markerz,
          autoCollapse: true,
          autoType: true,
          minLength: 2,
        });
        searchControl.on("search:locationfound", function (obj) {
          var strObj = obj.sourceTarget._recordsCache;
          var locTitle = Object.keys(strObj)[0];
          var lt = obj.latlng + "";
          var res = lt.split("LatLng(");
          res = res[1].split(")");
          res = res[0].split(",");

          // console.log("latt", res[0]);

          document.getElementById("d_latt").value = res[0];
          document.getElementById("d_long").value = res[1];
          document.getElementById("address_location").value = locTitle;
        });
        mymap.addControl(searchControl);
        markerz.on("dragend", function (e) {
          document.getElementById("d_latt").value = markerz.getLatLng().lat;
          document.getElementById("d_long").value = markerz.getLatLng().lng;
        });
        //for map
        if (typeof ip_type != "undefined") {
          $(".get-loc  i.detect-me").on("click", function (e) {
            e.preventDefault();
            $(this).addClass("fa-circle-o-notch fa-spin extra-spin");
            $(this).removeClass("fa-crosshairs");
            if (ip_type == "geo_ip") {
              $.ajax({
                type: "POST",
                url: ajax_url,
                data: { action: "check_my_key" },
                success: function (data) {
                  if (data.success) {
                    var city = data.data.city;
                    var latitude = data.data.latitude;
                    var longitude = data.data.longitude;
                    var country = data.data.country;
                    $("#address_location").val(city + ", " + country);
                    if (get_strings.map_type == "open_street") {
                      $("#d_latt").value = latitude;
                      $("#d_long").value = longitude;
                      mymap.setView(new L.LatLng(latitude, longitude), 13);
                      markerz.setLatLng([latitude, longitude]);
                      $(".get-loc i.detect-me").fadeOut("slow");
                    }
                  } else {
                    $.getJSON("http://ip-api.com/json/?callback=?").done(
                      function (location) {
                        $("#address_location").val(
                          location.city + ", " + location.country
                        );
                        document.getElementById("d_latt").value = location.lat;
                        document.getElementById("d_long").value = location.lon;
                        mymap.setView(
                          new L.LatLng(location.lat, location.lon),
                          13
                        );
                        markerz.setLatLng([location.lat, location.lon]);
                        $(".get-loc i.detect-me").fadeOut("slow");
                      }
                    );
                  }
                },
                error: function (xhr, status, error) {
                  console.error("Error occurred:", error);
                },
              });
            } else {
              $.get(
                "https://ipapi.co/8.8.8.8/json/",
                function (location) {
                  $("#address_location").val(
                    location.city + ", " + location.country_name
                  );
                  document.getElementById("d_latt").value = location.latitude;
                  document.getElementById("d_long").value = location.longitude;
                  mymap.setView(
                    new L.LatLng(location.latitude, location.longitude),
                    13
                  );
                  markerz.setLatLng([location.latitude, location.longitude]);
                  $(".get-loc i.detect-me").fadeOut("slow");
                },
                "json"
              );
            }
          });
        }
      }
    }
  }

  /*Add to Cart*/
  $(".sb_add_cart").on("click", function () {
    var pack_ref = $(this).attr("data-package-type");
    var pack_id = $(this).attr("data-product-id");
    var qunatity = $(this).attr("data-product-qty");
    $(".sonu-button-" + pack_id + "").button("loading");
    $.post(ajax_url, {
      action: "dwt_listing_package_cart",
      package_id: pack_id,
      qty: qunatity,
      package_refer: pack_ref,
    }).done(function (response) {
      $(".sonu-button-" + pack_id + "").button("reset");
      if ($.trim(response) == "1") {
        $(document).ready(function () {
          $("#myModal").modal("show");
        });
        $("#pack_type").val(pack_ref);
        $("#pack_id").val(pack_id);
        $("#woo-pack").show();
      } else {
        window.location = response;
      }
    });
  });
  /* Report Listing */
  $("#report-form")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "dwt_listing_listing_report",
          collect_data: $("form#report-form").serialize(),
        }).done(function (response) {
          $(".sonu-button").button("reset");
          var get_r = response.split("|");
          if ($.trim(get_r[0]) == "1") {
            $(".report-quote").modal("hide");
            $.alert({
              title: get_strings.congratulations,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          } else {
            $(".report-quote").modal("hide");
            $.alert({
              title: get_strings.whoops,
              rtl: yes_rtl,
              closeIcon: true,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
      }
      return false;
    });
  /* Make Listing Featured */
  $(document).on("click", ".bookmark-listing", function () {
    var listing_id = $(this).attr("data-listing-id");
    $(".sonu-button-" + listing_id).button("loading");

    $.post(ajax_url, {
      action: "dwt_listing_listing_bookmark",
      listing_id: listing_id,
    }).done(function (response) {
      $(".sonu-button-" + listing_id).button("reset");
      var get_p = response.split("|");
      if ($.trim(get_p[0]) == "1") {
        $(this).addClass("fa fa-heart-o");
        $.alert({
          title: get_strings.congratulations,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-smile-o",
          theme: "modern",
          animation: "scale",
          type: "green",
          content: get_p[1],
          backgroundDismiss: true,
          buttons: { okay: { btnClass: "btn-blue" } },
        });
      } else {
        $(".sonu-button-" + listing_id).button("reset");
        $.alert({
          title: get_strings.whoops,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-frown-o",
          theme: "modern",
          animation: "scale",
          type: "red",
          content: get_p[1],
          backgroundDismiss: true,
          buttons: { okay: { btnClass: "btn-blue" } },
        });
      }
    });
    return false;
  });

  /* Contact to Listing Owner */
  $("#listing-owner-contact")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var posted_id = $(":hidden#posted_listing_id").val();
        $(".sonu-button-" + posted_id).button("loading");
        $.post(ajax_url, {
          action: "send_msg_to_listing_owner",
          collect_data: $("form#listing-owner-contact").serialize(),
        }).done(function (response) {
          $(".sonu-button-" + posted_id).button("reset");
          var get_r = response.split("|");
          if ($.trim(get_r[0]) == "1") {
            document.getElementById("listing-owner-contact").reset();
            $.alert({
              title: get_strings.congratulations,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          } else {
            $.alert({
              title: get_strings.whoops,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
      }
      return false;
    });
  $("#send-message-to-listing-owner")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var posted_id = $(":hidden#posted_listing_id").val();
        $(".sonu-button-" + posted_id).button("loading");
        $.post(ajax_url, {
          action: "send_chat_msg_to_listing_owner",
          collect_data: $("form#send-message-to-listing-owner").serialize(),
        }).done(function (response) {
          $(".sonu-button-" + posted_id).button("reset");
          var get_r = response.split("|");
          if ($.trim(get_r[0]) == "1") {
            document.getElementById("send-message-to-listing-owner").reset();
            $.alert({
              title: get_strings.congratulations,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          } else if ($.trim(get_r[0]) == "1") {
            $.alert({
              title: get_strings.whoops,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          } else {
            $.alert({
              title: get_strings.whoops,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
      }
      return false;
    });

  $(document).ready(function () {
    $.post(ajax_url, {
      action: "get_unread_messages",
    }).done(function (response) {
      if (response.success) {
        $("#notify").empty();
        $("#notify").append(`(${response.data.unread_chatss})`);
      }
    });
  });
  /* Send Public Email to Author */
  $("#email-to-author")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var posted_id = $(":hidden#posted_listing_id").val();
        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "send_email_to_author",
          collect_data: $("form#email-to-author").serialize(),
        }).done(function (response) {
          $(".sonu-button").button("reset");
          var get_r = response.split("|");
          if ($.trim(get_r[0]) == "1") {
            document.getElementById("email-to-author").reset();
            $.alert({
              title: get_strings.congratulations,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          } else {
            $.alert({
              title: get_strings.whoops,
              rtl: yes_rtl,
              closeIcon: true,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
      }
      return false;
    });
  /* Claim Lisitng */
  $("#claim-form")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var claim_id = $(":hidden#claim_listing_id").val();
        $(".sonu-button-" + claim_id).button("loading");
        $.post(ajax_url, {
          action: "for_claim_listing",
          collect_data: $("form#claim-form").serialize(),
        }).done(function (response) {
          $(".sonu-button-" + claim_id).button("reset");
          var get_r = response.split("|");
          if ($.trim(get_r[0]) == "1") {
            document.getElementById("claim-form").reset();
            $(".claim-now").modal("hide");
            $.alert({
              title: get_strings.thanks,
              rtl: yes_rtl,
              closeIcon: true,
              backgroundDismiss: true,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          } else {
            $(".claim-now").modal("hide");
            document.getElementById("claim-form").reset();
            $.alert({
              title: get_strings.whoops,
              rtl: yes_rtl,
              closeIcon: true,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
      }
      return false;
    });
  /* Comments Reviews */
  $(".review-form-listing")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        $(".sonu-button-review").button("loading");
        $.post(ajax_url, {
          action: "dwt_listing_listing_reviews",
          collect_data: $(this).serialize(),
        }).done(function (response) {
          $(".sonu-button-review").button("reset");
          var get_r = response.split("|");
          if ($.trim(get_r[0]) == "1") {
            $(".review-form-listing").trigger("reset");
            $.alert({
              title: get_strings.congratulations,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
            window.setTimeout(function () {
              location.reload();
            }, 1500);
          } else {
            $.alert({
              title: get_strings.whoops,
              rtl: yes_rtl,
              closeIcon: true,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
      }
      return false;
    });
  /* Comments Reviews Reply */
  $(".review-reply")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var comment_id = $(this).attr("data-cid");
        $(".sonu-button-reply-" + comment_id).button("loading");
        $.post(ajax_url, {
          action: "dwt_listing_listing_review_reply",
          c_id: comment_id,
          collect_data: $(this).serialize(),
        }).done(function (response) {
          var get_r = response.split("|");
          if ($.trim(get_r[0]) == "1") {
            $(".sonu-button-reply-" + comment_id).button("reset");
            $.alert({
              title: get_strings.congratulations,
              rtl: yes_rtl,
              closeIcon: true,
              backgroundDismiss: true,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
            window.setTimeout(function () {
              location.reload();
            }, 1500);
          } else {
            $.alert({
              title: get_strings.whoops,
              rtl: yes_rtl,
              closeIcon: true,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: get_r[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
      }
      return false;
    });

  function dwt_listing_dropzones() {
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = "image/*";
    var fileList = new Array();
    var i = 0;
    $(".reviews_dropzone").dropzone({
      addRemoveLinks: true,
      timeout: 50000000000000,
      maxFilesize: 500000000000000,
      paramName: "my_file_upload",
      maxFiles: $("#review_upload_limit").val(),
      gallery_limit: $("#review_mx_limit").val(),
      acceptedFiles: ".jpeg,.jpg,.png,.webp",
      dictMaxFilesExceeded: $("#review_max_upload_reach").val(),
      url:
        ajax_url +
        "?action=upload_review_gallery&is_update=" +
        $("input[name=review_listing_id]").val(),
      parallelUploads: 1,
      dictDefaultMessage: $("#dictDefaultMessages").val(),
      dictFallbackMessage: $("#dictFallbackMessages").val(),
      dictFallbackText: $("#dictFallbackTexts").val(),
      dictFileTooBig: $("#dictFileTooBigs").val(),
      dictInvalidFileType: $("#dictInvalidFileTypes").val(),
      dictResponseError: $("#dictResponseErrors").val(),
      dictCancelUpload: $("#dictCancelUploads").val(),
      dictCancelUploadConfirmation: $("#dictCancelUploadConfirmations").val(),
      dictRemoveFile: $("#dictRemoveFiles").val(),
      dictRemoveFileConfirmation: null,
      init: function () {
        var thisDropzone = this;
        $.post(ajax_url, { action: "get_uploaded_review_images" }).done(
          function (data) {
            if (data != 0) {
              $.each(data, function (key, value) {
                var mockFile = { name: value.dispaly_name, size: value.size };
                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(
                  thisDropzone,
                  mockFile,
                  value.name
                );
                $("a.dz-remove:eq(" + i + ")").attr("data-dz-remove", value.id);
                i++;
                $(".dz-progress").remove();
              });
            }
            if (i > 0) $(".dz-message").hide();
            else $(".dz-message").show();
          }
        );
        this.on("addedfile", function (file) {
          $(".dz-message").hide();
        });
        this.on("success", function (file, responseText) {
          var res_arr = responseText.split("|");
          if ($.trim(res_arr[0]) != "0") {
            $("a.dz-remove:eq(" + i + ")").attr("data-dz-remove", responseText);
            i++;
            $(".dz-message").hide();
          } else {
            if (i == 0) $(".dz-message").show();
            this.removeFile(file);
            $.alert({
              title: get_strings.whoops,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: res_arr[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
        this.on("removedfile", function (file) {
          var img_id = file._removeLink.attributes[2].value;
          console.log(_removeLink);
          if (img_id != "") {
            i--;
            if (i == 0) $(".dz-message").show();
            $.post(ajax_url, {
              action: "delete_listing_reviews_image",
              img: img_id,
            }).done(function (response) {
              if ($.trim(response) == "1") {
              }
            });
          }
        });
      },
    });
  }

  dwt_listing_dropzones();

  $("#event_start").datepicker({
    language: {
      days: [
        get_strings.Sunday,
        get_strings.Monday,
        get_strings.Tuesday,
        get_strings.Wednesday,
        get_strings.Thursday,
        get_strings.Friday,
        get_strings.Saturday,
      ],
      daysShort: [
        get_strings.Sun,
        get_strings.Mon,
        get_strings.Tue,
        get_strings.Wed,
        get_strings.Thu,
        get_strings.Fri,
        get_strings.Sat,
      ],
      daysMin: [
        get_strings.Su,
        get_strings.Mo,
        get_strings.Tu,
        get_strings.We,
        get_strings.Th,
        get_strings.Fr,
        get_strings.Sa,
      ],
      months: [
        get_strings.January,
        get_strings.February,
        get_strings.March,
        get_strings.April,
        get_strings.May,
        get_strings.June,
        get_strings.July,
        get_strings.August,
        get_strings.September,
        get_strings.October,
        get_strings.November,
        get_strings.December,
      ],
      monthsShort: [
        get_strings.Jan,
        get_strings.Feb,
        get_strings.Mar,
        get_strings.Apr,
        get_strings.May,
        get_strings.Jun,
        get_strings.Jul,
        get_strings.Aug,
        get_strings.Sep,
        get_strings.Oct,
        get_strings.Nov,
        get_strings.Dec,
      ],
      today: get_strings.Today,
      clear: get_strings.Clear,
      dateFormat: "mm/dd/yyyy",
      timeFormat: "hh:ii aa",
      firstDay: 0,
    },
    minDate: new Date(),
   
  });
  $("#event_end").datepicker({
    language: {
      days: [
        get_strings.Sunday,
        get_strings.Monday,
        get_strings.Tuesday,
        get_strings.Wednesday,
        get_strings.Thursday,
        get_strings.Friday,
        get_strings.Saturday,
      ],
      daysShort: [
        get_strings.Sun,
        get_strings.Mon,
        get_strings.Tue,
        get_strings.Wed,
        get_strings.Thu,
        get_strings.Fri,
        get_strings.Sat,
      ],
      daysMin: [
        get_strings.Su,
        get_strings.Mo,
        get_strings.Tu,
        get_strings.We,
        get_strings.Th,
        get_strings.Fr,
        get_strings.Sa,
      ],
      months: [
        get_strings.January,
        get_strings.February,
        get_strings.March,
        get_strings.April,
        get_strings.May,
        get_strings.June,
        get_strings.July,
        get_strings.August,
        get_strings.September,
        get_strings.October,
        get_strings.November,
        get_strings.December,
      ],
      monthsShort: [
        get_strings.Jan,
        get_strings.Feb,
        get_strings.Mar,
        get_strings.Apr,
        get_strings.May,
        get_strings.Jun,
        get_strings.Jul,
        get_strings.Aug,
        get_strings.Sep,
        get_strings.Oct,
        get_strings.Nov,
        get_strings.Dec,
      ],
      today: get_strings.Today,
      clear: get_strings.Clear,
      dateFormat: "mm/dd/yyyy",
      timeFormat: "hh:ii aa",
      firstDay: 0,
    },
    minDate: new Date(),
   
  });
  $("#coupon_start").datepicker({
    language: {
      days: [
        get_strings.Sunday,
        get_strings.Monday,
        get_strings.Tuesday,
        get_strings.Wednesday,
        get_strings.Thursday,
        get_strings.Friday,
        get_strings.Saturday,
      ],
      daysShort: [
        get_strings.Sun,
        get_strings.Mon,
        get_strings.Tue,
        get_strings.Wed,
        get_strings.Thu,
        get_strings.Fri,
        get_strings.Sat,
      ],
      daysMin: [
        get_strings.Su,
        get_strings.Mo,
        get_strings.Tu,
        get_strings.We,
        get_strings.Th,
        get_strings.Fr,
        get_strings.Sa,
      ],
      months: [
        get_strings.January,
        get_strings.February,
        get_strings.March,
        get_strings.April,
        get_strings.May,
        get_strings.June,
        get_strings.July,
        get_strings.August,
        get_strings.September,
        get_strings.October,
        get_strings.November,
        get_strings.December,
      ],
      monthsShort: [
        get_strings.Jan,
        get_strings.Feb,
        get_strings.Mar,
        get_strings.Apr,
        get_strings.May,
        get_strings.Jun,
        get_strings.Jul,
        get_strings.Aug,
        get_strings.Sep,
        get_strings.Oct,
        get_strings.Nov,
        get_strings.Dec,
      ],
      today: get_strings.Today,
      clear: get_strings.Clear,
      dateFormat: "mm/dd/yyyy",
      firstDay: 0,
    },
    minDate: new Date(),
  });
  $("#coupon_end").datepicker({
    language: {
      days: [
        get_strings.Sunday,
        get_strings.Monday,
        get_strings.Tuesday,
        get_strings.Wednesday,
        get_strings.Thursday,
        get_strings.Friday,
        get_strings.Saturday,
      ],
      daysShort: [
        get_strings.Sun,
        get_strings.Mon,
        get_strings.Tue,
        get_strings.Wed,
        get_strings.Thu,
        get_strings.Fri,
        get_strings.Sat,
      ],
      daysMin: [
        get_strings.Su,
        get_strings.Mo,
        get_strings.Tu,
        get_strings.We,
        get_strings.Th,
        get_strings.Fr,
        get_strings.Sa,
      ],
      months: [
        get_strings.January,
        get_strings.February,
        get_strings.March,
        get_strings.April,
        get_strings.May,
        get_strings.June,
        get_strings.July,
        get_strings.August,
        get_strings.September,
        get_strings.October,
        get_strings.November,
        get_strings.December,
      ],
      monthsShort: [
        get_strings.Jan,
        get_strings.Feb,
        get_strings.Mar,
        get_strings.Apr,
        get_strings.May,
        get_strings.Jun,
        get_strings.Jul,
        get_strings.Aug,
        get_strings.Sep,
        get_strings.Oct,
        get_strings.Nov,
        get_strings.Dec,
      ],
      today: get_strings.Today,
      clear: get_strings.Clear,
      dateFormat: "mm/dd/yyyy",
      firstDay: 0,
    },
    minDate: new Date(),
  });

  if ($("#calender-booking").length > 0) {
    var bookedDays = $("#restricted_days").val();
    var bookedDaysArr = bookedDays.split(", ");
    var enabledDays = bookedDaysArr;

    console.log(enabledDays);
    $("#calender-booking").datepicker({
      language: {
        days: [
          get_strings.Sunday,
          get_strings.Monday,
          get_strings.Tuesday,
          get_strings.Wednesday,
          get_strings.Thursday,
          get_strings.Friday,
          get_strings.Saturday,
        ],
        daysShort: [
          get_strings.Sun,
          get_strings.Mon,
          get_strings.Tue,
          get_strings.Wed,
          get_strings.Thu,
          get_strings.Fri,
          get_strings.Sat,
        ],
        daysMin: [
          get_strings.Su,
          get_strings.Mo,
          get_strings.Tu,
          get_strings.We,
          get_strings.Th,
          get_strings.Fr,
          get_strings.Sa,
        ],
        months: [
          get_strings.January,
          get_strings.February,
          get_strings.March,
          get_strings.April,
          get_strings.May,
          get_strings.June,
          get_strings.July,
          get_strings.August,
          get_strings.September,
          get_strings.October,
          get_strings.November,
          get_strings.December,
        ],
        monthsShort: [
          get_strings.Jan,
          get_strings.Feb,
          get_strings.Mar,
          get_strings.Apr,
          get_strings.May,
          get_strings.Jun,
          get_strings.Jul,
          get_strings.Aug,
          get_strings.Sep,
          get_strings.Oct,
          get_strings.Nov,
          get_strings.Dec,
        ],
        today: get_strings.Today,
        clear: get_strings.Clear,
        dateFormat: "mm/dd/yyyy",
        firstDay: 0,
      },
      timepicker: false,
      dateFormat: "yyyy-mm-dd",
      minDate: new Date(),
      onRenderCell: function onRenderCell(date, cellType) {
        if (cellType == "day") {
          var day =
            ("0" + date.getDate()).slice(-2) +
            "." +
            ("0" + (date.getMonth() + 1)).slice(-2) +
            "." +
            date.getFullYear();
          console.log(day);

          var isDisabled = enabledDays.indexOf(day) != -1;

          return {
            disabled: isDisabled,
          };
        }
      },

      onSelect: function (date, today, obj) {
        $("#booking-date").val(date);
        var ad_id = $("#ad_id").val();
        $("#sb_loading").show();

        $.post(ajax_url, {
          action: "sb_get_calender_time",
          date: date,
          ad_id: ad_id,
        }).done(function (response) {
          $("#sb_loading").hide();
          if (response.success == true) {
            $(".form-select-time-slot").html(response.data.options);
            // if (response.success == true && response.data.options == "") {
            //   alert("There is no Reservation AVailable for this Day.");
            //   $("#form_select_timeslot").select.option == "b";
            // }
            console.log(response);
          } else {
            $.alert({
              title: get_strings.whoops,
              closeIcon: true,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: response.data.message,
              buttons: { okay: { btnClass: "btn-blue" } },
            });
            window.setTimeout(function () {
              location.reload();
            }, 2000);
          }
        });
      },
    });
  }

  if (
    get_strings.show_redirect_msg != "0" &&
    get_strings.show_redirect_msg == "1"
  ) {
    $.alert({
      title: get_strings.notify,
      rtl: yes_rtl,
      backgroundDismiss: true,
      icon: "fa fa-warning",
      type: "orange",
      autoClose: "cancelAction|5000",
      content: get_strings.notify_msg,
      escapeKey: "cancelAction",
      buttons: { cancelAction: { text: get_strings.cancle } },
    });
  }

  function dwt_listing_event_timer() {
    if ($(".sidebar_clock").length) {
      $(".sidebar_clock")
        .each(function () {
          var countDatez = $(this).data("countdown-time");
          $(this).countdown(countDatez, function (event) {
            $(this).html(
              '<span class="my-timer">' +
                event.strftime("%D " + get_strings.coupon_days + " %H:%M:%S") +
                "</span>"
            );
          });
        })
        .on("finish.countdown", function () {
          $(this).hide();
          $(".listing-coupon-block").hide();
        });
    }
  }

  dwt_listing_event_timer();

  function dwt_listing_countDownTimer() {
    if ($(".dwt_listing_custom-timer").length) {
      $(".dwt_listing_custom-timer")
        .each(function () {
          var countDate = $(this).data("countdown-time"); // getting date
          $(this).countdown(countDate, function (event) {
            $(this).html(
              '<li> <div class="timer-countdown-box"> <span class="timer-days">' +
                event.strftime("%D") +
                '</span> <span class="timer-div">' +
                get_strings.coupon_days +
                '</span> </div> </li> <li> <div class="timer-countdown-box"> <span class="timer-hours">' +
                event.strftime("%H") +
                '</span> <span class="timer-div color-1">' +
                get_strings.coupon_hours +
                '</span> </div> </li> <li> <div class="timer-countdown-box"> <span class="timer-minutes">' +
                event.strftime("%M") +
                '</span> <span class="timer-div color-2">' +
                get_strings.coupon_minutes +
                '</span> </div> </li> <li> <div class="timer-countdown-box"> <span class="timer-seconds">' +
                event.strftime("%S") +
                '</span> <span class="timer-div color-3">' +
                get_strings.coupon_seconds +
                "</span> </div> </li>"
            );
          });
        })
        .on("finish.countdown", function () {
          $(this).hide();
          $(".listing-coupon-block").hide();
        });
    }
  }

  dwt_listing_countDownTimer();
  $(".comment-submitted.collapsed").on("click", function () {
    var comment_id = $(this).attr("data-comment-id");
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = "image/*";
    var fileList = new Array();
    var i = 0;
    $(".reviews_dropzone" + comment_id).dropzone({
      addRemoveLinks: true,
      timeout: 50000000000000,
      maxFilesize: 500000000000000,
      paramName: "my_file_upload",
      maxFiles: $("#review_upload_limit").val(),
      gallery_limit: $("#review_mx_limit").val(),
      acceptedFiles: ".jpeg,.jpg,.png,.webp",
      dictMaxFilesExceeded: $("#review_max_upload_reach").val(),
      url:
        ajax_url + "?action=upload_comments_gallery&is_comments=" + comment_id,
      parallelUploads: 1,
      dictDefaultMessage: $("#dictDefaultMessages").val(),
      dictFallbackMessage: $("#dictFallbackMessages").val(),
      dictFallbackText: $("#dictFallbackTexts").val(),
      dictFileTooBig: $("#dictFileTooBigs").val(),
      dictInvalidFileType: $("#dictInvalidFileTypes").val(),
      dictResponseError: $("#dictResponseErrors").val(),
      dictCancelUpload: $("#dictCancelUploads").val(),
      dictCancelUploadConfirmation: $("#dictCancelUploadConfirmations").val(),
      dictRemoveFile: $("#dictRemoveFiles").val(),
      dictRemoveFileConfirmation: null,
      init: function () {
        var thisDropzone = this;
        $.post(ajax_url, {
          action: "get_uploaded_comments_images",
          is_comment_id: comment_id,
        }).done(function (data) {
          if (data != 0) {
            $.each(data, function (key, value) {
              var mockFile = { name: value.dispaly_name, size: value.size };
              thisDropzone.options.addedfile.call(thisDropzone, mockFile);
              thisDropzone.options.thumbnail.call(
                thisDropzone,
                mockFile,
                value.name
              );
              $("a.dz-remove:eq(" + i + ")").attr("data-dz-remove", value.id);
              i++;
            });
            $(".dz-progress").remove();
          }
          if (i > 0) $(".dz-message").hide();
          else $(".dz-message").show();
        });
        this.on("addedfile", function (file) {
          $(".dz-message").hide();
        });
        this.on("success", function (file, responseText) {
          var res_arr = responseText.split("|");
          if ($.trim(res_arr[0]) != "0") {
            $("a.dz-remove:eq(" + i + ")").attr("data-dz-remove", responseText);
            i++;
            $(".dz-message").hide();
          } else {
            if (i == 0) $(".dz-message").show();
            this.removeFile(file);
            $.alert({
              title: get_strings.whoops,
              rtl: yes_rtl,
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: res_arr[1],
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
        this.on("removedfile", function (file) {
          var img_id = file._removeLink.attributes[2].value;
          if (img_id != "") {
            i--;
            if (i == 0) $(".dz-message").show();
            $.post(ajax_url, {
              action: "delete_listing_comments_image",
              img: img_id,
              is_comment_id: comment_id,
            }).done(function (response) {
              if ($.trim(response) == "1") {
              }
            });
          }
        });
      },
    });
  });
  $("#input-21b").rating({
    starCaptions: {
      1: get_strings.one,
      2: get_strings.two,
      3: get_strings.three,
      4: get_strings.four,
      5: get_strings.five,
    },
  });
  /*--- PRE LOADER JS ---*/
  $(window).on("load", function () {
    $("#spinner").hide();
  });
  /*DROPDOWN CLICK INSIDE DISABLE*/
  $(document).on("click", ".filter .dropdown-menu", function (e) {
    e.stopPropagation();
  });
  /* Add slideDown animation to Bootstrap dropdown when expanding. */
  $(".dropdown").on("show.bs.dropdown", function () {
    $(this).find(".dropdown-menu").first().stop(true, true).slideDown();
  });
  /* Add slideUp animation to Bootstrap dropdown when collapsing.*/
  $(".dropdown").on("hide.bs.dropdown", function () {
    $(this).find(".dropdown-menu").first().stop(true, true).slideUp();
  });
  $.fn.modal.Constructor.prototype.enforceFocus = function () {};

  function copyToClipboard(text, el) {
    var copyTest = document.queryCommandSupported("copy");
    var elOriginalText = el.attr("data-original-title");
    if (copyTest === true) {
      var copyTextArea = document.createElement("textarea");
      copyTextArea.value = text;
      document.body.appendChild(copyTextArea);
      copyTextArea.select();
      try {
        var successful = document.execCommand("copy");
        var msg = successful ? get_strings.copied : get_strings.not_copy;
        el.attr("data-original-title", msg).tooltip("show");
      } catch (err) {
        console.log(get_strings.copy_unable);
      }
      document.body.removeChild(copyTextArea);
      el.attr("data-original-title", elOriginalText);
    } else {
      window.prompt(get_strings.copy_else, text);
    }
  }

  $(".js-tooltip").tooltip();
  $(".js-copy").on("click", function () {
    var text = $(this).attr("data-copy");
    var el = $(this);
    copyToClipboard(text, el);
  });
  /*--- SCROLL TO TOP---*/
  $(document).ready(function () {
    $(".menu-mobile-collapse-trigger").on("click", function () {
      $(".menu-links").toggleClass("show_menu");
    });
    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
        $(".scrollup").fadeIn();
      } else {
        $(".scrollup").fadeOut();
      }
    });
    $(".scrollup").on("click", function () {
      $("html, body").animate(
        {
          scrollTop: 0,
        },
        600
      );
      return false;
    });
  });
  $(".custom-select").select2({
    allowClear: false,
    rtl: yes_rtl,
    width: "100%",
    language: {
      noResults: function (params) {
        return get_strings.no_msg;
      },
    },
  });
  $(".allow_clear").select2({
    allowClear: true,
    rtl: yes_rtl,
    width: "100%",
    language: {
      noResults: function (params) {
        return get_strings.no_msg;
      },
    },
  });
  $(".dwt_listing_woo-filters .orderby").select2({
    allowClear: false,
    rtl: yes_rtl,
    width: "100%",
    language: {
      noResults: function (params) {
        return get_strings.no_msg;
      },
    },
  });
  $(".dropdown_product_cat").select2({
    allowClear: false,
    rtl: yes_rtl,
    width: "100%",
    language: {
      noResults: function (params) {
        return get_strings.no_msg;
      },
    },
  });
  $(".custom-fields").select2({
    allowClear: true,
    rtl: yes_rtl,
    width: "100%",
    language: {
      noResults: function (params) {
        return get_strings.no_msg;
      },
    },
  });
  $(".faqs-accordion li").first().addClass("open");
  $(".faqs-accordion li .faqs-accordion-content")
    .first()
    .css("display", "block")
    .slideDown(400);
  $(".faqs-accordion-title a").on("click", function (event) {
    event.preventDefault();
    if ($(this).parents("li").hasClass("open")) {
      $(this)
        .parents("li")
        .removeClass("open")
        .find(".faqs-accordion-content")
        .slideUp(400);
    } else {
      $(this)
        .parents(".faqs-accordion")
        .find(".faqs-accordion-content")
        .not($(this).parents("li").find(".faqs-accordion-content"))
        .slideUp(400);
      $(this)
        .parents(".faqs-accordion")
        .find("> li")
        .not($(this).parents("li"))
        .removeClass("open");
      $(this)
        .parents("li")
        .addClass("open")
        .find(".faqs-accordion-content")
        .slideDown(400);
    }
  });
  $("input.badgebox").on("click", function () {
    if ($(this).is(":checked")) {
      $(this).parent().addClass("active");
    } else {
      $(this).parent().removeClass("active");
    }
  });
  /*CUSTOM HEADER TO CATEGORY LIST SELECT*/

  $(".search-panel .dropdown-menu")
    .find("a")
    .click(function (e) {
      e.preventDefault();
      var param = $(this).attr("href").replace("#", "");
      var concept = $(this).text();
      $(".search-panel span#search_concept").text(concept);
      $(".input-group #search_param").val(param);
    });
  /*--- TOOTIP---*/

  /* ======= Progress bars ======= */
  if ($(".progress-bar").length) {
    $(".progress-bar > span").each(function () {
      var $this = $(this);
      var width = $(this).data("percent");
      $this.css({
        transition: "width 3s",
      });
      setTimeout(function () {
        $this.appear(function () {
          $this.css("width", width + "%");
        });
      }, 500);
    });
  }

  if ($(".listing-page-slider").length) {
    $(".listing-page-slider").owlCarousel({
      loop: false,
      nav: true,
      rtl: yes_rtl,
      dots: false,
      center: false,
      animateOut: "slideOutDown",
      animateIn: "flipInX",
      smartSpeed: 450,
      navSpeed: 1500,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 3,
        },
        1000: {
          items: 3,
        },
      },
    });
  }

  if ($(".produt-slider").length) {
    $(".produt-slider").owlCarousel({
      nav: true,
      rtl: yes_rtl,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      animateOut: "fadeOut",
      animateIn: "fadeIn",
      items: 1,
    });
  }

  if ($(".related-produt-slider").length) {
    $(".related-produt-slider").owlCarousel({
      nav: true,
      rtl: yes_rtl,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      animateOut: "fadeOut",
      animateIn: "fadeIn",
      responsive: {
        0: {
          items: 1,
          autoplay: false,
        },
        600: {
          items: 3,
          margin: 10,
        },
        1000: {
          items: 4,
          margin: 10,
        },
        1025: {
          items: 4,
          margin: 10,
        },
      },
      dots: false,
      autoplay: true,
      autoplayTimeout: 2500,
      autoplayHoverPause: true,
    });
  }

  if ($(".landing-carousel-slider").length) {
    $(".landing-carousel-slider").owlCarousel({
      rtl: yes_rtl,
      loop: true,
      margin: 0,
      smartSpeed: 500,
      responsiveClass: true,
      autoplay: true,
      autoplayHoverPause: true,
      navText: [
        '<i class="fa fa-angle-left"></i>',
        '<i class="fa fa-angle-right"></i>',
      ],
      responsive: {
        0: {
          items: 1,
          nav: true,
          dots: false,
        },
        600: {
          items: 1,
          nav: false,
          dots: true,
        },
        1120: {
          items: 1,
          dots: false,
          nav: true,
        },
      },
    });
  }

  if ($("#testimonial-slider").length) {
    $("#testimonial-slider").owlCarousel({
      rtl: yes_rtl,
      nav: false,
      loop: true,
      margin: 10,
      dots: true,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
      },
    });
  }

  if ($(".feedbacks1").length) {
    $(".feedbacks1").owlCarousel({
      rtl: yes_rtl,
      nav: false,
      loop: true,
      margin: 30,
      dots: false,
      autoplayHoverPause: true,
      autoplay: 6000,
      smartSpeed: 700,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1024: {
          items: 2,
        },
        1100: {
          items: 3,
        },
        1200: {
          items: 3,
        },
      },
    });
  }

  if ($("#testimonial-slider-2").length) {
    $("#testimonial-slider-2").owlCarousel({
      rtl: yes_rtl,
      nav: false,
      loop: true,
      margin: 10,
      dots: true,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
      },
    });
  }

  if ($("#event-slider").length) {
    $("#event-slider").owlCarousel({
      rtl: yes_rtl,
      dots: true,
      nav: false,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        1000: {
          items: 1,
        },
      },
    });
  }

  if ($("#papular-listing-2-slider").length) {
    $("#papular-listing-2-slider").owlCarousel({
      rtl: yes_rtl,
      loop: true,
      dots: false,
      responsiveClass: true,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      nav: true,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
      },
    });
  }

  if ($("#slider_type_2").length) {
    $("#slider_type_2").owlCarousel({
      rtl: yes_rtl,
      loop: true,
      margin: 0,
      dots: false,
      responsiveClass: true,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
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
        },
      },
    });
  }

  if ($(".papular-listing-2-slider").length) {
    $(".papular-listing-2-slider").owlCarousel({
      rtl: yes_rtl,
      loop: true,
      margin: -20,
      dots: false,
      responsiveClass: true,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      nav: true,
      responsive: {
        0: {
          items: 1,
          margin: 0,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
        1100: {
          items: 3,
        },
      },
    });
  }
  if ($("#main-section-slider").length) {
    $("#main-section-slider").owlCarousel({
      rtl: yes_rtl,
      loop: false,
      dots: false,
      responsiveClass: true,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      nav: true,
      responsive: {
        0: {
          items: 3,
          nav: false,
        },
        600: {
          items: 3,
        },
        1000: {
          items: 4,
        },
        1025: {
          items: 6,
        },
      },
    });
  }

  if ($("#main-section-slider-2").length) {
    $("#main-section-slider-2").owlCarousel({
      rtl: yes_rtl,
      loop: false,
      dots: false,
      margin: 5,
      responsiveClass: true,
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      nav: true,
      responsive: {
        0: {
          items: 3,
          nav: false,
        },
        600: {
          items: 6,
        },
        1000: {
          items: 6,
        },
        1100: {
          items: 8,
        },
      },
    });
  }

  if ($(".shop-banner-slider").length) {
    $(".shop-banner-slider").owlCarousel({
      rtl: yes_rtl,
      loop: true,
      margin: 10,
      center: true,
      items: 1,
      animateOut: "slideOutDown",
      animateIn: "flipInX",
      stagePadding: 0,
      smartSpeed: 450,
    });
  }

  if ($(".event-images-loop").length) {
    var $owl = $(".event-images-loop");
    $owl.owlCarousel({
      rtl: yes_rtl,
      autoplay: true,
      autoplayHoverPause: true,
      autoplayTimeout: 3000,
      autoplaySpeed: 800,
      center: true,
      items: 1.3,
      stagePadding: 0,
      loop: true,
      lazyLoad: true,
      margin: 0,
      animateOut: "slide-up",
      animateIn: "slide-down",
    });
  }

  if ($(".event_type2").length) {
    var $owl = $(".event_type2");
    $owl.owlCarousel({
      rtl: yes_rtl,
      autoplay: true,
      autoplayHoverPause: true,
      items: 1,
      loop: true,
      dots: false,
      animateOut: "slide-up",
      animateIn: "slide-down",
      navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>",
      ],
      nav: true,
      autoplayTimeout: 8500,
      smartSpeed: 450,
    });
  }

  /*======================================
        Renew listing in bulk from bashboard
        ====================================*/
  $("#ren_exp_list").on("click", function () {
    expire_list_values();
  });

  function expire_list_values() {
    /* declare an checkbox array */
    var chkArray = [];

    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $(".expir_chk:checked").each(function () {
      chkArray.push($(this).val());
    });

    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(",");

    /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
    if (selected.length > 0) {
      $(".sonu-button").button("loading");
      $.post(ajax_url, {
        action: "dwt_ajax_renew_listings",
        listng_ids: selected,
      }).done(function (response) {
        $(".sonu-button").button("reset");
        var get_r = response.split("|");
        if ($.trim(get_r[0]) == "1") {
          $.alert({
            title: get_strings.congratulations,
            closeIcon: true,
            rtl: yes_rtl,
            icon: "fa fa-smile-o",
            theme: "modern",
            animation: "scale",
            type: "green",
            content: get_r[1],
            buttons: { okay: { btnClass: "btn-blue" } },
          });
          window.setTimeout(function () {
            location.reload();
          }, 1500);
        } else {
          $.alert({
            title: get_strings.whoops,
            rtl: yes_rtl,
            icon: "fa fa-frown-o",
            theme: "modern",
            animation: "scale",
            type: "red",
            closeIcon: true,
            backgroundDismiss: true,
            content: get_r[1],
            buttons: { okay: { btnClass: "btn-blue" } },
          });
        }
      });
    } else {
      $.alert({
        title: get_strings.whoops,
        rtl: yes_rtl,
        icon: "fa fa-frown-o",
        theme: "modern",
        animation: "scale",
        type: "red",
        closeIcon: true,
        backgroundDismiss: true,
        content: get_strings.fil_checkbox,
        buttons: { okay: { btnClass: "btn-blue" } },
      });
    }
  }

  /*==============================================
      Move Trashed to Expired Listing from Dashboard
      =============================================*/
  $("#move_to_exp_list").on("click", function () {
    move_to_expire_list_values();
  });

  function move_to_expire_list_values() {
    /* declare an checkbox array */
    var chkArray = [];

    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $(".trash_chk:checked").each(function () {
      chkArray.push($(this).val());
    });

    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(",");

    /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
    if (selected.length > 0) {
      $(".sonu-button").button("loading");
      $.post(ajax_url, {
        action: "dwt_ajax_trash_to_expired_listings",
        listng_ids: selected,
      }).done(function (response) {
        $(".sonu-button").button("reset");
        var get_r = response.split("|");
        if ($.trim(get_r[0]) == "1") {
          $.alert({
            title: get_strings.congratulations,
            closeIcon: true,
            rtl: yes_rtl,
            icon: "fa fa-smile-o",
            theme: "modern",
            animation: "scale",
            type: "green",
            content: get_r[1],
            buttons: { okay: { btnClass: "btn-blue" } },
          });
          window.setTimeout(function () {
            location.reload();
          }, 1500);
        } else {
          $.alert({
            title: get_strings.whoops,
            rtl: yes_rtl,
            icon: "fa fa-frown-o",
            theme: "modern",
            animation: "scale",
            type: "red",
            closeIcon: true,
            backgroundDismiss: true,
            content: get_r[1],
            buttons: { okay: { btnClass: "btn-blue" } },
          });
        }
      });
    } else {
      $.alert({
        title: get_strings.whoops,
        rtl: yes_rtl,
        icon: "fa fa-frown-o",
        theme: "modern",
        animation: "scale",
        type: "red",
        closeIcon: true,
        backgroundDismiss: true,
        content: get_strings.fil_checkbox,
        buttons: { okay: { btnClass: "btn-blue" } },
      });
    }
  }

  //adding ajax for events tickets submit form

  $("#proceed_booking").on("click", function (e) {
    if (e.isDefaultPrevented()) {
      return false;
    } else {
      var ajax_url = $("input#dwt_listing_ajax_url").val();
      var event_id = $("#event_id").val();
      var event_name = $("#event_name").val();
      var price_of_ticket = document.getElementById("inner_sum").innerHTML;
      var extra_service_price =
        document.getElementById("addition_ES").innerHTML;
      var grand_total = document.getElementById("grand_total").innerHTML;
      var number_of_tickets = $("#tickets_quantity").val();
      var customer_name = $("#current_user_name").val();
      var event_date = $("#event_date").val();
      var woo_symb = $("#hidden_woo_currency_symbol").val();
      var grand_total_ = document.getElementById("grand_total_").value;
      var total_number_of_tickets = $("#total_number_of_tickets").val();

      $.post(ajax_url, {
        action: "tickets_booking",
        event_id: event_id,
        tickets_price: price_of_ticket,
        extra_services: extra_service_price,
        grand_total: grand_total,
        total_tickets: number_of_tickets,
        total_number_of_tickets: total_number_of_tickets,
        customers_name: customer_name,
        event_name: event_name,
        event_date: event_date,
        grand_total_: grand_total_,
        woo_symb: woo_symb,
      }).done(function (response) {
        var res_arr = response.toString().split("|");

        if ($.trim(res_arr[0]) == "1") {
          $.alert({
            title: get_strings.congratulations,
            closeIcon: true,
            rtl: yes_rtl,
            icon: "fa fa-smile-o",
            theme: "modern",
            animation: "scale",
            type: "green",
            content: get_strings.redirecting_success,
            backgroundDismiss: true,
            buttons: { okay: { btnClass: "btn-blue" } },
          });

          location.replace(res_arr[2]);
        } else {
          $.alert({
            title: get_strings.whoops,
            closeIcon: true,
            rtl: yes_rtl,
            icon: "fa fa-frown-o",
            theme: "modern",
            animation: "scale",
            type: "red",
            content: response.data?.message ? response.data?.message : res_arr[1],
            backgroundDismiss: true,
          });
        }
      });

      return false;
    }
  });

  if ($("#is_rtl").val() !== "" && $("#is_rtl").val() === "1") {
    $("#menu-1").megaMenu({
      // DESKTOP MODE SETTINGS
      logo_align: "left",
      links_align: "left",
      socialBar_align: "right",
      searchBar_align: "left",
      trigger: "hover",
      effect: "expand-top",
      effect_speed: 400,
      sibling: true,
      outside_click_close: true,
      top_fixed: false,
      sticky_header: false,
      sticky_header_height: 200,
      menu_position: "horizontal",
      full_width: true,
      // MOBILE MODE SETTINGS
      mobile_settings: {
        collapse: true,
        sibling: true,
        scrollBar: true,
        scrollBar_height: 400,
        top_fixed: false,
        sticky_header: false,
        sticky_header_height: 200,
      },
    });
    $(window).on("load", function () {
      $(".counter-stats").counterUp({
        delay: 10,
        time: 2000,
      });
      $(".masonry_container").imagesLoaded(function () {
        // init Isotope
        var $grid = $(".masonery_wrap").isotope({
          itemSelector: ".masonery_item",
          percentPosition: true,
          originLeft: false,
          layoutMode: "fitRows",
          transitionDuration: "0.7s",
          masonry: {
            // use outer width of grid-sizer for columnWidth
            columnWidth: ".masonery_item",
          },
        });
      });
    });
  } else {
    $("#menu-1").megaMenu({
      // DESKTOP MODE SETTINGS
      logo_align: "left",
      links_align: "left",
      socialBar_align: "left",
      searchBar_align: "right",
      trigger: "hover",
      effect: "expand-top",
      effect_speed: 400,
      sibling: true,
      outside_click_close: true,
      top_fixed: false,
      sticky_header: false,
      sticky_header_height: 200,
      menu_position: "horizontal",
      full_width: true,
      // MOBILE MODE SETTINGS
      mobile_settings: {
        collapse: true,
        sibling: true,
        scrollBar: true,
        scrollBar_height: 400,
        top_fixed: false,
        sticky_header: false,
        sticky_header_height: 200,
      },
    });
    $(window).on("load", function () {
      $(".counter-stats").counterUp({
        delay: 10,
        time: 2000,
      });
      $(".masonry_container").imagesLoaded(function () {
        // init Isotope
        var $grid = $(".masonery_wrap").isotope({
          itemSelector: ".masonery_item",
          percentPosition: true,
          layoutMode: "fitRows",
          transitionDuration: "0.7s",
          masonry: {
            // use outer width of grid-sizer for columnWidth
            columnWidth: ".masonery_item",
          },
        });
      });
    });
  }
  window.sr = ScrollReveal({ duration: 700, reset: false, mobile: false });
  sr.reveal(".foo");

  /*
   * Character limit set for title on submit listing.
   */
  $("#listing_title").on("input", function () {
    var maxlength = $("#charLimit").val();
    var currentLength = $(this).val().length;

    if (currentLength >= maxlength) {
      $.alert({
        title: "Character Limit Restriction",
        rtl: yes_rtl,
        icon: "fa fa-frown-o",
        theme: "modern",
        animation: "scale",
        type: "red",
        closeIcon: true,
        backgroundDismiss: true,
        content: `Character limit set to ${maxlength} Characters.`,
        buttons: { okay: { btnClass: "btn-blue" } },
      });
    }
  });
})(jQuery);

jQuery(document).ready(function ($) {
  "use strict";
  jQuery(".jqte_editor").on("paste", function (e) {
    e.preventDefault();
    var text = e.originalEvent.clipboardData.getData("text");
    // insert copied data @ the cursor location
    document.execCommand("insertText", false, text);
  });
});
var $ = jQuery.noConflict();
jQuery(document).ready(function () {
  "use strict";
  $(".leftSidebar, .rightSidebar").theiaStickySidebar({
    additionalMarginTop: 5,
  });
  $(".tool-tip").tipsy({
    arrowWidth: 10,
    attr: "data-tipsy",
    cls: null,
    duration: 150,
    offset: 7,
    position: "top-center",
    trigger: "hover",
  });
  if (window.location.href.indexOf("#myModal") != -1) {
    setTimeout(function () {
      $("#myModal").modal("show");
    }, 1000);
  }
});
$(function () {
  var Accordion = function (el, multiple) {
    this.el = el || {};
    this.multiple = multiple || false;
    // Variables privadas
    var links = this.el.find(".profile-menu-link");
    // Evento
    links.on("click", { el: this.el, multiple: this.multiple }, this.dropdown);
  };
  Accordion.prototype.dropdown = function (e) {
    var $el = e.data.el;
    ($this = $(this)), ($next = $this.next());
    $next.slideToggle();
    $this.parent().toggleClass("open");
    if (!e.data.multiple) {
      $el.find(".submenu").not($next).slideUp().parent().removeClass("open");
    }
  };
  var accordion = new Accordion($("#accordion"), false);
  //$('#accordion_listing_detial .panel-collapse:not(".in")').collapse('show');
  $("a[href*=\\#].scroller:not([href=\\#])").click(function () {
    var target = $(this.hash);
    target = target.length ? target : $("[name=" + this.hash.substr(1) + "]");
    if (target.length) {
      $("html,body").animate(
        {
          scrollTop: target.offset().top,
        },
        1000
      );
      return false;
    }
  });
});
$(document).ready(function () {
  $("#intro-hero .category-section .owl-carousel.category-list1").attr(
    "style",
    "display: block !important"
  );
});

//adding my js for onclick event of calendar

// Get the modal
var modal = document.getElementById("mycalendarModal");

// Get the button that opens the modal
var btn = document.getElementById("myCalendarBtns");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal

$("#myCalendarBtns").on("click", function () {
  modal.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
  modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

$('#toggleQuestions').click(function () {
  $('#event_questionaire').slideToggle();
  $('#listOfQuestions').slideToggle();
  $('.event_faq_chevron').toggleClass('rotate-icon');
});

$('#toggleDays').click(function () {
  $('.adding_new_days_schedule').slideToggle();
  $('#listOfDaysName').slideToggle();
  $('.add_schedule_button').slideToggle();
  $('.event_days_chevron').toggleClass('rotate-icon');
});

$('#toggleSchedule').click(function () {
  $('#event_schedule').slideToggle();
  $('#listOfSchedule').slideToggle();
  $('.event_sch_chevron').toggleClass('rotate-icon');
});

// for adding event schedule start
var givenSchedule = document.querySelector("#schedule_question")
var givenScheduleAnswer = document.querySelector("#schedule_answer")
var btnClass = document.querySelector("#addScheduleBtn");
var listOfSchedule = document.querySelector("#listOfSchedule");
var listOfAnswers = document.querySelector("#listOfAnswers");

$("#addScheduleBtn").on("click", () => {
  var myQuestion = givenSchedule.value ? givenSchedule.value : '';
  var myAnswer = givenScheduleAnswer.value ? givenScheduleAnswer.value : '';

  var createScheduleList = `<li class="schedule-question">
    <div><input type="text" id="schedule_question" name ="event_question_schedule[question][]" placeholder="Your Schedule Here"><input type="text" id="schedule_answer"  name ="event_question[answer][]"  placeholder="Your Answer Here"</div>
    <button class="btn" onclick="removeNameFromTheList(this)" >Remove This Schedule</button>`;
  listOfSchedule.innerHTML += createScheduleList;
  // listOfAnswers.innerHTML += createAnswersList;
  // givenQuestion.value = "";
  // givenQuestion.classList.remove("red");
  // givenAnswer.value = "";
  // givenAnswer.classList.remove("red");
  givenQuestion.classList.remove("red");
});

// for adding event schedule end

//for adding duplicate fields
var givenQuestion = document.querySelector("#question");
var givenAnswer = document.querySelector("#answer");
var btnClass = document.querySelector("#addNameButton");
var listOfQuestions = document.querySelector("#listOfQuestions");
var listOfAnswers = document.querySelector("#listOfAnswers");

$("#addNameButton").on("click", () => {
  var myQuestion = givenQuestion.value;
  var myAnswer = givenAnswer.value;

  var createQuestionsList = `<li class="faq-question">
    <div><input type="text" id="question" name ="event_question[question][]" placeholder="Your Question Here"><input type="text" id="answer"  name ="event_question[answer][]"  placeholder="Your Answer Here"</div>
    <button class="btn" onclick="removeNameFromTheList(this)" >Remove This Question</button>`;
  listOfQuestions.innerHTML += createQuestionsList;
  listOfAnswers.innerHTML += createAnswersList;
  givenQuestion.value = "";
  givenQuestion.classList.remove("red");
  givenAnswer.value = "";
  givenAnswer.classList.remove("red");
  givenQuestion.classList.remove("red");
});

function removeNameFromTheList(e) {
  e.parentElement.remove();
}

var giventicket_price = document.querySelector("#ticket_price");
var giventickets_description = document.querySelector("#tickets_description");
var givenno_of_tickets = document.querySelector("#no_of_tickets");
var btnClass_11 = document.querySelector("#addNameButton_11");
var listOfQuestions_11 = document.querySelector("#listOfQuestions_11");

$("#addNameButton_11").on("click", () => {
  var myticket_price = giventicket_price.value;
  var mytickets_description = giventickets_description.value;
  var myno_of_tickets = givenno_of_tickets.value;
  giventicket_price.value = "";
  giventickets_description.classList.remove("red");
  giventickets_description.value = "";
  giventicket_price.classList.remove("red");
  givenno_of_tickets.value = "";
  givenno_of_tickets.classList.remove("red");
});

function removeNameFromTheList(e) {
  e.parentElement.remove();
}

//pastingss

//adding script for days input
// var givenDayName = document.querySelector("#newDays");
// var givenDayDetails = document.querySelector("#schedule_description");
// var btnDayClass = document.querySelector("#addDaysButton");
// var listOfDaysName = document.querySelector("#listOfDaysName");
// $("#addDaysButton").on("click", () => {
//   var actualDaysName = givenDayName.value;
//   var givenDaysDetails = givenDayDetails.value;

//   var createAnHTMLList = `<li class="textarea_input">
//     <div><h4>Add Another New Day</h4></div>
//     <div><input type="text" id="newDays" name='days_schedule[newDays][]' value=""  placeholder="Day Name Here"></div>
//     <div><textarea id="schedule_descriptions" class="jqte-primary"  name ="days_schedule[schedule_description][]" value=""  placeholder="Add Some Text Here"></textarea></div>
//     <button class="btn btn-danger" onclick="removeNameFromTheList(this)" >Remove This Schedule</button></li>`;
//   $("#listOfDaysName").append(createAnHTMLList);
//   givenDayName.classList.remove("red");
// });

// ============== adding script for days input ===================
    // Add new schedule entry
    $(".add_schedule_button").click(function() {
        var createAnHTMLList = `<div class="schedule_entry">
            <input type="text" class="day_name_input" name='days_schedule[newDays][]' placeholder="Day Name Here">
            <textarea rows="4" class="jqte-primary schedule_description_input" name='days_schedule[schedule_description][]' placeholder="Add Some Text Here"></textarea>
            <button class="btn btn-danger remove_schedule_button" type="button">Remove Schedule</button>
        </div>`;
        $("#addingNewDaysSchedule").append(createAnHTMLList);
    });

    // Remove schedule entry
    $(document).on("click", ".remove_schedule_button", function() {
        $(this).parent().remove();
    });
// ============== adding script for days input ===================

$("#form_select_timeslot").on("change", function () {
  $("#hotel_reservation_form").css("display", "none");
  $(".reservation-form").css("display", "block");
  $("#booking-slot").val($(this).val());
});

$(".selected_options").on("change", function (date, today, obj) {
  $("#hotel_reservation_form").css("display", "none");
  $(".reservation-form").css("display", "block");
});

$("#cancel_reservation").on("click", function () {
  $(".reservation-form").css("display", "none");
  $("#hotel_reservation_form").css("display", "block");
});

if ($('.switchinput[type="checkbox"]').is(":checked")) {
  $(".booking_fields").css("display", "block");
} else {
  $(".booking_fields").css("display", "hidden");
}

//adding duplicate pricing fields

var bookingTicketsTitle = document.querySelector("#booking_tickets_title");
var bookingTicketsDesc = document.querySelector("#booking_tickets_description");
var btnClass = document.querySelector("#booking_titcket_new_item");
var bookingTicketsTitle = document.querySelector("#booking_tickets_title");
var bookingTicketsDesc = document.querySelector("#booking_tickets_description");
var btnClass = document.querySelector("#booking_titcket_new_item");
var listOfTicketBooking = document.querySelector("#listOfTicketsBooking");
var listOfAnswers = document.querySelector("#listOfAnswers");

$("#booking_titcket_new_item").on("click", () => {
  var myQuestion = bookingTicketsTitle.value;
  var myAnswer = bookingTicketsDesc.value;

  var createQuestionsList = `<li class="faq-question">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <input type="text" id="booking_tickets_title" class="form-control" placeholder="Title">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <input type="text" id="booking_tickets_description" class="form-control" placeholder="Description">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <input type="number" id="booking_tickets_price" class="form-control" placeholder="Price" required>
        </div>
        <button onclick="removeNameFromTheList(this)" > 
            <div class="col-lg-1 col-md-1 col-sm-1"> 
                <div class="close_button text-danger">
                    <i class="ti-close"></i>
                </div>
            </div>
        </button>
    </div>
</li>`;
  listOfTicketBooking.innerHTML += createQuestionsList;
  bookingTicketsTitle.value = "";
  bookingTicketsTitle.classList.remove("red");
  bookingTicketsDesc.value = "";
  bookingTicketsDesc.classList.remove("red");
});
function removeNameFromTheList(e) {
  e.parentElement.remove();
}

//adding for extra services

var extra_services = document.querySelector("#e_services");
var camping_pitch = document.querySelector("#camping_pitch");
var camping_site = document.querySelector("#camping_site");
var extraServicesBtn = document.querySelector("#extraServicesBtn");
var listOfExtraServices = document.querySelector("#listOfExtraServices");

$("#extraServicesBtn").on("click", () => {
  var mye_services = extra_services.value;
  var mycamping_pitch = camping_pitch.value;
  var mycamping_site = camping_site.value;

  var createnewServicesList = `<li class="faq-question"><div class="duplicating_prices form_input_control">
    <input class="form-control " type="text" id="e_services" name ="event_e_services[e_services][]" placeholder="Title*" required>
    <input class="form-control " type="text" id="camping_pitch" name ="event_e_services[camping_pitch][]" placeholder="Description (optional)">
    <input class="form-control " type="text" id="camping_site" class="camping_sites" name ="event_e_services[camping_site][]"  placeholder="Price*" required> </div>
    <button class="extra_services_button" onclick="removeNameFromTheList(this)" >X</button>`;
  $("#listOfExtraServices").append(createnewServicesList);

  camping_pitch.classList.remove("red");
  extra_services.classList.remove("red");
  camping_site.classList.remove("red");
});

function removeNameFromTheList(e) {
  e.parentElement.remove();
}

///adding for extra services
$(function () {
  $(".add").on("click", function () {
    var currentVal = parseInt($(this).next(".qty").val());
    if (currentVal != NaN) {
      $(this)
        .next(".qty")
        .val(currentVal + 1);
    }
  });

  $(".minus").on("click", function () {
    var currentVal = parseInt($(this).prev(".qty").val());
    if (currentVal != NaN) {
      if (currentVal > 0) {
        $(this)
          .prev(".qty")
          .val(currentVal - 1);
      }
    }
  });
});

//increase number of tickets
var remaining_tickets = $("#remaining_tickets").val();

var number_of_tickets = $("#tickets_quantity").val();
if ($("#tickets_quantity").val() > "2") {
  $("#decrease_ticket").prop("disabled", false);
}

$("#increase_tickets").on("click", function () {
  var number_of_tickets = $("#tickets_quantity").val();
  number_of_tickets++;
  // var numbers_of_tickets = $("#total_tickets_quantity").val();
  // var number_of_ticketss = number_of_tickets + 1;
  var ticket_price = $("#price_per_ticket").val();
  var total_ticket_price = ticket_price * number_of_tickets;
  var extra_service_price = $("#addition_ES").text();
  var remaining_tickets = $("#remaining_tickets").val();
  var woo_symb = $("#hidden_woo_currency_symbol").val();

  var user_commission = $('#event_user_commission').val();
  var commission_per_ticket = parseFloat(ticket_price) * parseFloat(user_commission);
  var total_commission = parseFloat(commission_per_ticket) * parseFloat(number_of_tickets);

  if (user_commission !== undefined) {
    document.getElementById("ticket_service_charge").innerHTML =
    woo_symb + total_commission;
  }
  document.getElementById("inner_sum").innerHTML =
    woo_symb + total_ticket_price;
  $("#grand_total").innerHTML = woo_symb + ticket_price;
  $("#grand_total_").value = ticket_price;

  $("#grand_total").innerHTML = woo_symb + total_ticket_price;
  $("#grand_total_").value = total_ticket_price;

  var grand_total = total_ticket_price;
  if (extra_service_price != "") {
    document.getElementById("grand_total").innerHTML =
      woo_symb + (parseInt(grand_total) + parseInt(extra_service_price));
    document.getElementById("grand_total_").value =
      parseInt(grand_total) + parseInt(extra_service_price);
  } else {
    extra_service_price = 0;
    document.getElementById("grand_total").innerHTML =
      woo_symb + parseInt(grand_total);
    document.getElementById("grand_total_").value = parseInt(grand_total);
  }
  if ($("#tickets_quantity").val() == "1") {
    $("#decrease_ticket").prop("disabled", false);
  }
});

//decrease number of tickets
$("#decrease_ticket").on("click", function () {
  if ((document.getElementById("inner_sum").innerHTML = "")) {
    die;
  } else {
    var number_of_tickets = $("#tickets_quantity").val();
    number_of_tickets = number_of_tickets - 1;
    var ticket_price = $("#price_per_ticket").val();
    var extra_service_price = $("#addition_ES").text();
    var woo_symb = $("#hidden_woo_currency_symbol").val();

    var user_commission = $('#event_user_commission').val();
    var commission_per_ticket = parseFloat(ticket_price) * parseFloat(user_commission);
    var total_commission = parseFloat(commission_per_ticket) * parseFloat(number_of_tickets);

    if (user_commission !== undefined) {
      document.getElementById("ticket_service_charge").innerHTML =
      woo_symb + total_commission;
    }

    var total_ticket_price = ticket_price * number_of_tickets;
    var subtract_ticket_price = total_ticket_price - ticket_price;
    var woo_symb = $("#hidden_woo_currency_symbol").val();
    if(number_of_tickets === 0) {
      var tree = (document.getElementById("inner_sum").innerHTML =
        woo_symb + 0);
    } else {
      var tree = (document.getElementById("inner_sum").innerHTML =
        woo_symb + subtract_ticket_price);
    }

    if (extra_service_price != "") {
      if(number_of_tickets === 0) {
        var grand_total = (document.getElementById("grand_total").innerHTML = 0);
        document.getElementById("grand_total_").value = 0;
      } else {
        var grand_total = (document.getElementById("grand_total").innerHTML =
          parseInt(total_ticket_price) + parseInt(extra_service_price));
        document.getElementById("grand_total_").value =
          parseInt(total_ticket_price) + parseInt(extra_service_price);
      }
    } else {
      extra_service_price = 0;
      if(number_of_tickets === 0) {
        var grand_total = (document.getElementById("grand_total").innerHTML = 0);
        document.getElementById("grand_total_").value = 0;
      } else {
        var grand_total = (document.getElementById("grand_total").innerHTML =
          parseInt(total_ticket_price) + parseInt(extra_service_price));
        document.getElementById("grand_total_").value =
          parseInt(total_ticket_price) + parseInt(extra_service_price);
      }
    }

    // var grand_total = addition_of_es_prices + total_ticket_price;
    // document.getElementById("grand_total").innerHTML =
    //   woo_symb + (grand_total - ticket_price);
    // document.getElementById("grand_total_").value = grand_total - ticket_price;
  }
  if ($("#tickets_quantity").val() <= "1") {
    $("#decrease_ticket").prop("disabled", true);
  }
});
//decrease number of tickets

$(".add_extra_services_price").on("click", function () {
  var extra_services_menu_list = $(this).attr("id");
  $(this).hide();
  $(this)
    .parents(".extra_services_price")
    .find(".remove_extra_services_price")
    .show();

  //total price of tickets
  var number_of_tickets = $("#tickets_quantity").val();
  var ticket_price = $("#price_per_ticket").val();
  var previous_service_price = $("#addition_ES").text();
  var woo_symb = $("#hidden_woo_currency_symbol").val();

  var total_ticket_price = ticket_price * number_of_tickets;
  document.getElementById("inner_sum").innerHTML =
    woo_symb + total_ticket_price;
  //price of extra services
  var extra_service_price = $(this)
    .parents(".extra_services_price")
    .find("#extra_service_prices")
    .val();

  var addition_of_es_prices = parseFloat(extra_service_price);

  if (previous_service_price != "") {
    total_service_price =
      parseFloat(previous_service_price) + addition_of_es_prices;
  } else {
    total_service_price = addition_of_es_prices;
  }
  document.getElementById("addition_ES").innerHTML = total_service_price;

  var grand_total = addition_of_es_prices + total_ticket_price;
  document.getElementById("grand_total").innerHTML =
    woo_symb + (total_ticket_price + total_service_price);
  document.getElementById("grand_total_").value =
    total_ticket_price + total_service_price;

  var title_of_extra_services = $(this)
    .parents(".extra_services_price")
    .find("#detail_of_extra_services")
    .val();

  document.getElementById("extra_service_list").innerHTML +=
    "<li class= " +
    extra_services_menu_list +
    ">" +
    '<div class="extra_service_inner_section">' +
    "<div>" +
    title_of_extra_services +
    "</div>" +
    "<div>" +
    woo_symb +
    extra_service_price +
    "</div>" +
    "</div>" +
    "</li>";
});

$(".remove_extra_services_price").on("click", function () {
  $(this).hide();
  $(this)
    .parents(".extra_services_price")
    .find(".add_extra_services_price")
    .show();

  var number_of_tickets = $("#tickets_quantity").val();
  var ticket_price = $("#price_per_ticket").val();
  var total_ticket_price = ticket_price * number_of_tickets;
  var woo_symb = $("#hidden_woo_currency_symbol").val();
  //price of extra services
  var extra_service_price = $(this)
    .parents(".extra_services_price")
    .find("#extra_service_prices")
    .val();
  var addition_of_es_prices = parseInt(extra_service_price);

  var previous_service_price = $("#addition_ES").text();
  if (previous_service_price != "") {
    total_service_price =
      parseInt(previous_service_price) - addition_of_es_prices;
  } else {
    previous_service_price = 0;
    total_service_price = addition_of_es_prices;
  }
  document.getElementById("addition_ES").innerHTML = total_service_price;
  var grand_total = total_service_price + parseInt(total_ticket_price);
  document.getElementById("grand_total").innerHTML = woo_symb + grand_total;
  document.getElementById("grand_total_").value = grand_total;
  var extra_services_menu_list = $(this).attr("id");
  $("." + extra_services_menu_list).remove();
});

//toggle hide and show tickets section

$(".switch_for_tickets_main_checkbox").on("click", function () {
  if ($(this).is(":checked")) {
    $(".event_tickets_extra_services_wrapper").show();
  } else {
    $(".event_tickets_extra_services_wrapper").hide();
    $(".event-tickets").hide();
    $("#no_of_tickets").attr("required", false);
    $("#ticket_price").attr("required", false);
  }
});

$(".switch_for_extra_services_checkbox").on("click", function () {
  if ($(this).is(":checked")) {
    $(".pricing_booking_inputs_inner").show();
    $(".event_tickets_extra_services_wrapper").show();
  } else {
    if ($(this).not(":checked")) {
      $(".pricing_booking_inputs_inner").hide();
      $(".accordion_for_question").hide();
    }
  }
});
if (
  $("#flush-collapse_e_services > .accordion-body").length <= 0 &&
  $(".switch_for_extra_services_checkbox").not(":checked")
) {
  $(".pricing_collapsed").css("display", "none");
  $(".extra_services_list").css("display", "none", "important");
}
$("#booking_status").onSelect = () => {
  if ("#booking_status option".val() === "Approved") {
    this.css.backgroundColor = "red";
  }
  alert("You selected some text!");
};

$(".js-example-basic-multiple").select2();


// jQuery(document).ready(function($) {
//     // Function to update cart item names with order IDs
//     function updateCartItemNamesWithOrderIDs() {
//         // Loop through each cart item
//         $('.woocommerce-cart-form__cart-item').each(function() {
//             var cartItem = $(this);
//             var productId = cartItem.find('[name^="cart_item"]').val(); // Get the product ID
            
//             // AJAX request to fetch order ID for the product
//             $.ajax({
//                 url: ajaxurl, // WordPress AJAX endpoint
//                 type: 'POST',
//                 data: {
//                     action: 'get_order_id_for_product', // AJAX action
//                     product_id: productId // Product ID to fetch order ID
//                 },
//                 success: function(response) {
//                     // Append order ID to cart item name
//                     cartItem.find('.product-name').append(' (Order ID: ' + response + ')');
//                 }
//             });
//         });
//     }

//     // Call the function when the cart is updated or when the page is loaded
//     $(document.body).on('updated_cart_totals', updateCartItemNamesWithOrderIDs);
//     updateCartItemNamesWithOrderIDs(); // Call on page load
// });
