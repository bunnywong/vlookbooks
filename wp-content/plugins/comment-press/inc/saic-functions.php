<?php

/* --------------------------------------------------------------------
   Función que Inserta el Enlace para Mostrar y Ocultar Comentarios
-------------------------------------------------------------------- */

add_shortcode('simple-comments', 'display_saic');
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode', 11);

function display_saic($atts = '') {
	global $post, $user_ID, $user_email;

	$options = get_option('saic_options');
	$icon_link = $options['icon-link'];
	$width_comments = (int) $options['width_comments'];
	$only_registered = isset($options['only_registered']) ? $options['only_registered'] : false;
	$text_link = 'Show Comments';

	//Shortcode Attributes
	extract(shortcode_atts(array(
		'post_id' => $post->ID,
		'get' => (int) $options['num_comments'],
		'style' => $options['theme'],
		'border' => isset($options['border']) ? $options['border'] : 'true',
		'order' => $options['order_comments'],
		'form' => $options['display_form'],
		'auto_load' => isset($options['auto_load']) ? $options['auto_load'] : 'false',
    ), $atts));

    //Excluir páginas

    $show_saic = true;

	if(!empty($options['exclude_pages'])){
		$pages_ids = explode(',',$options['exclude_pages']);
		if ( is_page($pages_ids) || is_single($pages_ids) ) {
			$show_saic = false;
		}
	}
	if(isset($options['exclude_home']) && $options['exclude_home'] == 'true'){
		if(is_home() || is_front_page()){
			$show_saic = false;
		}
	}
	if(isset($options['exclude_all_pages']) && $options['exclude_all_pages'] == 'true'){
		if(is_page()){
			$show_saic = false;
		}
	}

	if($show_saic == false){
		return;
	}

	$num = get_comments_number($post_id);//Solo comentarios aprovados

	switch($num){
		case 0:
			$text_link = str_replace('#N#','<span>'.$num.'</span>',$options['text_0_comments']);
			$title_link = str_replace('#N#', $num, $options['text_0_comments']);
			break;
		case 1:
			$text_link = str_replace('#N#','<span>'.$num.'</span>',$options['text_1_comment']);
			$title_link = str_replace('#N#', $num, $options['text_1_comment']);
			break;
		default:
			$text_link = str_replace('#N#','<span>'.$num.'</span>',$options['text_more_comments']);
			$title_link = str_replace('#N#', $num, $options['text_1_comment']);
			break;
	}


	$data = "<div class='saic-wrapper saic-{$style}";
	if( $border == 'true' ) $data.= " saic-border";
	$data .= "' style='overflow: hidden;";
	if( $width_comments ) $data.= " width: {$width_comments}px; ";
	$data .= "'>";

		// ENLACE DE MOSTRAR COMENTARIOS
		$data .= "<div class='saic-wrap-link'>";
			$data .="<a id='saic-link-{$post_id}' class='saic-link saic-icon-link saic-icon-link-{$icon_link} auto-load-{$auto_load}' href='?post_id={$post_id}&amp;comments={$num}&amp;get={$get}&amp;order={$order}' title='{$title_link}'><i class='saico-comment'></i>{$text_link}</a>";
		$data .= "</div><!--.saic-wrap-link-->";

		// CONTENEDOR DE LOS COMENTARIOS
		$data .= "<div id='saic-wrap-commnent-{$post_id}' class='saic-wrap-comments' style='display:none;'>";
		if ( post_password_required() ) {
			$data .= '<p style="padding: 8px 15px;">This post is password protected. Enter the password to view comments</p>';
		} else {
			if($form == 'true'){
				$data .= "<div id='saic-wrap-form-{$post_id}' class='saic-wrap-form saic-clearfix'>";
					$data .= "<div class='saic-form-avatar'>";
						$data .= get_avatar($user_email, $size = '28');
					$data .= "</div>";
					$data .= "<div id='saic-container-form-{$post_id}' class='saic-container-form";
					if( !is_user_logged_in() )
						$data.= " saic-no-login";
					$data .= "'>";
					if( $only_registered == 'true' && !is_user_logged_in() ){
						$data .= "<p>{$options['text_only_registered']} ".sprintf(__("Please %s login %s to comment", 'SAIC' ),"<a href='".wp_login_url(get_permalink())."'>","</a>")."</p>";
					}
					else if(!comments_open($post_id)) {
						$data .= "<p>{$options['text-comments-closed']}</p>";
					}
					else {
						//Formulario
						$data .= get_comment_form_SAIC($post_id);
					}
					$data .= "</div><!--.saic-container-form-->";
				$data .= "</div><!--.saic-wrap-form-->";

			} // end if comments_open
			$data .= "<div id='saic-comment-status-{$post_id}'  class='saic-comment-status'></div>";
			$data .= "<ul id='saic-container-comment-{$post_id}' class='saic-container-comments'></ul>";
			$data .= "<div class='saic-holder-{$post_id} saic-holder'></div>";

		} // end if post_password_required

		$data .= "</div><!--.saic-wrap-comments-->";

	$data .= "</div><!--.saic-wrapper-->";


	return $data;
}


