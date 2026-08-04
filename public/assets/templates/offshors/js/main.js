$(document).ready(function () {
  var popupStatus = 0;

  function loadPopup(element) {
    //loads popup only if it is disabled
    if (popupStatus == 0) {
      $(".backgroundPopup").css({
        opacity: "0.8",
      });
      $(".backgroundPopup").fadeIn("slow");
      $(element).fadeIn("slow");
      popupStatus = 1;
    }

    var windowWidth = document.documentElement.clientWidth;
    var windowHeight = document.documentElement.clientHeight;
    var popupHeight = $(element).height();
    var popupWidth = $(element).innerWidth();
    //centering
    $(element).css({
      position: "fixed",
      top: windowHeight / 2 - popupHeight / 2,
      left: windowWidth / 2 - popupWidth / 2,
    });
    //only need force for IE6

    $(".backgroundPopup").css({
      height: document.offsetHeight,
    });

    $(".backgroundPopup").css({
      width: windowWidth - 2,
    });
  }

  function disablePopup() {
    //disables popup only if it is enabled
    if (popupStatus == 1) {
      $(".backgroundPopup").fadeOut("slow");
      $(".pop-up").fadeOut("slow");
      popupStatus = 0;
    }
  }

  $(".backgroundPopup").click(function () {
    disablePopup();
  });

  $(".pop-up__close").click(function () {
    disablePopup();
    return false;
  });

  $("#feedback1,#feedback2,#feedback2b,#feedback3,#feedback3b,#feedback,#feedback-cases,.zakaz").click(function () {
    loadPopup("#popupContact1");
    return false;
  });

  $(".call-back").click(function () {
    loadPopup("#popupContact2");
    return false;
  });

  $("#pop-up-three").click(function () {
    loadPopup("#popupContact3");
    return false;
  });

  $(".ajax-form").submit(function () {
    var str = $(this).serialize();
    var form = $(this);
    var action = form.attr('action');

    if (!action) {
      form.find(".error").html("Form action not configured");
      return false;
    }

    $.ajax({
      url: action,
      type: "post",
      data: str,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (msg) {
        // Response is JSON { status:"OK", lead:{…} }; legacy bare "OK" string still accepted.
        var ok = (msg === "OK") || (msg && msg.status === "OK");
        if (ok) {
          form.html(
            '<div class="ok-message">Teie päring saadetud. Võtame Teiega ühendust esimesel võimalusel.</div>'
          );
          form.css("background-image", "none");
          // GTM / GA4 generate_lead — fire exactly once on confirmed success.
          // NOT gated on the lead payload, so a missing/legacy response body still tracks.
          var lead = msg && msg.lead;
          if (window.dataLayer && !(lead && lead.is_test)) {
            window.dataLayer = window.dataLayer || [];
            var evt = { event: 'generate_lead', form_name: 'lead_form' };
            if (lead) {
              evt.event_id        = lead.event_id;
              evt.lead_public_id  = lead.lead_public_id;
              evt.form_type       = lead.form_type;
              evt.source_class    = lead.source_class;
              evt.campaign_name   = lead.campaign_name || undefined;
              evt.has_gclid       = !!lead.has_gclid;
              evt.submission_page = lead.submission_page;
            }
            window.dataLayer.push(evt);
          }
        } else {
          form.find(".error").html(typeof msg === "string" ? msg : "Viga saatmisel / Ошибка отправки");
        }
      },
      error: function(xhr) {
        if (xhr.status === 422) {
          var errors = xhr.responseJSON.errors;
          var errorHtml = '';
          for (var key in errors) {
            errorHtml += errors[key][0] + '<br>';
          }
          form.find(".error").html(errorHtml);
        } else {
          form.find(".error").html("Viga saatmisel / Ошибка отправки");
        }
      }
    });
    return false;
  });

  $(".nav__btn").on("click", function () {
    if ($(".nav__list").is(".open")) {
      $(".nav__list").removeClass("open").slideUp();
    } else {
      $(".nav__list").addClass("open").slideDown();
      $(".header__contacts").removeClass("open").slideUp();
      $(".header__phones").removeClass("open").slideUp();
      $(".sidebar-menu__title").removeClass("open");
      $(".sidebar-menu__list").slideUp();
    }
    return false;
  });

  $(".header__mobile-btn--adress").on("click", function () {
    if ($(".header__contacts").is(".open")) {
      $(".header__contacts").removeClass("open").slideUp();
    } else {
      $(".header__contacts").addClass("open").slideDown();
      $(".nav__list").removeClass("open").slideUp();
      $(".header__phones").removeClass("open").slideUp();
      $(".sidebar-menu__title").removeClass("open");
      $(".sidebar-menu__list").slideUp();
    }
    return false;
  });

  $(".header__mobile-btn--phones").on("click", function () {
    if ($(".header__phones").is(".open")) {
      $(".header__phones").removeClass("open").slideUp();
    } else {
      $(".header__phones").addClass("open").slideDown();
      $(".nav__list").removeClass("open").slideUp();
      $(".header__contacts").removeClass("open").slideUp();
      $(".sidebar-menu__title").removeClass("open");
      $(".sidebar-menu__list").slideUp();
    }
    return false;
  });

  $(".sidebar-menu__title").on("click", function () {
    if ($(this).is(".open")) {
      $(this)
        .removeClass("open")
        .parent()
        .find(".sidebar-menu__list")
        .slideUp();
    } else {
      $(".header__phones").removeClass("open").slideUp();
      $(".nav__list").removeClass("open").slideUp();
      $(".header__contacts").removeClass("open").slideUp();
      $(".sidebar-menu__title").removeClass("open");
      $(".sidebar-menu__list").slideUp();
      $(this).addClass("open").parent().find(".sidebar-menu__list").slideDown();
    }
    return false;
  });

  $("#price").change(function () {
    var v = Number($("#price option:selected").val()) + 1;
    console.log(v);
    $(".price td").css("display", "none");
    $(".price td:first-child").css("display", "table-cell");
    $(".price td:nth-child(" + v + ")").css("display", "table-cell");
  });

  $(document).ready(function () {
    $(".sidebar-menu__img").bxSlider({
      pager: false,
      controls: false,
      auto: true,
    });

    $(".banners__list").bxSlider({
      pager: false,
      auto: true,
      pause: 8000,
    });
  });
});

$(window).on('scroll', function () {
  if ($(this).scrollTop() > 1) {
    $("header").addClass("header--sticky");
  } else {
    $("header").removeClass("header--sticky");
  }
});
