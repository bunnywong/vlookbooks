$ = jQuery;

var vlookbooks = {
  init: function() {
    this.home();
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


  }
}
