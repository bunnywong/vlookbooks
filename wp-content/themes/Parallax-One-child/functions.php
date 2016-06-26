<?php
  /**
   * Child theme init
   */

   /**
   * Debug tool
   */
  function vd($var) {
    echo '<pre>';
    echo var_dump($var);
    echo '</pre>';
  }
  function dvm($var) {
    vd($var);
  }
  function vm($var) {
    vd($var);
  }

// ================================================================================
  /**
   * Woocommerce
   */

  /*
  * - Product detail: Change add to cart text
  */
  function woo_custom_cart_button_text() {
    return __( 'Add to shopping Bag', 'woocommerce' );
  }

  add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );

  /*
  * - Product detail movemnent: Description
  */

  // Custom template render
  function custom_woocommerce_output_product_data_description() {
    wc_get_template( 'single-product/tabs/description.php' );
  }

  /* 1. Remove # in old position */

  // #title
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
  // #description
  remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
  // #buttons
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
  // #default & custom fields
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

  // Button @TODO
  // remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
  // add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 40 );




  /* 2. Update % to new position */

  add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );

  // %description
  add_action( 'woocommerce_single_product_summary', 'custom_woocommerce_output_product_data_description', 60 );
  // %Add to cart button
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 99 );
  // %default & custom fields
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 25 );
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20 );




// ================================================================================

  function group_by_categroy($a, $b, $type) {
    if ($a['category'] == $b['category']) {
            return 0;
    }
    return ($a['category'] < $b['category']) ? -1 : 1;
  }

  function theme_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'my-custom-script', get_template_directory_uri() . '-child/js/app.js');
  }
  add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

  function show_wishlist_block($new_item) {
    $total_round = count($new_item);

    foreach ( $new_item as $key => $item ) {

      // init
      if ($i == 0) {
        printf('<div class="category-section">');
      }

      // Single item
      if ($total_round == 1) {
        printf('</div>');
      }
      // Each new category
      elseif($item['category'] != $last_category) {
        printf('</div><!-- !close-middle tag -->');
        printf('<div class="category-section '.$class.'">');

        $j++;
      }

      // @DEBUG
      // vd('last: '.$last_category);

      // Wrapper 1/2
      printf('<div class="item-wrapper inline-block">');

      // Item photo
      $_product = $item['data'];
      printf( '<a href="%s" class="thumb">%s</a>', esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product_id', $item['product_id'] ) ) ), $_product->get_image() );

      // Item remove
      $wishlist = new WC_Wishlists_Wishlist( $_GET['wlid'] );
      // printf('<span class="product-remove">');

      // printf(woocommerce_wishlist_url_item_remove($wishlist->id, $item['key_cloned']));
      // printf('<a href="'.woocommerce_wishlist_url_item_remove($wishlist->id, $item['key_cloned']).'">&times;</a>');

      // printf('</span>');

      /*printf('<a href="<?php echo woocommerce_wishlist_url_item_remove( $wishlist->id, $wishlist_item_key ); ?>" class="remove wlconfirm" title="<?php _e( 'Remove this item from your wishlist', 'wc_wishlist' ); ?>" data-message="<?php esc_attr( _e( 'Are you sure you would like to remove this item from your list?', 'wc_wishlist' ) ); ?>">&times;</a>');*/


      // Wrapper 2/2
      printf('</div>');

      // Close tag for last round.
      if ($total_round == $i+1) {
        printf('</div><!-- !close tag -->');
      }

      $i++;
      // Store for next round usage.
      $last_category = $item['category'];
    }
  }

  /**
   * Grab user info by user ID
   *
   * @param array $data Options for the function.
   * @return json|null
   */
  function get_all_user_meta( $data ) {
    $all_user_meta = get_user_meta($data['id']);
    $result['id'] = $data['id'];

    $user_detail = array('gender', 'height', 'weight', 'date_of_birth');
    foreach($user_detail as $key) {
      $result[$key] = implode($all_user_meta[$key]);
    }

    $user_body = array('neck', 'shoulder_length', 'chest', 'waist', 'hips', 'arm_length');
    foreach($user_body as $key) {
      $result[$key] = implode($all_user_meta[$key]);
    }

    return $result;
  }

  function update_all_user_meta( $data ) {
  // update_metadata ( 'user', $object_id, $meta_key, $meta_value, $prev_value );
    return 'welcome POST';
  }

  add_action('rest_api_init', function(){
      register_rest_route( 'v1/user', '/(?P<id>\d+)', array(
          'methods' => 'GET',
          'callback' => 'get_all_user_meta',
         'args' => array(
            'id' => array(
              'validate_callback' => 'is_numeric'
            ),
          ),
      ));
      register_rest_route( 'v1/user', '/(?P<id>\d+)', array(
          'methods' => 'POST',
          'callback' => 'update_all_user_meta',
         'args' => array(
            'id' => array(
              'validate_callback' => 'is_numeric'
            ),
          ),
      ));
  });
