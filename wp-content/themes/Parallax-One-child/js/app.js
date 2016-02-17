$ = jQuery;

var vlookbooks = {
  init: function() {
    this.nav();
  },
  home: function() {

  },
  feeder: function() {

  },
  nav: function() {
    this.sideMenu();
    this.modal();

    // Rename Label
    $("#login label[for='username']").text('Email');

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
  },
  modal: function() {
    // Modal: move focus
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').focus()
    });
  },
  sideMenu: function() {
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
  }
}
