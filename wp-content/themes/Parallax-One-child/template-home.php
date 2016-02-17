<?php
/**
 * Template name: Home
 *
 * @package parallax-one
 */

  get_header('global');
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
<?php get_footer('global'); ?>


