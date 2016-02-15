$ = jQuery;

var vlookbooks = {
  init: function() {
    // this.home();
    // this.global();
  },
  home: function() {
    var $menu = $('.js-side-menu');
    $('.js-menu-io').on('click', function() {
      // Show menu
      if ($menu.hasClass('hidden')) {
        $menu.removeClass('hidden').slideDown('slow');

        // Adjust height in once
        if (typeof this.one == 'undefined') {
          var h = $('.js-side-menu').height();
          $menu.height(h-60);
          this.one = true;
        }
      }
      // Hide menu
      else {
        $menu.addClass('hidden').slideUp('slow');
      }
    });

    // Slider
    $('.bx-wrapper-container a').each(function() {
      var l = $(this).attr('href');
      if (l = 'http://www.wonderplugin.com/wordpress-carousel/') {
        $(this).hide();
      }
    });

    // Modal
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').focus()
    });
  },
  global: function() {
    // Rename Label
    $("#login label[for='username']").text('Email');

    $('.js-login-redirect').on('click', function() {
      $('.modal-signup').modal('hide');
    });

    // Login rewrite
    if ($('a[title="Logout"]').length) {
      $('.js-signup').remove();
      // Rename "Log in:
      $('.js-login')
        .text('Logout')
        .on('click', function() {
          window.location = $('a[title="Logout"]').attr('href');
        });

    }

  }
}