/* --------------------------------------------------------------------
   Función para extraer el formulario de comentarios
-------------------------------------------------------------------- */
function get_comment_form_SAIC($post_id = null) {
	global $id;
	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;
	$options = get_option('saic_options');
	// Captcha
	$captcha = '';
	if($options['display_captcha'] == 'all' || ( $options['display_captcha'] == 'non-registered') && !is_user_logged_in() ){
		$captcha .= "<div class='saic-captcha' id='saic-captcha-{$post_id}'>";
			$captcha .= "<span class='saic-captcha-text'></span>";
			$captcha .= "<input type='text' maxlength='2' id='saic-captcha-value-{$post_id}' class='saic-captcha-value saic-input'/>";
		$captcha .= "</div><!--.saic-captcha-->";
	} else {
		$captcha .= "<div style='padding-top:10px;'></div>";
	}
	// Media Buttons
	$media_btns = '';
	$email_field = '<p class="comment-form-email saic-hide"><input name="email" value="anonymous@wordpress.com" type="hidden" class="saic-input" placeholder="e-mail" /></p>';
	$website_field = '';

	if($options['display_media_btns'] == 'true'){
		$media_btns = '<div class="saic-media-btns"><a id="saic-modal-image" href="?post_id='.$post_id.'&amp;action=image" title="'.$options["text-insert-image"].'"><span class="saico-camera"></span></a><a id="saic-modal-video" href="?post_id='.$post_id.'&amp;action=video" title="'.$options["text-insert-video"].'"><span class="saico-film"></a><a class="saic-last" id="saic-modal-url" href="?post_id='.$post_id.'&amp;action=url" title="'.$options["text-insert-link"].'"><span class="saico-link"></a></div>';
	}
	$num_fields = 1;
	if($options['display_email'] == 'true') $num_fields++;
	if($options['display_website'] == 'true') $num_fields++;

	if($options['display_email'] == 'true'){
		$email_field = '<p class="comment-form-email saic-field-'.$num_fields.'"><input id="email" name="email" type="text" aria-required="true" class="saic-input" placeholder="'.$options["text-email"].'" /><span class="saic-required">*</span><span class="saic-error-info saic-error-info-email">Email not valid.</span></p>';
	}
	if($options['display_website'] == 'true'){
		$website_field = '<p class="comment-form-url saic-field-'.$num_fields.'"><input id="url" name="url" type="text" value="" placeholder="'.$options["text-website"].'" class="saic-input" /></p>';
	}

	$fields =  array(
		'author' => '<p class="comment-form-author saic-field-'.$num_fields.'"><input id="author" name="author" type="text" aria-required="true" class="saic-input" placeholder="'.$options["text-name"].'" /><span class="saic-required">*</span><span class="saic-error-info saic-error-info-name">Enter your name</span></p>',
		'email'  => $email_field,
		'url'    => $website_field,
	);
	$args = array(
		'title_reply'=> '',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'logged_in_as' => '',
		'id_form' => 'commentform-'.$post_id,
		'id_submit' => 'submit-'.$post_id,
		'label_submit' => !empty($options["text-send"]) ? $options["text-send"] : 'Send',
		'fields' => apply_filters( 'comment_form_default_fields', $fields),
		'comment_field' => '<div class="saic-wrap-textarea"><textarea id="saic-textarea-'.$post_id.'" class="waci_comment saic-textarea autosize-textarea" name="comment" aria-required="true" placeholder="'.$options["text-write-comment"].'" rows="1"></textarea><span class="saic-required">*</span><span class="saic-error-info saic-error-info-text">'.__('2 characters minimum', 'SAIC').'.</span></div>'
	);
	$form = "";
	$form = "<div id='respond-{$post_id}' class='respond clearfix'>";
		$form .= "<form action='".site_url( '/wp-comments-post.php' )."' method='post' id='".$args['id_form']."'>";
			if ( !is_user_logged_in() ) {
				foreach ( (array) $args['fields'] as $name => $field ) {
					$form.= apply_filters( "comment_form_field_{$name}", $field );
				}
			}
			$form .= $args['comment_field'];
			$form .= "<div class='saic-wrap-submit clearfix'>".$media_btns."<p class='form-submit'>";
				//Prueba para evitar Spam
				$form .= '<span class="saic-hide">'.__( "Do not change these fields following", "SAIC" ).'</span><input type="text" class="saic-hide" name="name" value="saic"><input type="text" class="saic-hide" name="nombre" value=""><input type="text" class="saic-hide" name="form-saic" value="">';
				$form .= '<input type="button" class="saic-form-btn saic-cancel-btn" value="Cancel">';
				// $form .= '<input type="button" class="saic-form-btn saic-edit-btn" value="Edit">';

				$form .= "<input name='submit' id='".$args['id_submit']."' value='".$args['label_submit']."' type='submit' />";
				$form .= get_comment_id_fields( $post_id );
			$form .= "</p>".$captcha."</div>";
			if ( current_user_can( 'unfiltered_html' ) ) {
				$form .= wp_nonce_field( 'unfiltered-html-comment_' . $post_id,'_wp_unfiltered_html_comment', false, false );
				/*$form .= "<script>(function(){if(window===window.parent){document.getElementById('_wp_unfiltered_html_comment_disabled').name='_wp_unfiltered_html_comment';}})();</script>\n";*/
			}
		$form .= "</form>";
	$form .= "</div>";
	return $form;
}


