<?php
/**
 * Template name: Home
 *
 * @package parallax-one
 */

  get_header('home');
?>

<div class="content-wrap">
	<div class="container">

		<div id="primary" class="content-area col-md-12">
			<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div>
</div><!-- .content-wrap -->

<div class="slider-container">
  <h3 class="text-center">Start Exploring</h3>
  <?php kw_sc_logo_carousel('home'); ?>
</div>

<!-- jQuery library (served from Google) -->
<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 -->
<!-- bxSlider Javascript file -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="//cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.css" rel="stylesheet" />
<script>
  jQuery(document).ready(function() {
    vlookbooks.global();
    vlookbooks.home();
  });
</script>
<?php get_footer(); ?>

<div class="modal fade modal-login" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center">
      <div><?php echo do_shortcode('[login_widget title="Log in"]'); ?></div>
    </div>
  </div>
</div>

<div class="modal fade modal-forget-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center">
      <div><?php echo do_shortcode('[forgot_password title="Forgot Password?"]'); ?></div>
    </div>
  </div>
</div>

<div class="modal fade modal-signup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center">
      <h2>Sign up</h2>
      <div class="form-wrapper">
        <div><?php echo do_shortcode('[user-meta-registration form="signup"]'); ?></div>
      </div>
      <div class="footer">
        <div>Already signed up? <a href="login" class="js-login-redirect" data-toggle="modal" data-target=".modal-login">Log in</a></div>
        <div><a href="login" class="js-login-redirect" data-toggle="modal" data-target=".modal-forget-password">Forgot your password?</a></div>
      </div>

    </div>
  </div>
</div>
