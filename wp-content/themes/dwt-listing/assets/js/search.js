(function ($) {
  "use strict";
  var ajax_url = $("input#dwt_listing_ajax_url").val();
  $(document).ready(function () {
    $("#order_by").on("change", function () {
      $(this).closest("form").submit();
    });

    $("#l_category").on("change", function () {
      $(".l_category_select.ajax-loader").show();
      $(this).closest("form").submit();
    });

    $("#select-price").on("change", function () {
      $(".l_price_type.ajax-loader").show();
      $(this).closest("form").submit();
    });

    $("#l_listing_status").on("change", function () {
      $(".l_listing_status.ajax-loader").show();
      $(this).closest("form").submit();
    });

    $("#rated-as").on("change", function () {
      $(".l_rating.ajax-loader").show();
      $(this).closest("form").submit();
    });

    $(".submit_on_select").on("click", function () {
      $(this).closest("form").submit();
    });

    /* Country */
    $("#l_location").on("change", function () {
      $(".custom_loc.ajax-loader").show();
      var city = $(this).val();
      $("input[name=l_location]").val(city);
      $.post(ajax_url, {
        action: "dwt_listing_get_locations",
        city_id: city,
      }).done(function (response) {
        $(".custom_loc.ajax-loader").hide();
        $("#d_state").val("");
        $("#d_city").val("");
        $("#d_town").val("");
        if ($.trim(response) != "") {
          $("#states").css("display", "block");
          $("#d_state").html(response);
        } else {
          $("#states").css("display", "none");
          $("#city").css("display", "none");
          $("#town").css("display", "none");
        }
      });
    });

    $("#d_state").on("change", function () {
      $(".custom_loc2.ajax-loader").show();
      var city = $(this).val();
      $("input[name=l_location]").val(city);
      $.post(ajax_url, {
        action: "dwt_listing_get_locations",
        city_id: city,
      }).done(function (response) {
        $(".custom_loc2.ajax-loader").hide();
        $("#d_city").val("");
        $("#d_town").val("");
        if ($.trim(response) != "") {
          $("#city").css("display", "block");
          $("#d_city").html(response);
        } else {
          $("#city").css("display", "none");
          $("#town").css("display", "none");
        }
      });
    });

    /* City */
    $("#d_city").on("change", function () {
      $(".custom_loc3.ajax-loader").show();
      var city = $(this).val();
      $("input[name=l_location]").val(city);
      $.post(ajax_url, {
        action: "dwt_listing_get_locations",
        city_id: city,
      }).done(function (response) {
        $(".custom_loc3.ajax-loader").hide();
        $("#d_town").val("");
        if ($.trim(response) != "") {
          $("#town").css("display", "block");
          $("#d_town").html(response);
        } else {
          $("#town").css("display", "none");
        }
      });
    });
  });

  $("#d_town").on("change", function () {
    var city = $(this).val();
    $("input[name=l_location]").val(city);
  });

  var map_lat = parseFloat($("#map_lat").val());
  var map_long = parseFloat($("#map_long").val());
  if (search_strings.s_lat != "" && search_strings.s_lon != "") {
    map_lat = search_strings.s_lat;
    map_long = search_strings.s_lon;
  }
  if (map_lat && map_long) {
    var my_icons =
      document.getElementById("theme_path").value + "assets/images/map-pin.png";
    if ($("#mapid").length) {
      var map = L.map("mapid").setView([map_lat, map_long], 12);
      L.control.fullscreen().addTo(map);
      L.tileLayer(
        "https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png"
      ).addTo(map);
      var myIcon = L.icon({
        iconUrl: my_icons,
        iconRetinaUrl: my_icons,
        iconSize: [38, 64],
        iconAnchor: [20, 60],
        popupAnchor: [0, -65],
      });

      var markerClusters = L.markerClusterGroup();
      for (var i = 0; i < listing_markers.length; ++i) {
        var popup =
          '<div class="map-in-listings"><div class="list-thumbnail"><a href="' +
          listing_markers[i].listing_link +
          '"><img class="img-responsive" src="' +
          listing_markers[i].img +
          '" alt=""></a>' +
          listing_markers[i].is_featured +
          '</div><div class="entry-header"><h3 class="entry-title"><a href="' +
          listing_markers[i].listing_link +
          '">' +
          listing_markers[i].title +
          ' </a></h3><div class="entry-meta">' +
          listing_markers[i].ratings +
          '<span class="posted-date">' +
          listing_markers[i].posted_on +
          "</span></div></div></div>";
        var m = L.marker([listing_markers[i].lat, listing_markers[i].lng], {
          icon: myIcon,
        }).bindPopup(popup, { minWidth: 270, maxWidth: 270 });
        markerClusters.addLayer(m);
        map.addLayer(markerClusters);
        map.fitBounds(markerClusters.getBounds());
      }
      var loader = L.control.loader().addTo(map);
      setTimeout(function () {
        loader.hide();
      }, 1500);
      map.scrollWheelZoom.disable();
      map.invalidateSize();
    }
  }

  //map
  $(".cost_range").on("ifClicked", function () {
    var ptype_id = $(this).val();
    $("input[name=l_price_type]").val(ptype_id);
    $(this).closest("form").submit();
  });

  $(".open_now").on("click", function () {
    $(this).closest("form").submit();
  });

  $(".h_rated").on("click", function () {
    $(this).closest("form").submit();
  });
})(jQuery);