/* --------------------------------------------------------------------
   Función que obtiene Comentarios
-------------------------------------------------------------------- */
add_action('wp_ajax_get_comments', 'get_comments_SAIC');
add_action('wp_ajax_nopriv_get_comments', 'get_comments_SAIC');

function get_comments_SAIC(){
	global $post, $id;
	$nonce = $_POST['nonce'];
  if (!wp_verify_nonce($nonce, 'saic-nonce')){
		die ( 'Busted!');
	}
	$options = get_option('saic_options');
	$post_id = (int) isset($_POST['post_id']) ? $_POST['post_id']: $post->ID;
	$get = (int) isset($_POST['get']) ? $_POST['get'] : $options['num_comments'];
	$post = get_post($post_id);
	$numComments = $post->comment_count;
	$authordata = get_userdata($post->post_author);
	$orderComments = isset($_POST['order']) ? $_POST['order'] : $options['order_comments'];
	$default_order = get_option('comment_order');


	if($orderComments == 'likes' || $orderComments == 'LIKES'){
		//Asignamos Campo Personalizado 'saic-likes_count' a todos los comentarios
		foreach (get_comments('post_id='.$post_id) as $comment){
			$comment_id = $comment->comment_ID;
			$likes_count = get_comment_meta($comment_id, 'saic-likes_count', true);
			update_comment_meta($comment_id, 'saic-likes_count', $likes_count);
		}
		$comments_args = array(
			'post_id' => $post_id,
			'number' => $get,//Número Máximo de Comentarios a Cargar
			'meta_key' => 'saic-likes_count',
			'order' => 'DESC',//Orden de los Comentarios
			'orderby' => 'meta_value_num',
			'status' => 'approve',//Solo Comentarios Aprobados
		);
	} else {
		$offset = 0;

		$comments_args = array(
			'post_id' => $post_id,
			'number' => $get,//Número Máximo de Comentarios a Cargar
			'order' => $orderComments,//Orden de los Comentarios
			'orderby' => 'comment_date',//Orden de los Comentarios
			'offset' => $offset,//Desplazamiento desde el último comentario
			'status' => 'approve',//Solo Comentarios Aprobados
		);
	}

	$comments = get_comments($comments_args);

	//ob_start(); // Activa almacenamiento en bufer

	//Display the list of comments
	$comments_depth = get_option('thread_comments_depth');
	wp_list_comments(array('callback'=> 'get_comment_HTML_SAIC', 'max_depth' => $comments_depth), $comments);

	// Obtiene el contenido del búfer actual y elimina el búfer de salida actual.

	//$listComment =  ob_get_clean();

	//echo $listComment;

	die(); // this is required to return a proper result

}


/* --------------------------------------------------------------------
   Función que Inserta un Nuevo Cometario
-------------------------------------------------------------------- */
add_action('comment_post', 'ajax_comment_SAIC', 20, 2);
function ajax_comment_SAIC($comment_ID, $comment_status){
	// Si el comentario se ejecutó con AJAX
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		//Comprobamos el estado del comentario
		switch($comment_status){
			//Si el comentario no está aprobado 'hold = 0'
			case "0":
				//Notificamos al moderador
				if( get_option('comments_notify') == 1 ){
					wp_notify_moderator($comment_ID);
				}

			//Si el comentario está aprobado 'approved = 1'
			case "1":

				//Notificamos al autor del post de un nuevo comentario
				//get_option('moderation_notify');
				if( get_option('comments_notify') == 1 ){
					wp_notify_postauthor($comment_ID);
				}

				// Obtenemos los datos del comentario
				$comment = get_comment($comment_ID);
				//Obtenemos HTML del nuevo comentario
				//ob_start(); // Activa almacenamiento en bufer
				$args = array();
				$depth = 0;//nivel de comentario

				get_comment_HTML_SAIC($comment,$args, $depth);
				//$commentData =  ob_get_clean();// Obtiene el contenido del búfer actual y elimina el búfer de salida actual.

				//echo $commentData;
				break;
			default:
				echo "error";
		}
	exit;
	}
}

