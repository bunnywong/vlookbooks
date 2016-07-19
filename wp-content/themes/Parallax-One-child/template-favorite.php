<?php
/**
 * Template name: Favorite brand
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

        <div class="container">
          <div class="row main-row">
            <div class="col-md-5">
              <div class="img-left_wrapper img-wrapper">
                <img class="alignnone size-full wp-image-411" src="/wp-content/uploads/2016/07/c1.png" alt="c1" />
                <div class="hidden abs hover-bg">
                  <img src="/wp-content/uploads/2016/01/logo-ermenegildo-zegna.png">
                  <div>NEW STYLE</div>
                  <div>COME VISIT</div>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <div class="inline-block">
                <span class="img-wrapper left">
                  <img class="alignnone size-full wp-image-412" src="/wp-content/uploads/2016/07/c21.png"/>
                  <div class="hidden abs hover-bg">
                    <img src="/wp-content/uploads/2016/01/logo-zara.jpg">
                    <div>Welcome</div>
                    <div>Fall 2015</div>
                  </div>
                </span>

                <span class="img-wrapper">
                  <img class="alignnone size-full wp-image-414" src="/wp-content/uploads/2016/07/c23.png"/>
                </span>

                <span class="img-wrapper">
                  <img class="alignnone size-full wp-image-413" src="/wp-content/uploads/2016/07/c22.png"/>
                </span>
              </div>
              <img class="alignnone size-full wp-image-415 img_middle-bottom" src="/wp-content/uploads/2016/07/c3.png"/>

            </div>
            <div class="col-md-2">
              <div class="logo-wrapper">

                <div class="row col1">
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/01/logo-hm.jpg">
                  </div>
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/02/logo-uniqlo-gif.gif">
                  </div>
                </div>

                <div class="row col2">
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/01/logo-zara.jpg">
                  </div>
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/01/logo-nike.png">
                  </div>
                </div>

                <div class="row col3">
                  <div class="col-sm-12">
                    <img src="/wp-content/uploads/2016/01/logo-ermenegildo-zegna.png">
                  </div>
                </div>

                <div class="row col4">
                  <div class="col-sm-12">
                    <img src="/wp-content/uploads/2016/02/logo-bottega-veneta.png">
                  </div>
                </div>

                <div class="row col5">
                  <div class="col-sm-12">
                    <img src="/wp-content/uploads/2016/02/logo-emporio.png">
                  </div>
                </div>

                <div class="row col6">
                  <div class="col-sm-12">
                    <img src="/wp-content/uploads/2016/02/logo-giorgio.png">
                  </div>
                </div>

                <div class="row col7">
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/02/logo-h.png">
                  </div>
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/02/logo-new-balance.png">
                  </div>
                </div>

                <div class="row col8">
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/02/logo-addidas.png">
                  </div>
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/02/logo-lululemon.png">
                  </div>
                </div>

                <div class="row col9">
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/02/logo-lv.png">
                  </div>
                  <div class="col-sm-6">
                    <img src="/wp-content/uploads/2016/02/logo-dior.png">
                  </div>
                </div>

                <div class="row col10">
                  <div class="col-sm-12 ">
                    <div class="js-logo-plus logo-plus" data-toggle="modal" data-target=".modal-favorite-brand">
                      <img src="/wp-content/uploads/2016/02/logo-plus.png">
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

      </main><!-- #main -->
    </div><!-- #primary -->

  </div>
</div><!-- .content-wrap -->

<script>
  jQuery(document).ready(function() {
    vlookbooks.init();
    vlookbooks.favoriteBrand();
  });
</script>

<?php get_footer(); ?>
<?php get_footer('global'); ?>

<div class="modal fade modal-favorite-brand" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content text-center">
      <div class="row">
        <h2>Edit Favorite</h2>
        <div class="col-sm-4 left">
          <input value="Search">
          <button>Add to Favorite</button>
        </div>
        <div class="col-sm-8">table</div>
      </div>

    </div>
  </div>
</div>




