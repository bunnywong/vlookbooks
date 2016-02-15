<?php
/**
 * Template name: Home
 *
 * @package parallax-one
 */

	get_header();
?>

	</div>
	<!-- /END COLOR OVER IMAGE -->
</header>
<div class="container-fluid custom-header">
  <div class="menu">
      <button type="button" class="navbar-toggle js-menu-io">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    <span><a href="#" class="js-menu-io">Menu</a></span>
  </div>
  <h1>VLOOKBOOKS.COM</h1>

  <div class="signup account js-signup">
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target=".modal-signup">Sign up</a>
  </div>
  <div class="login account">
    <a href="#" class="btn btn-primary js-login" data-toggle="modal" data-target=".modal-login">Log in</a>
  </div>

</div>
<div class="side-menu js-side-menu hidden">
  <div class="menu">
    <a href="/about">About</a>
  </div>
  <div class="menu">
    <a href="/contact">Contact</a>
  </div>
</div>
<!-- /END HOME / HEADER  -->

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
      <h3>Sign up</h3>
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
