<?php

  /**
   * Child theme init
   */
  function theme_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  }
  add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

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
