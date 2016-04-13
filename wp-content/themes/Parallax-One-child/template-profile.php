<?php
/**
 * Template name: Profile
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

        <div class="col-md-4 block-left main block">
          <h2>User Information</h2>
          <?php echo do_shortcode('[user-meta-profile form="user body"]'); ?>
        </div>
        <div class="col-md-5 block-middle main block">
          <img src="http://v.vlookbooks.com/wp-content/uploads/2016/04/male-body.jpg" alt="male-body" />
        </div>
        <div class="col-md-3 block-right main block">
          <h2>Avatar Photo</h2>

          <h4>Facial Profile</h4>
          <?php //echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
          <?php echo do_shortcode('[avatar_upload]'); ?>

          <h4>Body Profile</h4>

          <img src="http://v.vlookbooks.com/wp-content/uploads/2016/04/male-body.jpg" alt="male-body" />

        </div>

        <div class="col-md-12 block-bottom">
          <h3>Latest Ideas for You - Start Exploring</h3>
          <div class="row text-center">
            <div class="col-md-2"><div class="idea">Idea 1</div></div>
            <div class="col-md-2"><div class="idea">Idea 1</div></div>
            <div class="col-md-2"><div class="idea">Idea 1</div></div>
            <div class="col-md-2"><div class="idea">Idea 1</div></div>
            <div class="col-md-2"><div class="idea">Idea 1</div></div>
            <div class="col-md-2"><div class="idea">Idea 1</div></div>
          </div>

        </div>
      </main><!-- #main -->
    </div><!-- #primary -->

  </div>
</div><!-- .content-wrap -->

<script>
  jQuery(document).ready(function() {
    vlookbooks.init();
    vlookbooks.profile();
  });
</script>

<?php get_footer(); ?>
<?php get_footer('global'); ?>



