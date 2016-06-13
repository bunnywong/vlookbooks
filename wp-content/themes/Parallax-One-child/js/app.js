$ = jQuery;

var vlookbooks = {
  init: function() {
    this.nav();
  },
  home: function() {

  },
  feeder: function() {

  },
  profile: function() {
    $('body').addClass('profile');

    // Alter plug-ing: Alter input attr
    $('.number')
      .attr('type','number')
      .attr('min','0');

    //  Alter Plug-ing: Remove `0` result for number type <input>
    $('form').submit(function() {
      $('form input[type="number"]').each(function() {
        if ($(this).val() == 0) {
          $(this).val('');
        }
      });
    });

    // Alter Plug-in: Avatar photo
    $('form.wpua-edit #submit').val('update');
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
  },
  wishlist: function() {
    $('.js-btn-body-io').on('click', function(e) {
      e.preventDefault();
        if ($('.wishlist-container').hasClass('show')) {
          $('.wishlist-container').removeClass('show');
        }
        else {
          $('.wishlist-container').addClass('show');
        }
    });
  },
}