/* --------------------------------------------------------------------
   Función que extrae HTML de un Comentario
-------------------------------------------------------------------- */
function get_comment_HTML_SAIC($comment,$args, $depth){

	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	$commentPostID = $comment->comment_post_ID;
	$comment_id = $comment->comment_ID;
	//$commentContent = $comment->comment_content;
	//$commentContent = apply_filters('comment_text', $commentContent);
	$comment_date = $comment->comment_date;
	$autor_id = $comment->user_id;
	$autor_email = $comment->comment_author_email;
	$autor_name = $comment->comment_author;
	$autor_url = $comment->comment_author_url;
	$autor_url = comment_author_url_SAIC($autor_name, $autor_id, $autor_url);
	$autor_info = get_userdata($autor_id);
	if(is_object($autor_info)){
		$autor_name = $autor_info->display_name;
	}
	$current_user = wp_get_current_user();

	$options = get_option('saic_options');
	$date_format = $options['date_format'];
	$rating_btns = $options['display_rating_btns'];
	$comments_depth = get_option('thread_comments_depth');
	$disable_reply = isset($options['disable_reply']) ? $options['disable_reply'] : 'false';

	?>
	<li <?php comment_class('saic-item-comment'); ?> id="saic-item-comment-<?php echo $comment_id; ?>">
  	<div id="saic-comment-<?php echo $comment_id; ?>" class="saic-comment">

      <div class="saic-comment-avatar">
        <?php echo get_avatar($autor_email, $size= '28');?>
      </div><!--.saic-comment-avatar-->

      <div class="saic-comment-content">
        <div class="saic-comment-info">
          <a <?php echo empty($autor_url) ? '': 'href="'.$autor_url.'"'?> class="saic-commenter-name" title="<?php echo $autor_name;?>"><?php echo $autor_name;?></a>
          <span class="saic-comment-time">
          	<?php if($date_format == 'date_fb') { echo get_time_since_SAIC($comment_date);} else echo get_comment_date('m/j/Y', $comment_id);?>
          </span>
        </div><!--.saic-comment-info-->
        <div class="saic-comment-text">
      		<?php //comment_text();//Elimina videos(iframe) ?>
          <?php echo my_get_comment_text($comment_id);?>
        </div><!--.saic-comment-text-->

        <div class="saic-comment-actions">
					<?php
					if($depth < $comments_depth && $disable_reply == 'false') { ?>
						<a href="?comment_id=<?php echo $comment_id;?>&amp;post_id=<?php echo $commentPostID;?>" class="saic-reply-link" id="saic-reply-link-<?php echo $comment_id;?>"><?php echo $options["text-reply"]?></a>
          <?php }
          ?>
          <?php
					if( user_can_edit_SAIC($comment_id)) { ?>
          	 <a href="?comment_id=<?php echo $comment_id;?>&amp;post_id=<?php echo $commentPostID;?>" class="saic-edit-link" id="saic-edit-link-<?php echo $comment_id;?>"><?php echo "Edit";?></a>
          	 <a href="?comment_id=<?php echo $comment_id;?>&amp;post_id=<?php echo $commentPostID;?>" class="saic-delete-link" id="saic-delete-link-<?php echo $comment_id;?>"><?php echo "Delete";?></a>
          <?php }
          ?>
        </div><!--.saic-comment-actions-->

        <?php
					if($rating_btns == 'true'){
						comment_rating_content_SAIC($comment_id);
					}
				?>
      </div><!--.saic-comment-content-->
    </div><!--.saic-comment-->
	<!--</li>-->
	<?php
}


/* --------------------------------------------------------------------
   Función que obtiene el texto de un comentario
-------------------------------------------------------------------- */
add_action('wp_ajax_get_comment_text_saic', 'get_comment_text_SAIC');
add_action('wp_ajax_nopriv_get_comment_text_saic', 'get_comment_text_SAIC');

function get_comment_text_SAIC(){
	global $post, $id;
	$nonce = $_POST['nonce'];
	$post_id = absint($_POST['post_id']);
	$comment_id = absint($_POST['comment_id']);
  if (!empty($nonce) && !wp_verify_nonce($nonce, 'saic-nonce')){
		die ( 'Busted!');
	}
	if(!empty($comment_id)){
		$comment = get_comment($comment_id);
		if(user_can_edit_SAIC($comment_id)){
			echo get_comment_text($comment_id);
		} else {
			echo 'saic-error';
		}
	}
	else{
		echo 'saic-error';
	}
	die(); // this is required to return a proper result
}


/* --------------------------------------------------------------------
   Función que elimina un comentario
-------------------------------------------------------------------- */
add_action('wp_ajax_delete_comment_saic', 'delete_comment_SAIC');
add_action('wp_ajax_nopriv_delete_comment_saic', 'delete_comment_SAIC');

function delete_comment_SAIC(){
	global $post, $id;
	$nonce = $_POST['nonce'];
	$post_id = absint($_POST['post_id']);
	$comment_id = absint($_POST['comment_id']);
  if (!empty($nonce) && !wp_verify_nonce($nonce, 'saic-nonce')){
		die ('Busted!');
	}
	if(!empty($comment_id)){
		$comment = get_comment($comment_id);
		if(user_can_edit_SAIC($comment_id)){
			wp_delete_comment($comment_id);
			die('ok');
		}
	}
	die('saic-error'); // this is required to return a proper result
}

/* --------------------------------------------------------------------
   Función que obtiene el texto de un comentario
-------------------------------------------------------------------- */
add_action('wp_ajax_edit_comment_saic', 'edit_comment_SAIC');
add_action('wp_ajax_nopriv_edit_comment_saic', 'edit_comment_SAIC');

function edit_comment_SAIC(){
	$nonce = $_POST['nonce'];
	$comment_content = trim($_POST['comment_content']);
	$post_id = absint($_POST['post_id']);
	$comment_id = absint($_POST['comment_id']);

	$result = array();
	$result['ok'] = true;

  if (!empty($nonce) && !wp_verify_nonce($nonce, 'saic-nonce')){
  	$result['ok'] = false;
  	$result['error'] = 'nonce';
		die (json_encode($result));
	}

	if (!user_can_edit_SAIC($comment_id)){
  	$result['ok'] = false;
  	$result['error'] = 'can_edit';
		die (json_encode($result));
	}
	if(empty($comment_content) || $comment_content == 'undefined'){
		$result['ok'] = false;
  	$result['error'] = 'comment_empty';
		die (json_encode($result));
	}

	//Get original comment
	$comment = get_comment( $comment_id, ARRAY_A);
	$comment['comment_content'] = $comment_content;

	//Save the comment
	wp_update_comment($comment);

	// ob_start();
	// comment_text($comment_id);
	// $result['comment_text'] = ob_get_contents();
	// ob_end_clean();

	$result['comment_text'] = my_get_comment_text($comment_id);

	die(json_encode($result));
}

