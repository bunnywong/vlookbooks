<?php
/**
 * Template name: Feeder
 *
 * @package parallax-one
 */

  get_header('global');
  get_header('feeder');
?>

<div class="content-wrap">
  <div class="container">

    <div id="primary" class="content-area col-md-12">
      <main id="main" class="site-main" role="main">
      <?php echo do_shortcode('[ajax_load_more post_type="post" posts_per_page="10" button_loading_label="loading ..." css_classes="my-container"]'); ?>

      </main><!-- #main -->
    </div><!-- #primary -->

  </div>
</div><!-- .content-wrap -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
<script>
  jQuery(document).ready(function() {
    vlookbooks.init();
    vlookbooks.feeder();
  });
</script>

<?php get_footer(); ?>
<?php get_footer('global'); ?>



