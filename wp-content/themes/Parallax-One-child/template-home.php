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
  <div class="signin">
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Sign in</a>
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
    vlookbooks.home();
  });
</script>
<?php get_footer(); ?>
<!-- Large modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content text-center">
      <div>Sign up</div>
      <div>Email</div>
      <div>Already signed up? <a href="login">Log in</a></div>
      <div>Forgot your password? Reset password</div>
    </div>
  </div>
</div>