/* --------------------------------------------------------------------
   Función que extrae el contenido de un comentario
-------------------------------------------------------------------- */

function my_get_comment_text($comment_id){
	global $wpdb;
	//$_comment = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_ID = " .$comment_id );
	//$comment_content = $_comment[0]->comment_content;
	//$_comment = $wpdb->get_row("SELECT * FROM $wpdb->comments WHERE comment_ID = ".$comment_id);
	//$comment_content = $_comment->comment_content;
	$comment_content = $wpdb->get_var("SELECT comment_content FROM $wpdb->comments WHERE comment_ID = ".$comment_id);

	$comment_content = wptexturize($comment_content);
	$comment_content = nl2br($comment_content); //Inserta saltos de línea al final de un string
	$comment_content = convert_chars($comment_content); //Traduce referencias Unicode no válidos a válidos
	$comment_content = make_clickable($comment_content); //Hace clickeable los enlaces
	$comment_content = convert_smilies($comment_content); //Conserva las caritas
	$comment_content = force_balance_tags($comment_content); //Equilibra etiquetas faltantes o mal cerradas
	$comment_content = wpautop($comment_content); //Cambia dobles saltos de línea en párrafos

	return $comment_content;
}

/* --------------------------------------------------------------------
   Función para insertar automaticamente el Plugín
-------------------------------------------------------------------- */
function auto_show_SAIC($content) {
	$options = get_option('saic_options');
	$where_add_comments_box = isset($options['where_add_comments_box']) ? $options['where_add_comments_box'] : 'end-content';
	if($options['auto_show'] == 'true' && $where_add_comments_box == 'end-content') {
		$content = $content.display_saic();
	}
	return $content;
}
add_filter('the_content','auto_show_SAIC');


/* --------------------------------------------------------------------
   Función para verificar si el usuario actual puede editar un comentario
-------------------------------------------------------------------- */
function user_can_edit_SAIC($comment_id) {
	$comment = get_comment($comment_id);
	$current_user = wp_get_current_user();
	if(!is_user_logged_in()){
		return false;
	}
	if (!current_user_can('moderate_comments') && $current_user->ID != $comment->user_id) {
		return false;
	}
	return true;
}


/* --------------------------------------------------------------------
   Función que elimina el formulario de comentarios por defecto
-------------------------------------------------------------------- */
function remove_wp_commet_form_SAIC($comment_template){
	return SAIC_PATH . '/inc/saic-comments-template.php';
}
add_filter( "comments_template", "remove_wp_commet_form_SAIC" );

/* --------------------------------------------------------------------
   Función que retorna el link que un usuario escribió en los comentarios
-------------------------------------------------------------------- */
function comment_author_url_SAIC($autor_name, $user_id, $autor_url){
	global $current_user;
	$user_link = $autor_url;
	//BuddyPress
	if ( username_exists( $autor_name ) && is_bp_active_SAIC() ){
			$user = get_user_by('login',$autor_name);
			$user_link = bp_core_get_user_domain($user->ID);
	}
	//User Pro
	if(is_userpro_active_SAIC()){
		global $userpro;
		get_currentuserinfo();
		if ($user_id ==  $current_user->ID ){
			$default = get_option('userpro_pages');
			$page_id = $default['profile'];
			$user_link = get_page_link($page_id);
		} else{
			$user_link = $userpro->permalink($user_id);
		}
	}
	return $user_link;
}

/* --------------------------------------------------------------------
   Función para evitar Spam
-------------------------------------------------------------------- */
add_action('pre_comment_on_post', 'remove_spam_SAIC');
function remove_spam_SAIC($comment_post_ID){
	// Si el comentario se ha enviado desde este plugin
	if(isset($_POST['form-saic'])){
		// Si los campos ocultos no se han modificado
		if($_POST['name'] != 'saic' || $_POST['nombre'] != ''){
			wp_die( __('<strong>ERROR</strong>: Your comment has been detected as Spam!') );
		}
	}
}

/* --------------------------------------------------------------------
   Función que comprueba si Buddypress está activo
-------------------------------------------------------------------- */
function is_bp_active_SAIC(){
	if(class_exists( 'BuddyPress' ))
		return true;
	else
		return false;
}

/* --------------------------------------------------------------------
   Función que comprueba si Buddypress está activo
-------------------------------------------------------------------- */
function is_userpro_active_SAIC(){
	if(class_exists( 'userpro_admin' ))
		return true;
	else
		return false;
}

/* --------------------------------------------------------------------
   Función que Verifica si una URL de un video de YouTube o Vimeo es válido y retorna el Video
-------------------------------------------------------------------- */

add_action('wp_ajax_verificar_video_SAIC', 'verificar_video_SAIC');
add_action('wp_ajax_nopriv_verificar_video_SAIC', 'verificar_video_SAIC');

