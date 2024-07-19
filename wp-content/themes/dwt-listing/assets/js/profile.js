// document.addEventListener('DOMContentLoaded', function () {
//   var meetingLinkBox = document.querySelector('.form-meeting');
//   var statusDropdown = document.getElementById('booking_status');


//   if (statusDropdown.value !== 'Approved') {
//       meetingLinkBox.style.display = 'none';
//   }


//   statusDropdown.addEventListener('change', function () {
//       if (this.value === 'Approved') {
//           meetingLinkBox.style.display = 'block';
//       } else {

//           meetingLinkBox.style.display = 'none';
//       }
//   });
// });
(function ($) {
  "use strict";
  var ajax_url = $("input#dwt_listing_ajax_url").val();
  var yes_rtl;
  if ($("#is_rtl").val() !== "" && $("#is_rtl").val() === "1") {
    yes_rtl = true;
  } else {
    yes_rtl = false;
  }

  if ($(".admin-panel-scroll").length > 0) {
    $(".admin-panel-scroll .panel-body").slimScroll({
      height: "800px",
      wheelStep: 12,
    });
  }

  if ($("#sidebar-nav .sidebar-scroll").length > 0) {
    $("#sidebar-nav .sidebar-scroll").slimScroll({
      height: "auto",
      wheelStep: 10,
      color: "#ccc",
    });
  }

  $(".collaspe-btn-admin").on("click", function () {
    $(this).find(".lnr").toggleClass("lnr-menu lnr-cross");

    if ($(window).innerWidth() < 1025) {
      if (!$("body").hasClass("admin-sidebar-active")) {
        $("body").addClass("admin-sidebar-active");
      } else {
        $("body").removeClass("admin-sidebar-active");
      }
    }
  });

  var readURL = function (input) {
    if (input.files && input.files[0]) {
      var fd = new FormData();
      var files_data = $(".profile-file-upload");
      $.each($(files_data), function (i, obj) {
        $.each(obj.files, function (j, file) {
          fd.append("my_file_upload[" + j + "]", file);
        });
      });

      fd.append("action", "upload_user_pic");
      $.ajax({
        type: "POST",
        url: ajax_url,
        data: fd,
        contentType: false,
        processData: false,
        success: function (res) {
          var res_arr = res.split("|");
          if ($.trim(res_arr[0]) == "1") {
            $(".profile-pic").attr("src", res_arr[1]);
            $(".resize").attr("src", res_arr[1]);
            $("#img-upload-success").show();
          } else if ($.trim(res_arr[0]) == "0") {
            $("#max-img-size").show();
          } else {
            $("#error-messages").show();
          }
        },
      });
    }
  };
  $(".profile-file-upload").on("change", function () {
    readURL(this);
  });

  $(".profile-upload-button").on("click", function () {
    $(".profile-file-upload").click();
  });

  /*--- Reset Password ---*/
  $("#resetPassword")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        $(".sonu-button-reset").button("loading");
        $.post(ajax_url, {
          action: "dwt_listing_resetmy",
          collect_data: $("form#resetPassword").serialize(),
        }).done(function (response) {
          $(".sonu-button-reset").button("reset");
          if ($.trim(response) == "1") {
            $("#password-success").show();
          }
        });
      }
      return false;
    });

  /*--- Registration Form Action ---*/
  $("#profile-update")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        $(".update_profile").button("loading");
        $.post(ajax_url, {
          action: "dwt_listing_profile_update",
          collect_data: $("form#profile-update").serialize(),
        }).done(function (response) {
          $(".update_profile").button("reset");
          if ($.trim(response) == "1") {
            $("#p_up").hide();
            $("#success-messages").show();
            window.setTimeout(function () {
              window.location.reload(true);
            }, 1000);
          }
        });
        /*--- stop submitting ---*/
        return false;
      }
    });

  /*--- Events  ---*/
  function dwt_listing_eventz_zone() {
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = "image/*";
    var fileList = new Array();
    var i = 0;
    $("#event_dropzone").dropzone({
      addRemoveLinks: true,
      paramName: "my_file_upload",
      maxFiles: $("#event_upload_limit").val(),
      gallery_limit: $("#event_img_size").val(),
      acceptedFiles: ".jpeg,.jpg,.png",
      dictMaxFilesExceeded: $("#max_upload_reach").val(),
      url:
        ajax_url +
        "?action=upload_dwt_listing_events_images&is_update=" +
        $("#is_update").val(),
      parallelUploads: 1,
      dictDefaultMessage: $("#dictDefaultMessage").val(),
      dictFallbackMessage: $("#dictFallbackMessage").val(),
      dictFallbackText: $("#dictFallbackText").val(),
      dictFileTooBig: $("#dictFileTooBig").val(),
      dictInvalidFileType: $("#dictInvalidFileType").val(),
      dictResponseError: $("#dictResponseError").val(),
      dictCancelUpload: $("#dictCancelUpload").val(),
      dictCancelUploadConfirmation: $("#dictCancelUploadConfirmation").val(),
      dictRemoveFile: $("#dictRemoveFile").val(),
      dictRemoveFileConfirmation: null,
      init: function () {
        var thisDropzone = this;
        let url =
          ajax_url +
          "?action=upload_dwt_listing_events_images&is_update=" +
          $("#is_update").val();

        console.log("URLS: ", url);
        $.post(ajax_url, {
          action: "get_event_images",
          is_update: $("#is_update").val(),
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
              $(".dz-progress").remove();
            });
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
            $("#listing_msgz").show();
            $("#listing_msgz .custom-alert__content").text(res_arr[1]);
          }
        });
        this.on("removedfile", function (file) {
          var img_id = file._removeLink.attributes[2].value;
          if (img_id != "") {
            i--;
            if (i == 0) $(".dz-message").show();
            $.post(ajax_url, {
              action: "delete_event_image",
              img: img_id,
              is_update: $("#is_update").val(),
            }).done(function (response) {
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
  dwt_listing_eventz_zone();
  /*--- speakers  ---*/
  function dwt_listing_speakers_zone() {
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = "image/*";
    var fileList = new Array();
    var i = 0;
    $("#speaker_dropzone").dropzone({
      addRemoveLinks: true,
      paramName: "my_file_upload",
      maxFiles: $("#speaker_upload_limit").val(),
      gallery_limit: $("#speaker_img_size").val(),
      acceptedFiles: ".jpeg,.jpg,.png",
      dictMaxFilesExceeded: $("#max_upload_reach").val(),
      url:
        ajax_url +
        "?action=upload_dwt_listing_speaker_images&is_update=" +
        $("#is_update").val(),
      parallelUploads: 1,
      dictDefaultMessage: $("#dictDefaultMessage").val(),
      dictFallbackMessage: $("#dictFallbackMessage").val(),
      dictFallbackText: $("#dictFallbackText").val(),
      dictFileTooBig: $("#dictFileTooBig").val(),
      dictInvalidFileType: $("#dictInvalidFileType").val(),
      dictResponseError: $("#dictResponseError").val(),
      dictCancelUpload: $("#dictCancelUpload").val(),
      dictCancelUploadConfirmation: $("#dictCancelUploadConfirmation").val(),
      dictRemoveFile: $("#dictRemoveFile").val(),
      dictRemoveFileConfirmation: null,
      init: function () {
        var thisDropzone = this;
        let url =
          ajax_url +
          "?action=upload_dwt_listing_events_images&is_update=" +
          $("#is_update").val();

        $.post(ajax_url, {
          action: "get_speaker_images",
          is_update: $("#is_update").val(),
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
              $(".dz-progress").remove();
            });
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
            $("#listing_msgz").show();
            $("#listing_msgz .custom-alert__content").text(res_arr[1]);
          }
        });
        this.on("removedfile", function (file) {
          var img_id = file._removeLink.attributes[2].value;
          if (img_id != "") {
            i--;
            if (i == 0) $(".dz-message").show();
            $.post(ajax_url, {
              action: "delete_speaker_image",
              img: img_id,
              is_update: $("#is_update").val(),
            }).done(function (response) {
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
  dwt_listing_speakers_zone();

  /*Create Event*/
  $("#event_title").on("blur", function () {
    $(".loader-field").css("display", "block");
    $.post(ajax_url, {
      action: "create_new_event",
      event_title: $("#event_title").val(),
      is_update: $("#is_update").val(),
    }).done(function (response) {
      $(".loader-field").css("display", "none");
    });
  });

  /*Create speaker by title*/
  $("#speaker_name").on("blur", function () {
    $(".loader-field").css("display", "block");
    $.post(ajax_url, {
      action: "create_new_speaker_by_title",
      speaker_title: $("#speaker_name").val(),
      is_update: $("#is_update").val(),
    }).done(function (response) {
      $(".loader-field").css("display", "none");
    });
  });

  /*--- Registration Form Action ---*/
  $("#my-events")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var is_update = $("#is_update").val();
        var curent_lang = $("#lang").val();
        var link = $('#webinar_link_input').val();
        var check = $('#share_webinar_link_checkbox').val();
        console.log('link: ', link);
        console.log('check: ', check);
        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "my_new_event",
          lang: curent_lang,
          collect_data: $("form#my-events").serialize(),
          is_update: $("#is_update").val(),
        }).done(function (response) {
          console.log(response);
          $(".sonu-button").button("reset");
          if (is_update) {
            $.alert({
              title: get_strings.congratulations,
              backgroundDismiss: true,
              rtl: yes_rtl,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: profile_strings.updated,
              buttons: {
                ShowEvent: function () {
                  window.open(response);
                },
                Cancel: function () { },
              },
            });
          } else {
            $.alert({
              title: get_strings.congratulations,
              rtl: yes_rtl,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: profile_strings.created,
              buttons: {
                ShowEvent: function () {
                  window.open(response);
                },
                Cancel: function () { },
              },
            });
          }
        });
        /*--- stop submitting ---*/
        return false;
      }
    });

  // Create Speaker
  $("#create-speaker").validator().on('submit', function (e) {
    e.preventDefault();
    var is_update = $("#is_update").val();
    var current_lang = $("#lang").val();

    $(".sonu-button").button("loading");

    $.post(ajax_url, {
      action: "create_new_speaker",
      lang: current_lang,
      collect_data: $("form#create-speaker").serialize(),
      is_update: is_update,
    }).done(function (response) {
      console.log(response);
      $(".sonu-button").button("reset");
      if (response.success) {
        if (is_update) {
          $.alert({
            title: get_strings.congratulations,
            closeIcon: true,
            rtl: yes_rtl,
            icon: "fa fa-smile-o",
            theme: "modern",
            animation: "scale",
            type: "green",
            content: profile_strings.speaker_update_success,
          });
        } else {
          $.alert({
            title: get_strings.congratulations,
            closeIcon: true,
            rtl: yes_rtl,
            icon: "fa fa-smile-o",
            theme: "modern",
            animation: "scale",
            type: "green",
            content: profile_strings.speaker_creation_success,
          });
        }
      } else if (!response.success) {
        $.alert({
          title: get_strings.whoops,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-frown-o",
          theme: "modern",
          animation: "scale",
          type: "red",
          content: response.data,
        });
      }
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error:", textStatus, errorThrown);
      $(".sonu-button").button("reset");
    });
  });
  // Create Speaker

  // ============Zoom Settings =================
  $('#zoom-settings').validator().on('submit', function (e) {
    e.preventDefault();
    $(".sonu-button").button("loading");
    var tncCheckbox = $('#zoomTermsAndCondition');
    var zoom_email = $('#zoom_email').val();
    var client_id = $('#zoom_client_id').val();
    var client_secret = $('#zoom_client_secret').val();
    var zoomEmailError = $('#zoomEmailError').hide();
    var zoomClientIdError = $('#zoomClientIdError').hide();
    var zoomClientSecretError = $('#zoomClientSecretError').hide();
    var tncCheckboxError = $('#zoomTermsAndConditionError').hide();
    var validationErrors = [];

    if (zoom_email === '') {
      validationErrors.push(zoomEmailError);
    }
    if (client_id === '') {
      validationErrors.push(zoomClientIdError);
    }
    if (client_secret === '') {
      validationErrors.push(zoomClientSecretError);
    }

    if (validationErrors.length === 0) {
      if (tncCheckbox.is(":checked")) {
        $.post(ajax_url, {
          action: "dwt_save_zoom_settings",
          form_data: $("form#zoom-settings").serialize(),
        }).done(function (res) {
          $(".sonu-button").button("reset");
          if (res.success) {
            $.alert({
              title: get_strings.congratulations,
              closeIcon: true,
              rtl: yes_rtl,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: res.data,
            });
          } else {
            $.alert({
              title: get_strings.whoops,
              closeIcon: true,
              rtl: yes_rtl,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: res.data,
            });
          }
        }).fail(function (jqXHR, textStatus, errorThrown) {
          console.error("Error:", textStatus, errorThrown);
          $(".sonu-button").button("reset");
        });
      } else {
        $(".sonu-button").button("reset");
        tncCheckboxError.show();
      }
    } else {
      $(".sonu-button").button("reset");
      validationErrors.forEach(function (error) {
        error.show();
      });
    }
  });


  $('#zoomTermsAndCondition').change(function () {
    if ($(this).is(":checked")) {
      $('#zoomTermsAndConditionError').hide();
    }
  });
  // ============Zoom Settings =================

  // =========== Zoom Auth =====================
  $('.meeting_authorization').click(function () {
    var reservationId = $(this).closest('.meeting-container').find('.reservation_id_listing').val();
    var $button = $(this);
    $button.button("loading");
    $.post(ajax_url, {
      action: 'dwt_zoom_auth_user',
    }).done(function (response) {
      $button.button("reset");
      var zoom_auth_window = window.open(response,
        '', 'scrollbars=no,menubar=no,resizable=yes,toolbar=no,status=no,width=800, height=400');

      var auth_window_timer = setInterval(function () {
        console.log("Checking if window is closed...");
        if (zoom_auth_window.closed) {
          clearInterval(auth_window_timer);

          $.post(ajax_url, {
            reservation_id: reservationId,
            action: 'dwt_load_zoom_meeting_form_func',
          }).done(function (response) {
            $("#zoom_meeting_container").html(response);
            $('.zoom-meeting-popup').modal('show');
            $("#meeting_authorization").attr("disabled", false);
          }).fail(function (xhr, status, error) {
            console.error("Error:", error);
          });
        }
      }, 500);

      $(".meeting_authorization").attr("disabled", false);
    });
  });
  // =========== Zoom Auth =====================

  // =========== Zoom Refresh Access Token =====================
  $('#refresh_zoom_token').click(function () {
    $(".refresh-token-button").button("loading");
    $.post(ajax_url, {
      action: 'dwt_refresh_zoom_access_token'
    }).done(function (response) {
      $(".refresh-token-button").button("reset");
      if (response.success) {
        $.alert({
          title: get_strings.congratulations,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-smile-o",
          theme: "modern",
          animation: "scale",
          type: "green",
          content: response.data.message,
        });
      } else {
        $.alert({
          title: get_strings.whoops,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-smile-o",
          theme: "modern",
          animation: "scale",
          type: "red",
          content: response.data.message,
        });
      }
    })
    return;
  })
  // =========== Zoom Refresh Access Token =====================

  // =========== Copy Meeting Link ===========
  $(".copy_meeting_url").click(function () {
    var meetingUrl = $(this).attr('data-meeting-url');
    var tempInput = $("<input>");
    $("body").append(tempInput);
    tempInput.val(meetingUrl).select();
    document.execCommand("copy");
    tempInput.remove();
    $.alert({
      title: get_strings.congratulations,
      closeIcon: true,
      rtl: yes_rtl,
      icon: "fa fa-smile-o",
      theme: "modern",
      animation: "scale",
      type: "green",
      content: 'Link Copied to Clipboard',
    });
  });
  // =========== Copy Meeting Link ===========

  // =================Create Meeting ==================
  $(document).on('submit', '.zoom-meeting-form', function (e) {
    e.preventDefault();
    var $button = $('#btn_update_meeting');
    $button.button("loading");
    var this_value = $(this);
    var meetID = $(this).find("input[name=current_meeting_id]").val();
    var freelancer_id = $(this).find("input[name=current_author]").val();
    var reservation_id = $(this).find("input[name=current_job]").val();

    this_value.find('span.bubbles').addClass('view');
    $(".zoom-metting-form-btn").attr("disabled", true);

    $.post(ajax_url, {
      reservation_id: reservation_id,
      meetID: meetID,
      form_data: $(this).serialize(),
      action: 'dwt_setup_zoom_meeting',
    }).done(function (response) {
      $button.button("reset");
      if (response.success) {
        $.alert({
          title: get_strings.congratulations,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-smile-o",
          theme: "modern",
          animation: "scale",
          type: "green",
          content: response.data.msg,
        });
        window.location.reload(true);
      } else {
        $.alert({
          title: get_strings.whoops,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-smile-o",
          theme: "modern",
          animation: "scale",
          type: "red",
          content: response.data.msg,
        });
      }
    });
  });
  // =================Create Meeting ==================

  // =================Delete Meeting ==================
  $(".delete_zoom_meeting").on("click", function (e) {
    var $button = $(this);
    $button.button("loading");
    e.preventDefault();
    var reservation_id = $(this).attr('data-res-id');
    var meeting_id = $(this).attr('data-meetid');

    $.post(ajax_url, {
      reservation_id: reservation_id,
      meeting_id: meeting_id,
      form_data: $(this).serialize(),

      action: 'dwt_zoom_delete_meet',
    }).done(function (response) {
      $button.button("reset");
      if (response.success) {
        $.alert({
          title: get_strings.congratulations,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-smile-o",
          theme: "modern",
          animation: "scale",
          type: "green",
          content: response.data.msg,
        });
        window.location.reload(true);
      } else {
        $.alert({
          title: get_strings.whoops,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-smile-o",
          theme: "modern",
          animation: "scale",
          type: "red",
          content: response.data.msg,
        });
      }
    });
  });
  // =================Delete Meeting ==================

  /* Delete My Events */
  $(".delete-my-events").on("click", function () {
    var event_id = $(this).attr("data-myevent-id");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.content,
      closeAnimation: "scale",
      type: "red",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "remove_my_events",
              event_id: event_id,
            }).done(function (response) {
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $.alert({
                  title: get_strings.congratulations,
                  backgroundDismiss: true,
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
        },
      },
    });
    return false;
  });
  /* Delete My Events */
  $(".delete-my-speaker").on("click", function () {
    var speaker_id = $(this).attr("data-speaker-id");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.content,
      closeAnimation: "scale",
      type: "red",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "remove_speaker_by_id",
              speaker_id: speaker_id,
            }).done(function (response) {
              var get_r = response.split("|");
              if ($.trim(get_r[0]) == "1") {
                $.alert({
                  title: get_strings.congratulations,
                  backgroundDismiss: true,
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
        },
      },
    });
    return false;
  });

  // $("#make_payment_button").on("click", function () {
  //   alert("proceeding");
  //   var listing_id = $(this).attr("data-listing-id");
  //   const price = document.getElementById("price_of_table").value;
  //   const apoint_id = document.getElementById("Appointment_id").value;
  //  console.log(price);
  //  console.log(apoint_id);
  //   $.post(ajax_url, {
  //     action: "book_listing_paid",
  //     listing_id: listing_id,
  //     price: price,
  //     apoint_id: apoint_id,
  //   }).done(function (response) {
  //     var res_arr = response.toString().split("|");

  //     if ($.trim(res_arr[0]) == "1") {
  //       $.alert({
  //         title: get_strings.congratulations,
  //         closeIcon: true,
  //         rtl: yes_rtl,
  //         icon: "fa fa-smile-o",
  //         theme: "modern",
  //         animation: "scale",
  //         type: "green",
  //         content: get_strings.redirecting_success,
  //         backgroundDismiss: true,
  //         buttons: { okay: { btnClass: "btn-blue" } },
  //       });

  //       location.replace(res_arr[2]);
  //     } else {
  //       $.alert({
  //         title: get_strings.whoops,
  //         closeIcon: true,
  //         rtl: yes_rtl,
  //         icon: "fa fa-frown-o",
  //         theme: "modern",
  //         animation: "scale",
  //         type: "red",
  //         content: res_arr[1],
  //         backgroundDismiss: true,
  //       });
  //     }
  //   });
  // });

  $("#make_payment_button").on("click", function () {
    alert("proceeding");
    var listing_id = $(this).attr("data-listing-id");
    const price = document.getElementById("price_of_table").value;
    const apoint_id = document.getElementById("Appointment_id").value;

    // Calculate 10% of the payment amount
    // const walletAmount = parseFloat(price) * 0.1;
    // const authorAmount = parseFloat(price) - walletAmount;
    // console.log(walletAmount);
    // console.log(authorAmount);
    // Make the AJAX call to process the payment
    $.post(ajax_url, {
      action: "book_listing_paid",
      listing_id: listing_id,
      price: price,
      apoint_id: apoint_id,
      // walletAmount: walletAmount,
      // authorAmount: authorAmount
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

        // Update wallet amount display
        var currentWalletAmount = parseFloat($(".amount_in_wallet h3").text().replace(currency_symbol, ""));
        var newWalletAmount = currentWalletAmount + walletAmount;
        $(".amount_in_wallet h3").text(currency_symbol + newWalletAmount);
      } else {
        $.alert({
          title: get_strings.whoops,
          closeIcon: true,
          rtl: yes_rtl,
          icon: "fa fa-frown-o",
          theme: "modern",
          animation: "scale",
          type: "red",
          content: res_arr[1],
          backgroundDismiss: true,
        });
      }
    });
  });

  /* Expire My Listing */
  $(".expire-my-events").on("click", function () {
    var event_id = $(this).attr("data-myevent-id");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.event_expiry,
      closeAnimation: "scale",
      type: "red",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "expire_my_events",
              event_id: event_id,
            }).done(function (response) {
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
        },
      },
    });
    return false;
  });

  /* Expire My Listing */
  $(".reactive-my-events").on("click", function () {
    var event_id = $(this).attr("data-myevent-id");
    $.confirm({
      title: get_strings.confirmation,
      icon: "fa fa-question-circle",
      theme: "supervan",
      animation: "scale",
      content: get_strings.event_reactive,
      closeAnimation: "scale",
      type: "red",
      buttons: {
        confirm: {
          text: get_strings.ok,
          action: function () {
            $.post(ajax_url, {
              action: "reactive_my_events",
              event_id: event_id,
            }).done(function (response) {
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
        },
      },
    });
    return false;
  });

  $("#food_menu")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "my_new_menu",
          collect_data: $("form#food_menu").serialize(),
        }).done(function (response) {
          $(".sonu-button").button("reset");
        });
      }
      return false;
    });

  //======================== On Change Event Type ========================//
  $('#event_type').on('change', function () {
    var locationInput = $('#address_location');
    var latInput = $('#d_latt');
    var longInput = $('#d_long');
    var webinarLinkRadio = $('#webinar_link_radio_wrapper');
    var asteriskSpan = $('#location_asterisk');
    var latCont = $('.latitude_input_container')
    var longCont = $('.longitude_input_container')
    var locCont = $('.location_input_container')
    var mapCont = $('.map_view_container')

    if ($(this).val() === 'webinar') {
      locationInput.prop('disabled', true);
      latInput.prop('disabled', true);
      longInput.prop('disabled', true);
      locationInput.removeAttr('required');
      webinarLinkRadio.show();
      asteriskSpan.hide();
      longCont.hide();
      latCont.hide();
      locCont.hide();
      mapCont.hide();
    } else {
      locationInput.prop('disabled', false);
      latInput.prop('disabled', false);
      longInput.prop('disabled', false);
      locationInput.attr('required', 'required');
      webinarLinkRadio.hide();
      $('#webinar_link_input_wrapper').hide();
      asteriskSpan.show();
      longCont.show();
      latCont.show();
      locCont.show();
      mapCont.show();
    }
  });

  $('input[name="share_webinar_link"]').on('change', function () {
    if ($(this).val() === 'yes') {
      $('#webinar_link_input_wrapper').show();
      $('#webinar_link_input').attr('required', 'required');
    } else {
      $('#webinar_link_input_wrapper').hide();
      $('#webinar_link_input').removeAttr('required');
    }
  });
  //======================== On Change Event Type ========================//

  //======================== Copy Webinar Link ========================//
  $("#copy_webinar_link").click(function () {
    var meetingUrl = $(this).attr('data-webinar-link');
    var tempInput = $("<input>");
    $("body").append(tempInput);
    tempInput.val(meetingUrl).select();
    document.execCommand("copy");
    tempInput.remove();
    $.alert({
      title: get_strings.congratulations,
      closeIcon: true,
      rtl: yes_rtl,
      icon: "fa fa-smile-o",
      theme: "modern",
      animation: "scale",
      type: "green",
      content: 'Link Copied to Clipboard',
    });
  });
  //======================== Copy Webinar Link ========================//

  // On page reload check if the event type is webinar and the radio is checked to show or hide the input fot webinar meeting link//
  $(document).ready(function () {
    var eventType = $('#event_type').val();
    var shareWebinarLink = $('input[name="share_webinar_link"]:checked').val();

    function showHideWebinarLinkInput() {
      if (shareWebinarLink === 'yes') {
        $('#webinar_link_input_wrapper').show();
        $('#webinar_link_input').attr('required', 'required');
      } else {
        $('#webinar_link_input_wrapper').hide();
        $('#webinar_link_input').removeAttr('required');
      }
    }

    function handleEventTypeChange() {
      var locationInput = $('#address_location');
      var latInput = $('#d_latt');
      var longInput = $('#d_long');
      var webinarLinkRadio = $('#webinar_link_radio_wrapper');
      var asteriskSpan = $('#location_asterisk');
      var longCont = $('.longitude_input_container');
      var latCont = $('.latitude_input_container')
      var locCont = $('.location_input_container')
      var mapCont = $('.map_view_container')

      if (eventType === 'webinar') {
        locationInput.prop('disabled', true);
        latInput.prop('disabled', true);
        longInput.prop('disabled', true);
        locationInput.removeAttr('required');
        webinarLinkRadio.show();
        showHideWebinarLinkInput();
        asteriskSpan.hide();
        longCont.hide();
        latCont.hide();
        locCont.hide();
        mapCont.hide();
      } else {
        locationInput.prop('disabled', false);
        latInput.prop('disabled', false);
        longInput.prop('disabled', false);
        locationInput.attr('required', 'required');
        webinarLinkRadio.hide();
        $('#webinar_link_input_wrapper').hide();
        asteriskSpan.show();
        longCont.show();
        latCont.show();
        locCont.show();
        mapCont.show();
      }
    }

    if (eventType === 'webinar') {
      handleEventTypeChange();
    }

    $('#event_type').on('change', function () {
      eventType = $(this).val();
      handleEventTypeChange();
    });

    $('input[name="share_webinar_link"]').on('change', function () {
      shareWebinarLink = $(this).val();
      showHideWebinarLinkInput();
    });
  });
 // On page reload check if the event type is webinar and the radio is checked to show or hide the input fot webinar meeting link//

  $("#dwt_create_menu")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        $(".sonu-button").button("loading");
        var listing_id = $("#menu_parent_listingz").val();
        $.post(ajax_url, {
          action: "dwt_create_menutype",
          collect_data: $("form#dwt_create_menu").serialize(),
          listing_id: listing_id,
        }).done(function (response) {
          $("#dwt_create_menu")[0].reset();
          $(".sonu-button").button("reset");
          $(".menu_modalz").modal("hide");
          $("#append_result").html(response);
        });
        return false;
      }
    });

  /*--- edit menu ---*/
  $(document).on("click", ".edit-lmenu", function () {
    var listing_id = $(this).attr("data-id");
    var key = $(this).attr("data-key");
    $(".edit-button-" + key).button("loading");
    var trid = $(this).closest("tr").attr("id");
    $.post(ajax_url, {
      action: "dwt_edit_menutype",
      listing_id: listing_id,
      key: key,
      trid: trid,
    }).done(function (response) {
      $(".edit-button-" + key).button("reset");
      $(".edit_modal_menu").html(response);
      $(".menu_modalz1").modal("show");
      $("#dwt_update_menu").validator();
    });
    return false;
  });

  $(document).on("submit", "#dwt_update_menu", function (e) {
    if (e.isDefaultPrevented()) {
      return false;
    } else {
      $(".sonu-button").button("loading");
      $.post(ajax_url, {
        action: "dwt_update_menutype",
        collect_data: $("form#dwt_update_menu").serialize(),
      }).done(function (response) {
        $(".sonu-button").button("reset");
        $(".menu_modalz1").modal("hide");
        var res = response.split("|");
        $("#" + res[1] + " span.menu_name").html(res[0]);
      });
      return false;
    }
  });

  /*--- Add new items in menu ---*/
  $(document).on("click", ".menu_items_addition", function () {
    $(".menu_modalz_itemz").modal("show");
    var k_ref = $(this).attr("data-key-ref");
    var k_list = $(this).attr("data-key-id");
    $("input#reference_key").val(k_ref);
    $("input#reference_listing").val(k_list);
    return false;
  });

  /*--- Inserting menu items ---*/
  $("#ad_menu_listz")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "dwt_ad_new_menu_listz",
          collect_data: $("form#ad_menu_listz").serialize(),
        }).done(function (response) {
          $("#ad_menu_listz")[0].reset();
          $(".sonu-button").button("reset");
          $(".menu_modalz_itemz").modal("hide");
          $(".show_inner_menuz").html(response);
          $(".menu_item_historyz").modal("show");
        });
        return false;
      }
    });

  /*--- edit inner menu type ---*/
  $(document).on("click", ".inner-menu-edit", function () {
    var listing_id = $(this).attr("data-listing_id");
    var key = $(this).attr("data-refer_key");
    $(".lmenu-edit-" + key).button("loading");
    var trid = $(this).closest("tr").attr("id");
    $.post(ajax_url, {
      action: "dwt_edit_inner_menugroup",
      listing_id: listing_id,
      key: key,
      trid: trid,
    }).done(function (response) {
      $(".lmenu-edit-" + key).button("reset");
      $(".show_updated_modal").html(response);
      $(".fetch_inner_form").modal("show");
      $("#update_inner_itemz_menu").validator();
    });
    return false;
  });

  /*--- update menu ---*/
  $(document).on("submit", "#update_inner_itemz_menu", function (e) {
    if (e.isDefaultPrevented()) {
      return false;
    } else {
      $(".sonu-button").button("loading");
      $.post(ajax_url, {
        action: "dwt_update_current_menu",
        collect_data: $("form#update_inner_itemz_menu").serialize(),
      }).done(function (response) {
        $(".sonu-button").button("reset");
        $(".fetch_inner_form").modal("hide");
        var res = response.split("|");
        $("#" + res[1] + " span.menu_name").html(res[0]);
        $("#" + res[1] + " span.menu_price").html(res[2]);
      });
      return false;
    }
  });

  /*--- View All menu Items ---*/
  $(document).on("click", ".l_view_collection", function () {
    var listing_id = $(this).attr("data-id");
    var key = $(this).attr("data-key");
    $(".view-button-" + key).button("loading");
    $.post(ajax_url, {
      action: "dwt_fetch_inner_menugroupz",
      listing_id: listing_id,
      key: key,
    }).done(function (response) {
      $(".view-button-" + key).button("reset");
      $(".show_inner_menuz").html(response);
      $(".menu_item_historyz").modal("show");
    });
    return false;
  });

  $("#menu_parent_listingz").on("change", function () {
    $(".menu-btn").show();
  });

  var m_id = $("#conditional_id").val();
  if (typeof m_id != "undefined") {
    $(".sk-circle").show();
    //$("#menu_parent_listingz").trigger("change");
    $(".menu-btn").show();
    $.post(ajax_url, {
      action: "dwt_fetchmenu_against_listing",
      listing_id: m_id,
    }).done(function (response) {
      $(".sk-circle").hide();
      $("#append_result").html(response);
    });
    return false;
  }

  /*--- Update profile settings ---*/
  $("#profile-settings")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "save_profile_settings",
          collect_data: $("form#profile-settings").serialize(),
        }).done(function (response) {
          $(".sonu-button").button("reset");
          if ($.trim(response) != "") {
            $.alert({
              title: get_strings.congratulations,
              rtl: yes_rtl,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: response,
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
              backgroundDismiss: true,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: response,
              buttons: { okay: { btnClass: "btn-blue" } },
            });
          }
        });
      }
      return false;
    });


  //ajax for calendar form

  $("#reservation_information")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        Appointment_id;
        var is_update = $("#is_update").val();
        var curent_lang = $("#lang").val();
        var type_of_ads = $("#type_of_ads").val();
        var price = $("#table_price").val();
        var Appointment_id = $("#Appointment_id").val();
        var meetingType;

        // Check if the select element is visible, if yes, get its value
        if ($("#appointment_reservationType").is(":visible")) {
          meetingType = $("#appointment_reservationType").val();
        } else {
          // Otherwise, get the value from the hidden input
          meetingType = $("#listing_app_meeting_type").val();
        }

        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "my_new_reservation",
          lang: curent_lang,
          type_of_ads: type_of_ads,
          price: price,
          collect_data: $("form#reservation_information").serialize(),
          is_update: $("#is_update").val(),
          meeting_type: meetingType
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

            console.log(res_arr[2]);
            location.replace(res_arr[2]);
            // location.reload();
          } else {
            $.alert({
              title: get_strings.whoops,
              closeIcon: true,
              rtl: yes_rtl,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: response.data.message,
              backgroundDismiss: true,
            });
          }
        });


        /*--- stop submitting ---*/
        return false;
      }
    });


  //enable reservation on listings
  $(".create_menu_types").click(function () {
    $(".datepicker-here-custom .air-datepicker").remove();
  });

  $("#reservations").on("submit", function (e) {
    if (e.isDefaultPrevented()) {
      return false;
    } else {
      $(".sonu-button").button("loading");
      var booked_days = $("#disabled_dates").datepicker().val();
      var ads_type = $("#subscription").val();
      var price_of_table = $("#table_price").val();
      var listing_id = $("#menu_parent_listingz").val();
      var table_slot_duration = $("#table_slot_duration").val();
      var selectedValue = $("#reservationType").val();

      $.post(ajax_url, {
        action: "my_reservations",
        collect_data: $("form#reservations").serialize(),
        restricted_days: booked_days,
        table_price: price_of_table,
        listing_id: listing_id,
        ads_type: ads_type,
        table_slot_duration: table_slot_duration,
        res_type: selectedValue,
      }).done(function (response) {
        var res_arr = response.toString().split("|");

        if ($.trim(res_arr[0]) == "1") {
          $.alert({
            rtl: yes_rtl,
            icon: "fa fa-smile-o",
            theme: "modern",
            animation: "scale",
            type: "green",
            title: get_strings.reservation_created,
            content: res_arr[1],
            backgroundDismiss: true,
            backgroundDismiss: true,
          });

          location.reload();
        } else {
          $.alert({
            rtl: yes_rtl,
            icon: "fa fa-frown-o",
            theme: "modern",
            animation: "scale",
            type: "red",
            title: get_strings.no_business_hrs,
            backgroundDismiss: true,
            content: res_arr[1],
            backgroundDismiss: true,
          });
        }
      });
    }
    return false;
  });

  //for listing appointment meeting type
  $("#appointment_reservationType").on("change", function () {
    var selectedType = $(this).val();
    var selectedID = $("#listing_id").val();
    {

      $.ajax({
        type: 'POST',
        url: ajax_url,
        data: {
          action: 'store_meeting_type',
          meetingType: selectedType,
          postID: selectedID
        },
        success: function (response) {
          console.log('Meeting type stored successfully.');
          console.log('Response from the server: ', response);
        },
        error: function (xhr, status, error) {
          console.error('Error storing meeting type:', error);
        }
      });
      //   $('#meeting_link_box').hide();
    }
  });





  //   var selectedValue = $(this).val();
  // var selectedID = $("#listing_id").val();
  // console.log(selectedID);
  //   $.ajax({
  //       type: 'POST',
  //       url: ajax_url,
  //       data: {
  //           action: 'store_meeting_type',
  //           meetingType: selectedValue,
  //           postID: selectedID
  //       },
  //       success: function(response) {
  //           // Handle the response here
  //           console.log('Meeting type stored successfully.');
  //           console.log('Response from server:', response);


  //       },
  //       error: function(xhr, status, error) {
  //           console.error('Error storing meeting type:', error);
  //       }
  //   });
  // });


  //js for virtual meeting popup
  // document.getElementById('reservationType').addEventListener('change', function() {
  //   var selectedOption = this.value;


  // $(document).ready(function() {
  //   $('#reservationType').change(function() {
  //       var selectedValue = $(this).val();
  //       var selectedID = $('#listing_id').val();

  //       // if (selectedValue === 'virtual_meeting') {
  //       //     var meetingLink = prompt('Please enter the link for the virtual meeting:');
  //       //     if (meetingLink !== null) {
  //       //         saveMeetingLink(meetingLink, selectedValue, selectedID);
  //       //     }
  //       // }
  //   });
  // });

  // function saveMeetingLink(link, selectedValue, selectedID) {
  //   $.ajax({
  //       type: 'POST',
  //       url: ajax_url, 
  //       data: {
  //           action: 'store_meeting_type',
  //           meetingType: selectedValue,
  //           meetingLink: link,
  //           postID: selectedID
  //       },
  //       success: function(response) {
  //           // Handle the response here
  //           console.log('Meeting type stored successfully.');
  //           console.log('Response from server:', response);
  //       },
  //       error: function(xhr, status, error) {
  //           console.error('Error storing meeting type:', error);
  //       }
  //   });
  // }






  //for post status

  $(".booking_status").on("change", function () {
    var booking_status = $(this).val();
    var booking_id = $(this).attr("data-id");
    var booking_type = $(this).attr("data-type");
    var meeting = $(this).attr("data-meeting");

    console.log("MEETING", meeting);
    var link_field = $(".form-meeting")
    if (booking_status === "rejected" || meeting === 'physical_meeting') {
      link_field.css("display", "none");
      $("#link-text").prop("required", false);
    } else if (meeting === 'virtual_meeting') {
      link_field.css("display", "block");
      $("#link-text").prop("required", true);
    }

    // var link_text = $(this).val();
    $("#current_booking_id").val(booking_id);
    $("#current_booking_status").val(booking_status);
    //  $("#link-text").val(link_text);
    if (booking_type === '' || booking_type === "paid") {
      $("#exampleModal").modal({
        show: true,
      });
    }
  });

  $(".form_booking_email").on("submit", function (e) {
    e.preventDefault();
    var booking_id = $("#current_booking_id").val();
    var booking_status = $("#current_booking_status").val();
    var listing_id = $('#listing_id').val();
    var message_text = $("#message-text").val();
    var link_text = $("#link-text").val();
    console.log(message_text);
    console.log(link_text);
    $.post(ajax_url, {
      action: "booked_listing_status",
      staus: booking_status,
      booking_id: booking_id,
      listing_id: listing_id,
      message_text: message_text,
      link_text: link_text,
      // collect_data: $("form#event_attendies").serialize(),

    }).done(function (response) {
      console.log(response.success);
      if (response.success == true) {
        $.alert({
          title: get_strings.congratulations,
          backgroundDismiss: true,
          rtl: yes_rtl,
          icon: "fa fa-smile-o",
          theme: "modern",
          animation: "scale",
          type: "green",
          content: response.data.message,
          buttons: { okay: { btnClass: "btn-blue" } },
        });
        window.setTimeout(function () {
          location.reload();
        }, 2000);
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
      // $('.sonu-button').button('reset');
      // return false;
    });
  });

  //for tickets status

  $(".ticket_status").on("change", function () {
    var tickets_status = $(this).val();
    var tickets_id = $(this).attr("data-event-id");
    $("#current_tickets_id").val(tickets_id);
    $("#current_tickets_status").val(tickets_status);
    $("#exampleModals").modal({
      show: true,
    });
  });

  $(".form_ticket_booking_email").on("submit", function (e) {
    e.preventDefault();
    var tickets_id = $("#current_tickets_id").val();
    var tickets_status = $("#current_tickets_status").val();
    var messages_text = $("#messages-text").val();
    $.post(ajax_url, {
      action: "booked_tickets_status",
      staus: tickets_status,
      tickets_id: tickets_id,
      message_text: messages_text,
    }).done(function (response) {
      $(".sonu-button").button("reset");
      return false;
    });
  });

  //adding event attendees
  $("#attending_event").on("click", function () {
    var event_id = $("#attending_event").attr("event-data-id");
    $.post(ajax_url, {
      action: "event_attendees_status",
      event_id: event_id,
    }).done(function (response) {
      location.reload();
    });
  });

  //deleting meta of not attending event

  $("#cancel_attendance").on("click", function () {
    var event_id = $("#cancel_attendance").attr("event-data-delete-id");

    $.post(ajax_url, {
      action: "dwt_delete_event_attendance",
      event_id: event_id,
    }).done(function (response) {
      location.reload();
    });
  });

  //ajax for Payouts

  $("#payout_form")
    .validator()
    .on("submit", function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      } else {
        var is_update = $("#is_update").val();
        var curent_lang = $("#lang").val();
        $(".sonu-button").button("loading");
        $.post(ajax_url, {
          action: "my_event_payouts",
          lang: curent_lang,
          collect_data: $("form#payout_form").serialize(),
          is_update: $("#is_update").val(),
        }).done(function (response) {
          $(".sonu-button").button("reset");

          if (response.success == true) {
            $.alert({
              title: get_strings.payout_sent,
              rtl: yes_rtl,
              icon: "fa fa-smile-o",
              theme: "modern",
              animation: "scale",
              type: "green",
              content: profile_strings,
              buttons: {
                Close: function () {
                  location.reload();
                },
              },
            });
          } else {
            $.alert({
              title: get_strings.amount_is_greater,
              rtl: yes_rtl,
              icon: "fa fa-frown-o",
              theme: "modern",
              animation: "scale",
              type: "red",
              content: profile_strings,
              buttons: {
                Close: function () { },
              },
            });
          }
        });
        /*--- stop submitting ---*/
        return false;
      }
    });

  $("#subscription").change(function () {
    var selectedOption = $(this).val();
    var priceField = $(".table_reservation_price");

    if (selectedOption === "paid") {
      priceField.show();
    } else {
      priceField.hide();
    }
    if (selectedOption === "free") {
      priceField.hide();
    }
  });
})(jQuery);