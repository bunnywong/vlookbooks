$ = jQuery;

var vlookbooks = {
  init: function() {
    this.nav();
  },
  home: function() {

  },
  iso: function() {
    $('.alm-reveal')
      .isotope('destroy')
      .isotope({
        itemSelector: '.grid-item',
        masonry: {
          columnWidth: 300
        }
      });
    console.log('done: isotope');
    // Callback ref: https://connekthq.com/plugins/ajax-load-more/docs/callback-functions/
  },
  feeder: function() {
    // Ajax load more callback:
    $.fn.almComplete = function(alm){
      var lastPosition = $('body').scrollTop();

      // Restructure new loaded content
      if ($('.alm-reveal').eq(1).length) {
        // Append to initial wrapper
        $('.alm-reveal').eq(1).appendTo($('.alm-reveal').eq(0));
        // Remove wrapper
        $('.alm-reveal').eq(1).children().unwrap();
      }

      // init after items loaded.
      vlookbooks.iso();

      // Roll back last position
      $('body').scrollTop(lastPosition);

      // Ajax Comment
      // saic-link saic-icon-link saic-icon-link-true auto-load-true
      $('.saic-link').on('click', function() {
          // vlookbooks.iso();
          // console.log($(this).closest('.saic-wrap-comments').length);
        // setTimeout(vlookbooks.iso(), 1000);
      });
    };



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
    $('#login input[name="user_username"]').attr('type', 'email');
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