function verificar_video_SAIC(){
	if ( isset($_POST['url_video']) && trim($_POST['url_video']) != ''){
		$video_player = '';
		$post_url_video = trim($_POST['url_video']);
		$tipo_video = get_tipo_video_SAIC($post_url_video);
		$id_video = get_id_video_SAIC($post_url_video,$tipo_video);
		if($id_video != 'error url' && $id_video != 'error url youtube' && $id_video != 'error url vimeo'){
			$video_player = get_embed_video_SAIC($id_video,$tipo_video,540,250);
		}
		else {
			$id_video = 'error id video';
		}
	}
	else {
		$post_url_video = '';
	}
	/* Si no hay URL o la URL es inválida */
	if($post_url_video == '' || $id_video == 'error id video'){
		$response = 'error';
	} else {
		$response = $video_player;
	}

	echo $response;
	exit;
}
/* --------------------------------------------------------------------
   Función que Devuelve el Tipo de Video desde una URL
-------------------------------------------------------------------- */
function get_tipo_video_SAIC($url_video){
	$is_youtube_url = '/^(?:https?:\/\/)?(?:www\.)?(youtube\.com\/|youtu\.be\/)/';
	$is_vimeo_url = '/^(?:https?:\/\/)?(?:www\.)?(vimeo\.com\/)/';
	if( preg_match($is_youtube_url,$url_video) ){		return "youtube";}
	else if( preg_match($is_vimeo_url,$url_video) ) {	return "vimeo";}
	else {										return "desconocido";}
}

/* --------------------------------------------------------------------
   Función que Devuelve el Id de un Video de YouTube o Vimeo
-------------------------------------------------------------------- */
function get_id_video_SAIC($url_video, $tipo_video){
	$id_video = '';
	$filter_youtube = '/^.*(youtu.be\/|v\/|\/u\/\w\/|embed\/|watch\?)\??v?=?([^#\&\?]*).*/';
	$filter_vimeo = '/^.*(vimeo\.com\/|groups\/[A-z]+\/videos\/|channels\/staffpicks\/)(\d+)$/';
	switch($tipo_video){
		case "youtube":
			$is_valid_url = preg_match($filter_youtube, $url_video, $url_array);
			if ($is_valid_url && strlen($url_array[2]) == 11 ){
				$id_video = $url_array[2];
				return $id_video;
			}
			else { return "error url youtube";}
			break;
		case "vimeo":
			$is_valid_url = preg_match($filter_vimeo, $url_video, $url_array);
			if ( $is_valid_url ){
				$id_video = $url_array[2];
				return $id_video;
			}
			else { return "error url vimeo";}
			break;
		default:
			return "error url";
			break;
	}
}

/* --------------------------------------------------------------------
   Función que Retorna el Reproductor de un Video de Youtube o Vimeo
-------------------------------------------------------------------- */
function get_embed_video_SAIC($id_video,$tipo_video,$width=610,$height=280,$autoplay=0){
	$video_player = '';
	if($tipo_video == 'youtube'){
		$video_player = '<iframe class="ytplayer" type="text/html" width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id_video.'?autoplay='.$autoplay.'" allowfullscreen frameborder="0">
</iframe>';
	}
	elseif($tipo_video == 'vimeo'){
		$video_player	= '<iframe width="'.$width.'" height="'.$height.'"  src="http://player.vimeo.com/video/'.$id_video.'?title=0&amp;autoplay='.$autoplay.'&amp;byline=0&amp;portrait=0&amp;color=3D95D3" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';

	}
	return $video_player;
}


/* --------------------------------------------------------------------
   Función que permite más tags HTML en los comentarios
-------------------------------------------------------------------- */
//add_action('comment_post', 'more_tags_html_SAIC');

//add_filter('preprocess_comment','more_tags_html_SAIC');
function more_tags_html_SAIC() {
	global $allowedtags;
	$allowedtags['p'] = array();
	$allowedtags["img"] = array(
		"src" => array(),
		"height" => array(),
		"width" => array(),
		"alt" => array(),
		"title" => array(),
	);
	$allowedtags["iframe"] = array(
		"src" => array(),
		"height" => array(),
		"width" => array(),
		"class" => array(),
		"type" => array(),
		"frameborder" => array(),
	);
	$allowedtags["object"] = array(
		"height" => array(),
		"width" => array()
	);
	$allowedtags["param"] = array(
		"name" => array(),
		"value" => array()
	);
	$allowedtags["embed"] = array(
		"src" => array(),
		"type" => array(),
		"allowfullscreen" => array(),
		"allowscriptaccess" => array(),
		"height" => array(),
		"width" => array()
	);
	return $data;
}

/* --------------------------------------------------------------------
   Contenido para Calificar Comentarios
-------------------------------------------------------------------- */
function comment_rating_content_SAIC($comment_id = 0){
	$options = get_option('saic_options');
	$likes_count = (int) get_comment_meta($comment_id, 'saic-likes_count', true);
	$likes_class = 'saic-rating-neutral';

	if($likes_count < 0){
		$likes_class = 'saic-rating-negative';
	}
	else if($likes_count > 0){
		$likes_class = 'saic-rating-positive';
	}
	?>
	<div class="saic-comment-rating">
        <a class="saic-rating-link saic-rating-like" href="?comment_id=<?php echo $comment_id;?>&amp;method=like" title="<?php echo $options["text-like"]; ?>"><span class="saico-thumb_up"></a>
        <span title="Likes" class="saic-rating-count <?php echo $likes_class?>"><?php echo $likes_count;?></span>
        <a class="saic-rating-link saic-rating-dislike" href="?comment_id=<?php echo $comment_id;?>&amp;method=dislike" title="<?php echo $options["text-unlike"]; ?>"><span class="saico-thumb_down"></a>
	</div><!--.saic-comment-rating-->
	<?php
}

