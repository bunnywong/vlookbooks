<?php
/*
Plugin Name: CommentPress
Description: Insert, edit and delete comments wherever you want with Ajax. Put <code>&lt;?php if(function_exists('display_saic')) { echo display_saic();} ?&gt;</code> where you want to show comments. The plugin <a href="edit-comments.php?page=commentpress.php">configuration</a> page.
Version: 2.1.0
Author: Max López
*/
//Copyright 2013 Max López

/* --------------------------------------------------------------------
   Definimos Constantes
-------------------------------------------------------------------- */
define( 'SAIC_PLUGIN_NAME', 'CommentPress' );
define( 'SAIC_VERSION', '2.1.0' );
define( 'SAIC_PATH', dirname( __FILE__ ) );
define( 'SAIC_FOLDER', basename( SAIC_PATH ) );
define( 'SAIC_URL', plugins_url() . '/' . SAIC_FOLDER );

/* --------------------------------------------------------------------
   Configuración de Acciones y Ganchos
-------------------------------------------------------------------- */
register_activation_hook(__FILE__, 'install_options_SAIC');
//register_uninstall_hook
register_deactivation_hook(__FILE__, 'delete_options_SAIC');
add_action('admin_init', 'requires_wp_version_SAIC' );
add_action('admin_init', 'register_options_SAIC' );
add_action('admin_menu', 'add_options_page_SAIC');
add_filter('plugin_action_links', 'plugin_action_links_SAIC', 10, 2 );
add_action('wp_enqueue_scripts', 'add_styles_SAIC');
add_action('wp_enqueue_scripts', 'add_scripts_SAIC');
add_action('wp_enqueue_scripts', 'add_custom_styles_SAIC');
add_action('admin_enqueue_scripts', 'add_admin_styles_SAIC');
add_action('admin_enqueue_scripts', 'add_admin_scripts_SAIC');
add_action('plugins_loaded', 'plugin_textdomain_SAIC');

