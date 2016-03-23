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
      <?php echo do_shortcode('[ajax_load_more post_type="post" posts_per_page="5" button_loading_label="loading ..." css_classes="my-container"]'); ?>

      </main><!-- #main -->
    </div><!-- #primary -->

  </div>
</div><!-- .content-wrap -->



<?php get_footer(); ?>
<?php get_footer('global'); ?>
<script>
  jQuery(document).ready(function() {
    vlookbooks.init();
    vlookbooks.feeder();
  });
</script>