/* --------------------------------------------------------------------
   Recibe la acción desde jQuery Ajax para Votar un Comentario
-------------------------------------------------------------------- */
add_action('wp_ajax_comment_rating', 'comment_rating_process_SAIC');
add_action('wp_ajax_nopriv_comment_rating', 'comment_rating_process_SAIC');

function comment_rating_process_SAIC() {
	$nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'saic-nonce')){
		die ( 'Busted rated!');
	}

	if(isset($_POST['comment_id']) && is_numeric($_POST['comment_id'])) {
		$comment_id = (int)$_POST['comment_id'];
		$action = $_POST['method'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$current_user = wp_get_current_user();
		$user_id = (int) $current_user->ID;
		$can_vote = false;
		$success = false;
		$voted_IP = checkVotedIP_SAIC($comment_id, $ip);
		$voted_user = checkVotedUser_SAIC($comment_id, $user_id);
		$voted_action = checkVotedAction_SAIC($comment_id, $ip, $action);

		//Si la IP actual ya votó
		if($voted_IP){
			//Comprobamos que la acción actual es contraria "like/dislike"
			if(!$voted_action) {
				$can_vote = true;
			}
			//si la IP ya fue registrada, pero se trata de otro usuario
			else if(!$voted_user && is_user_logged_in()){
				$can_vote = true;
			}
		}
		//si nunca a votado
		else {
			$can_vote = true;
		}
		if($can_vote) {
			//se procede a realizar la votación
			makeTheVote_SAIC($comment_id, $ip, $current_user, $action);
		} else {
			$likes_count = get_comment_meta($comment_id, 'saic-likes_count', true);

			$result = array(
				'success' => $success,
				'likes' => $likes_count,
				'message' => '',
			);
			echo json_encode($result);
		}
	}
	exit;
}
/* --------------------------------------------------------------------
   Función que realiza un Post Like a un Post
-------------------------------------------------------------------- */
function makeTheVote_SAIC($comment_id, $ip, $current_user, $action){
	$user_id = (int) $current_user->ID;
	$user_name = $current_user->user_login;

	$likes_count = get_comment_meta($comment_id, 'saic-likes_count', true);
	$likes_IP = getVotedIP_SAIC($comment_id);
	$likes_action = getVotedIP_SAIC($comment_id);
	$likes_IP[$ip] = time();
	$likes_action[$ip] = $action;


	//Actualizamos 'Likes por IP y Acción' del comentario
	update_comment_meta($comment_id, 'saic-likes_IP', $likes_IP);
	update_comment_meta($comment_id, 'saic-likes_action', $likes_action);

	// Si la acción de Like
	if($action == 'like') {
		//Sumamos un 'Like' al comentario
		update_comment_meta($comment_id, 'saic-likes_count', ++$likes_count);

		//Actualizamos 'saic-likes_comment' del Usuario
		$likes_comment = getCommentLikeUser_SAIC();
		$likes_comment = array_diff($likes_comment, array($comment_id));
		$likes_comment = array_values($likes_comment);
		$likes_comment[] = $comment_id;
		update_user_meta($user_id, 'saic-likes_comment', $likes_comment);
	}

	else {
		//Restamos un 'Like' al comentario
		update_comment_meta($comment_id, 'saic-likes_count', --$likes_count);

		//Actualizamos 'saic-dislikes_comment' del Usuario
		$dislikes_comment = getCommentDislikeUser_SAIC();
		$dislikes_comment = array_diff($dislikes_comment, array($comment_id));
		$dislikes_comment = array_values($dislikes_comment);
		$dislikes_comment[] = $comment_id;
		update_user_meta($user_id, 'saic-dislikes_comment', $dislikes_comment);

	}
	//Mostramos el resultado
	$success = true;
	$result = array(
		'success' => $success,
		'likes' => $likes_count,
		'message' => ''
	);
	echo json_encode($result);
}

/* --------------------------------------------------------------------
   Función que comprueba si un Usuario ya ha votado
-------------------------------------------------------------------- */
function checkVotedUser_SAIC($comment_id, $user_id = '') {
	$likes_comment = getCommentLikeUser_SAIC($user_id);
	$dislikes_comment = getCommentDislikeUser_SAIC($user_id);

	if( in_array($comment_id, array_values($likes_comment)) ){
		return true;
	}
	if( in_array($comment_id, array_values($dislikes_comment)) ){
		return true;
	}
	return false;
}
/* --------------------------------------------------------------------
   Función que obtiene el Campo Personalizado 'saic-likes_comment' de un Usuario
-------------------------------------------------------------------- */
function getCommentLikeUser_SAIC($user_id = '') {
	$user_likes_comment = get_user_meta($user_id, 'saic-likes_comment');
	$likes_comment = $user_likes_comment[0];
	if(!is_array($likes_comment)) {
		$likes_comment = array();
	}
  return $likes_comment;
}
/* --------------------------------------------------------------------
   Función que obtiene el Campo Personalizado 'saic-dislikes_comment' de un Usuario
-------------------------------------------------------------------- */
function getCommentDislikeUser_SAIC($user_id = '') {
	$user_dislikes_comment = get_user_meta($user_id, 'saic-dislikes_comment');
	$dislikes_comment = $user_dislikes_comment[0];
	if(!is_array($dislikes_comment)) {
		$dislikes_comment = array();
	}
   return $dislikes_comment;
}