/* --------------------------------------------------------------------
   Activamos Soporte para la Traduccion del Plugin
-------------------------------------------------------------------- */
function plugin_textdomain_SAIC() {
    load_plugin_textdomain( 'SAIC', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
/* --------------------------------------------------------------------
   Comprobamos si la version actual de WordPress es Compatible con el Plugin
-------------------------------------------------------------------- */
function requires_wp_version_SAIC() {
	global $wp_version;
	$plugin = plugin_basename( __FILE__ );
	$plugin_data = get_plugin_data( __FILE__, false );

	if ( version_compare($wp_version, "3.2", "<" ) ) {
		if( is_plugin_active($plugin) ) {
			deactivate_plugins( $plugin );
			wp_die( "'".$plugin_data['Name']."' requires Wordpress 3.2 or higher, and is disabled, you must update Wordpress.<br /><br />Return to the <a href='".admin_url()."'>desktop WordPress</a>." );
		}
	}
}


/* --------------------------------------------------------------------
   Registramos las Opciones del Plugin
-------------------------------------------------------------------- */
function register_options_SAIC(){
	register_setting('saic_group_options','saic_options','validate_options_SAIC' );
	$options = get_option('saic_options');
	$restore_options = isset($options['default_options']) ? $options['default_options']: 'false';

	//Si está marcada la opción de restaurar a los valores por defecto
	if($restore_options == 'true'){
		$default_options = default_options_SAIC();
		update_option('saic_options', $default_options);
	}

}
/* --------------------------------------------------------------------
   Valores por Defecto de las Opciones del Plugin
-------------------------------------------------------------------- */
function default_options_SAIC(){
	return array(
		"auto_show" => "true",
		"where_add_comments_box" => "end-content",
		"exclude_pages" => "",
		"exclude_home" => "false",
		"exclude_all_pages" => "false",
		"auto_load" => "true",
		"num_comments" => "30",
		"order_comments" => "DESC",
		"only_registered" => "false",
		"text_only_registered" => "",
		"disable_reply" => "false",
		"typejquery" => "current-theme",

		"default_options" => "false",

		"jpages" => "true",
		"num_comments_by_page" => "10",
		"text_counter" => "true",
		"text_counter_num" => "500",
		"display_form" => "true",
		"display_captcha" => "all",
		"display_media_btns" => "true",
		"display_email" => "true",
		"display_website" => "true",
		"display_rating_btns" => "true",
		"text_0_comments" => "#N# Comments",
		"text_1_comment" => "#N# Comment",
		"text_more_comments" => "#N# Comments",
		"icon-link" => 'true',
		"date_format" => 'date_fb',
		"max_width_images" => "100",
		"unit_images_size" => '%',

		"width_comments" => "",
		"border" => "true",
		"theme" => "default",
		"css_background_box" => "#F5F7FA",
		"css_border_color" => "#d5deea",
		"css_text_color" => "#44525F",
		"css_link_color" => "#3D7DBC",
		"css_link_color_hover" => "#2a5782",
		"css_text_color_secondary" => "#9DA8B7",
		"css_background_input" => "#FFFFFF",
		"css_background_button" => "#3D7DBC",
		"css_background_button_hover" => "#4d8ac5",
		"css_text_color_button" => "#FFFFFF",
		"css_rating_color" => "#c9cfd7",
		"css_rating_color_hover" => "#3D7DBC",
		"css_rating_positive_color" => "#2C9E48",
		"css_rating_negative_color" => "#D13D3D",
		"css_success_color" => "#319342",
		"css_error_color" => "#C85951",

		"text-write-comment" => "Write comment",
		"text-send" => "Send",
		"text-reply" => "Reply",
		"text-insert-image" => "Insert image",
		"text-insert-video" => "Insert video",
		"text-insert-link" => "Insert link",
		"text-thanks-comment" => "Thanks for your comment!",
		"text-thanks-reply-comment" => "Thanks for answering the comment!",
		"text-duplicate-comment" => "You might have left one of the fields blank, or duplicate comments",
		"text-accept" => "Accept",
		"text-cancel" => "Cancel",
		"text-check-video" => "Check video",
		"text-like" => "Like",
		"text-unlike" => "Unlike",
		"text-comments-closed" => "Comments are closed",
		"text-name" => "Name",
		"text-email" => "Email",
		"text-website" => "Website",
		);
}
/* --------------------------------------------------------------------
   Establecemos Opciones del Plugin
-------------------------------------------------------------------- */
function install_options_SAIC() {
	$options = get_option('saic_options');
	$default_options = default_options_SAIC();
	if(is_array($options) && !empty($options)){
		$set_options = array_merge($default_options, $options);
	} else {
		$set_options = $default_options;
	}
	update_option('saic_options', $set_options);
}
/* --------------------------------------------------------------------
   Eliminamos las Opciones del Plugin cuado este se Desactiva
-------------------------------------------------------------------- */
function delete_options_SAIC() {
	//No eliminar porque también se borran los valores establecidos por los usuarios
	//delete_option('saic_options');
}

/* --------------------------------------------------------------------
   Previene la carga de scripts con el plugin Autoptimize
-------------------------------------------------------------------- */
add_filter( 'autoptimize_filter_js_exclude', 'exclude_saic_scripts' );
function exclude_saic_scripts( $ao_noptimize ) {
    $ao_noptimize = $ao_noptimize.',jquery,saic_script.js';
    return $ao_noptimize;
}

/* --------------------------------------------------------------------
   Carga de Scripts jQuery y Estilos CSS
-------------------------------------------------------------------- */
function add_admin_scripts_SAIC($hook){
	global $wp_version;
	if('comments_page_commentpress' != $hook){
		return;
	}
	//If the WordPress version is greater than or equal to 3.5, then load the new WordPress color picker.
	if ( 3.5 <= $wp_version ){
		//Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
	//If the WordPress version is less than 3.5 load the older farbtasic color picker.
	else {
		//As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'farbtastic' );
	}

	//Loading JS using wp_enqueue
	wp_register_script( 'saic_admin_js_script', SAIC_URL.'/js/saic_admin_script.js', array('jquery'), SAIC_VERSION, true );
	wp_enqueue_script( 'saic_admin_js_script' );
}
function add_scripts_SAIC() {
	//Loading JS using wp_enqueue
	$options = get_option('saic_options');
	if ( !is_admin() ) {
		switch($options['typejquery']){
			case 'current-theme':
				//Not load jQuery
				break;

			case 'google':
				wp_deregister_script('jquery');
				wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, '1.10.2', false);
				wp_enqueue_script('jquery');
				break;

			case 'jquery-plugin':
				wp_deregister_script('jquery');
				wp_register_script('jquery', SAIC_URL.'/js/libs/jquery.min.v1.10.2.js', false, '1.10.2', false);
				break;
		}

		//Añadimos el Script JS Principal
		wp_register_script( 'saic_js_script', SAIC_URL.'/js/saic_script.js', array('jquery'), SAIC_VERSION, true );
		wp_enqueue_script( 'saic_js_script' );
		wp_localize_script('saic_js_script','SAIC_WP',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'saicNonce' => wp_create_nonce('saic-nonce'),
				'jpages' => $options['jpages'],
				'jPagesNum' => $options['num_comments_by_page'],
				'textCounter' => $options['text_counter'],
				'textCounterNum' => $options['text_counter_num'],
				'widthWrap' => $options['width_comments'],
				'autoLoad' => $options['auto_load'],
				'thanksComment' => $options['text-thanks-comment'],
				'thanksReplyComment' => $options['text-thanks-reply-comment'],
				'insertImage' => $options['text-insert-image'],
				'insertVideo' => $options['text-insert-video'],
				'insertLink' => $options['text-insert-link'],
				'accept' => $options['text-accept'],
				'cancel' => $options['text-cancel'],
				'checkVideo' => $options['text-check-video'],
			)
		);

		//Si está activado Paginación de Comentarios
		if( $options['jpages'] == 'true' ) {
			wp_register_script( 'saic_jPages', SAIC_URL.'/js/libs/jquery.jPages.min.js', array('jquery'), '0.7', true );
			wp_enqueue_script( 'saic_jPages' );
		}
		//Si está activado Contador de Caracteres
		if( $options['text_counter'] == 'true' ) {
			wp_register_script( 'saic_textCounter', SAIC_URL.'/js/libs/jquery.textareaCounter.js', array('jquery'), '2.0', true );
			wp_enqueue_script( 'saic_textCounter' );
		}
		//PlaceHolder
		wp_register_script( 'saic_placeholder', SAIC_URL.'/js/libs/jquery.placeholder.min.js', array('jquery'), '2.0.7', true );
		wp_enqueue_script( 'saic_placeholder' );
		//Autosize
		wp_register_script( 'saic_autosize', SAIC_URL.'/js/libs/autosize.min.js', array('jquery'), '1.14', true );
		wp_enqueue_script( 'saic_autosize' );

	}
}
function add_admin_styles_SAIC() {
	//Loading CSS using wp_enqueue
	if ( is_admin() ) {
		wp_register_style( 'saic_admin_style', SAIC_URL.'/css/saic_admin_style.css', array(), SAIC_VERSION, 'screen' );
		wp_enqueue_style( 'saic_admin_style' );
	}
}
function add_styles_SAIC() {
	//Loading CSS using wp_enqueue
	if ( !is_admin() ) {
		wp_register_style( 'saic_style', SAIC_URL.'/css/saic_style.css', array(), SAIC_VERSION, 'screen' );
		wp_enqueue_style( 'saic_style' );

		//Custom CSS by Users
		$options = get_option('saic_options');
		$max_width_img = $options['max_width_images'];
		$unit = $options['unit_images_size'];
		?>
		<style type="text/css">
		.saic-comment-text img {
			max-width: <?php echo $max_width_img.$unit; ?> !important;
		}
		</style>
		<?php
	}
}

/* --------------------------------------------------------------------
   Estilos personalizados
-------------------------------------------------------------------- */
function add_custom_styles_SAIC(){
	$options = get_option('saic_options');

	if($options['theme'] != 'custom') return;

	$custom_css = "
	.saic-wrapper {
	  background: {$options['css_background_box']};
	}
	.saic-wrapper.saic-border {
	  border: 1px solid {$options['css_border_color']};
	}

	.saic-wrapper .saic-wrap-comments a:link,
	.saic-wrapper .saic-wrap-comments a:visited {
	  color: {$options['css_link_color']};
	}

	.saic-wrapper .saic-wrap-link a.saic-link {
	  color: {$options['css_link_color']};
	}
	.saic-wrapper .saic-wrap-link a.saic-link.saic-icon-link-true .saico-comment {
	  color: {$options['css_link_color']};
	}
	.saic-wrapper .saic-wrap-link a.saic-link:hover {
	  color: {$options['css_link_color_hover']};
	}
	.saic-wrapper .saic-wrap-link a.saic-link:hover .saico-comment {
	  color: {$options['css_link_color_hover']};
	}

	.saic-wrapper .saic-wrap-form {
	  border-top: 1px solid {$options['css_border_color']};
	}
	.saic-wrapper .saic-wrap-form .saic-container-form textarea.saic-textarea {
	  border: 1px solid {$options['css_border_color']};
	  background: {$options['css_background_input']};
	  color: {$options['css_text_color']};
	}
	.saic-wrapper .saic-wrap-form .saic-container-form input[type='text'] {
	  border: 1px solid {$options['css_border_color']};
	  background: {$options['css_background_input']};
	  color: {$options['css_text_color']};
	}
	.saic-wrapper .saic-wrap-form .saic-container-form input.saic-input:focus,
	.saic-wrapper .saic-wrap-form .saic-container-form textarea.saic-textarea:focus {
	  border-color: #64B6EC;
	}
	.saic-wrapper .saic-wrap-form .saic-container-form input[type='submit'],
	.saic-wrapper .saic-wrap-form .saic-container-form input[type='button'].saic-form-btn {
	  color: {$options['css_text_color_button']};
	  background: {$options['css_background_button']};
	}
	.saic-wrapper .saic-wrap-form .saic-container-form input[type='submit']:hover,
	.saic-wrapper .saic-wrap-form .saic-container-form input[type='button'].saic-form-btn:hover {
	  background: {$options['css_background_button_hover']};
	}
	.saic-wrapper .saic-wrap-form .saic-container-form .saic-captcha .saic-captcha-text {
	  color: {$options['css_text_color']};
	}

	.saic-wrapper .saic-media-btns a > span {
	  color: {$options['css_link_color']};
	}
	.saic-wrapper .saic-media-btns a > span:hover {
	  color: {$options['css_link_color_hover']};
	}

	.saic-wrapper .saic-comment-status {
	  border-top: 1px solid {$options['css_border_color']};
	}
	.saic-wrapper .saic-comment-status p.saic-ajax-success {
	  color: {$options['css_success_color']};
	}
	.saic-wrapper .saic-comment-status p.saic-ajax-error {
	  color: {$options['css_error_color']};
	}
	.saic-wrapper .saic-comment-status.saic-loading > span {
	  color: {$options['css_link_color']};
	}

	.saic-wrapper ul.saic-container-comments {
	  border-top: 1px solid {$options['css_border_color']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment {
	  border-bottom: 1px solid {$options['css_border_color']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment ul li.saic-item-comment {
	  border-top: 1px solid {$options['css_border_color']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-info a.saic-commenter-name {
	  color: {$options['css_link_color']} !important;
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-info a.saic-commenter-name:hover {
	  color: {$options['css_link_color_hover']} !important;
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-info .saic-comment-time {
	  color: {$options['css_text_color_secondary']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-text p {
	  color: {$options['css_text_color']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-actions a {
	  color: {$options['css_link_color']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-actions a:hover {
	  color: {$options['css_link_color_hover']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-rating .saic-rating-link > span {
	  color: {$options['css_rating_color']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-rating .saic-rating-link > span:hover {
	  color: {$options['css_rating_color_hover']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-rating .saic-rating-count {
	  color: {$options['css_text_color_secondary']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-rating .saic-rating-count.saic-rating-positive {
	  color: {$options['css_rating_positive_color']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-rating .saic-rating-count.saic-rating-negative {
	  color: {$options['css_rating_negative_color']};
	}
	.saic-wrapper ul.saic-container-comments li.saic-item-comment .saic-comment-content .saic-comment-rating .saic-rating-count.saico-loading {
	  color: {$options['css_rating_color']};
	}
	.saic-wrapper ul.saic-container-comments a.saic-load-more-comments:hover {
	  color: {$options['css_link_color_hover']};
	}

	.saic-wrapper .saic-counter-info {
	  color: {$options['css_text_color_secondary']};
	}

	.saic-wrapper .saic-holder span {
	  color: {$options['css_link_color']};
	}
	.saic-wrapper .saic-holder a,
	.saic-wrapper .saic-holder a:link,
	.saic-wrapper .saic-holder a:visited {
	  color: {$options['css_link_color']};
	}
	.saic-wrapper .saic-holder a:hover,
	.saic-wrapper .saic-holder a:link:hover,
	.saic-wrapper .saic-holder a:visited:hover {
	  color: {$options['css_link_color_hover']};
	}
	.saic-wrapper .saic-holder a.jp-previous.jp-disabled, .saic-wrapper .saic-holder a.jp-previous.jp-disabled:hover, .saic-wrapper .saic-holder a.jp-next.jp-disabled, .saic-wrapper .saic-holder a.jp-next.jp-disabled:hover {
	  color: {$options['css_text_color_secondary']};
	}
	";

	wp_add_inline_style( 'saic_style', $custom_css );
}

/* --------------------------------------------------------------------
   Función para validar los campos del Formulario de Opciones
-------------------------------------------------------------------- */
function validate_options_SAIC($input) {
	$input['num_comments'] =  wp_filter_nohtml_kses($input['num_comments']);
	return $input;
}
/* --------------------------------------------------------------------
   Añadimos La Página de Opciones al Ménu
-------------------------------------------------------------------- */
function add_options_page_SAIC() {
	$page_saic = add_submenu_page('edit-comments.php', sprintf(__('%s Settings','SAIC'), SAIC_PLUGIN_NAME ), SAIC_PLUGIN_NAME , 'manage_options', 'commentpress.php', 'add_options_form_SAIC');

	//Link Scripts Only on a Plugin Administration Screen
	//add_action('admin_enqueue_scripts-' . $page_saic, 'add_admin_scripts_SAIC');

}
/* --------------------------------------------------------------------
   Añadimos el Formulario de Opciones a la Página
-------------------------------------------------------------------- */
function add_options_form_SAIC() {
	include_once( 'inc/saic-options-page.php' );
}

/* --------------------------------------------------------------------
    Mostramos el Link de Ajastes al Plugin
-------------------------------------------------------------------- */
function plugin_action_links_SAIC( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$saic_links = '<a href="'.get_admin_url().'edit-comments.php?page=commentpress.php">'.__('Settings', 'SAIC').'</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $saic_links );
	}
	return $links;
}

/* --------------------------------------------------------------------
   Añadimos las Fuciones para Insertar Comentarios
-------------------------------------------------------------------- */
include_once( 'inc/saic-functions.php' );