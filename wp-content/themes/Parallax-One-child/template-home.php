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
  <h1 class="title">VLOOKBOOKS.COM</h1>
  <div class="signin">
    <a href="">Sign in</a>
  </div>
</div>
<div class="side-menu js-side-menu hidden">
  <div class="menu">
    <a href="">About</a>
  </div>
  <div class="menu">
    <a href="">Contact</a>
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
      <div class="bx-wrapper-container">
        <?php
          $html = '';
          $html .= '<div class="sliders">';

          for ($i= 0; $i < 6; $i++) {
            $image = get_field('home_image_' . $i);
            if (!empty($image)) {
              // vars
              $url = $image['url'];
              $title = $image['title'];
              $alt = $image['alt'];
              $caption = $image['caption'];
              $size = 'medium'; // e.g. thumbnail
              $thumb = $image['sizes'][ $size ];
              $width = $image['sizes'][ $size . '-width' ];
              $height = $image['sizes'][ $size . '-height' ];

              // if ($caption) {
              //   $html .= '<div class="wp-caption">';
              // }

              $html .= '<div class="slide">';
              // $html .=   '<a href="' . $url . '" title="' . $title . '">';
              $html .=     '<img src="' . $thumb . '" alt="' . $alt . '" width="' . $width .'" height="' .  $height . '" />';
              // $html .=   '</a>';
              $html .= '</div>';

              // if ($caption) {
              //   $html .= '<p class="wp-caption-text">' . $caption . '</p>';
              //   $html .= '</div>';
              // }
            }
          }

          $html .= '<div/>';
          // echo $html; // ***
        ?>
      </div>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div>
</div><!-- .content-wrap -->


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

  // $(document).ready(function(){
  //   $('.sliders').bxSlider({
  //     slideWidth: 200,
  //     minSlides: 2,
  //     maxSlides: 5,
  //     moveSlides: 5,
  //     slideMargin: 10,
  //     pager: false,
  //   });
  // });
</script>
<?php get_footer(); ?>