/* --------------------------------------------------------------------
   Función que comprueba si una IP ya ha votado
-------------------------------------------------------------------- */
function checkVotedIP_SAIC($comment_id, $ip = ''){
	if($ip == '' ) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	$likes_IP = getVotedIP_SAIC($comment_id);
	if( in_array($ip, array_keys($likes_IP)) ){
		return true;
	} else {
		return false;
	}
}

/* --------------------------------------------------------------------
   Función que obtiene todas la IP que han votado un Comentario
-------------------------------------------------------------------- */
function getVotedIP_SAIC($comment_id){
	$meta_IP = get_comment_meta($comment_id, 'saic-likes_IP');
	$likes_IP = $meta_IP[0];
	if(!is_array($likes_IP)) {
		$likes_IP = array();
	}
    return $likes_IP;
}
/* --------------------------------------------------------------------
   Función que comprueba la última acción de un voto "like/dislike"
-------------------------------------------------------------------- */
function checkVotedAction_SAIC($comment_id, $ip = '', $action){
	if($ip == '' ) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	$meta_action = get_comment_meta($comment_id, 'saic-likes_action');
	$action_IP = $meta_action[0];
	if(!is_array($action_IP)) {
		$action_IP = array();
	}
	if($action == $action_IP[$ip])
		return true;
	return false;
}


/* --------------------------------------------------------------------
   Tiempo en que se ha publicado un Comentario
-------------------------------------------------------------------- */
function get_time_since_SAIC($time = ''){
	if($time == ''){
		$time_since_posted = make_time_since_SAIC( get_the_time( 'U' ), current_time( 'timestamp' ) );
	}
	else {
		$time_since_posted = make_time_since_SAIC( $time, current_time( 'timestamp' ) );
	}
	return $time_since_posted;
}
/* --------------------------------------------------------------------
   Retorna la diferencia entre dos tiempos, función						   					   bp_core_time_since() de budypress modificada
-------------------------------------------------------------------- */
function make_time_since_SAIC($older_date, $newer_date = false){
	$unknown_text   = 'sometime';
	$right_now_text = 'right now';
	$ago_text       = '%s ago';

	//Time Periods
	$chunks = array(
		array( 60 * 60 * 24 * 365 , 'year','years'),
		array( 60 * 60 * 24 * 30 , 'month', 'months'  ),
		array( 60 * 60 * 24 * 7, 'week', 'weeks' ),
		array( 60 * 60 * 24 , 'day', 'days'  ),
		array( 60 * 60 ,'hour', 'hours' ),
		array( 60 , 'min', 'mins'),
		array( 1, 'sec', 'secs')
	);

	if ( !empty( $older_date ) && !is_numeric( $older_date ) ) {
		$time_chunks = explode( ':', str_replace( ' ', ':', $older_date ) );
		$date_chunks = explode( '-', str_replace( ' ', '-', $older_date ) );
		$older_date  = gmmktime( (int) $time_chunks[1], (int) $time_chunks[2], (int) $time_chunks[3], (int) $date_chunks[1], (int) $date_chunks[2], (int) $date_chunks[0] );
	}

	$newer_date = ( !$newer_date ) ? strtotime( current_time( 'mysql', true ) ) : $newer_date;

	// Diferencia en segundos
	$since = $newer_date - $older_date;

	// Si algo salió mal y terminamos con una fecha negativa
	if ( 0 > $since ) {
		$output = $unknown_text;

	/**
	 * Solo mostraremos dos bloques de tiempo, ejemplo:
	 * x años, xx meses
	 * x días, xx horas
	 * x horas, xx minutos
	 */
	} else {
		for ( $i = 0, $j = count( $chunks ); $i < $j; ++$i ) {
			$seconds = $chunks[$i][0];
			$count = floor( $since / $seconds );
			if ( 0 != $count ) {
				break;
			}
		}
		// Si el evento ocurrió hace 0 segundos
		if ( !isset( $chunks[$i] ) ) {
			$output = $right_now_text;
		} else {
			$output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];
			if ( $i + 2 < $j ) {
				$seconds2 = $chunks[$i + 1][0];
				$name2    = $chunks[$i + 1][1];
				$count2   = floor( ( $since - ( $seconds * $count ) ) / $seconds2 );
				if ( 0 != $count2 ) {
					$output .= ( 1 == $count2 ) ? _x( ',', 'Separator in time since', 'buddypress' ) . ' 1 '. $name2 : _x( ',', 'Separator in time since', 'buddypress' ) . ' ' . $count2 . ' ' . $chunks[$i + 1][2];
				}
			}
			if ( ! (int) trim( $output ) ) {
				$output = $right_now_text;
			}
		}
	}
	if ( $output != $right_now_text ) {
		$output = sprintf( $ago_text, $output );
	}

	return $output;
}

?>