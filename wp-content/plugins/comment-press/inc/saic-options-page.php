<?php
$options = get_option('saic_options');
global $wp_version;

?>
<div class="wrap">
	<!-- Display Plugin Icon and Header -->
	<?php screen_icon('saic'); ?>
	<h2 <?php if(version_compare($wp_version, "3.8", ">=" )) echo 'class="title-settings"';?>><?php _e( SAIC_PLUGIN_NAME.' Settings', 'SAIC' );?></h2>

<?php
		if ( ! isset( $_REQUEST['settings-updated'] ) )
			$_REQUEST['settings-updated'] = false;
		?>
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="message updated" style="width:80%"><p><strong><?php _e( 'Options saved', 'SAIC'); ?></strong></p></div>
	<?php endif; ?>

<h2 id="saic-tabs" class="nav-tab-wrapper">
  <a class="nav-tab" href="#saic-tab1"><?php _e( 'General', 'SAIC' );?></a>
  <a class="nav-tab" href="#saic-tab2"><?php _e( 'Content', 'SAIC' );?></a>
  <a class="nav-tab" href="#saic-tab3"><?php _e( 'Customization', 'SAIC' );?></a>
  <a class="nav-tab" href="#saic-tab4"><?php _e( 'Message translation', 'SAIC' );?></a>
  <a class="nav-tab" href="#saic-tab5"><?php _e( 'Fast help', 'SAIC' );?></a>
</h2>
<form id="saic-form" action="<?php echo admin_url('options.php');?>" method="post" >
  <?php settings_fields('saic_group_options'); ?>
  <div class="saic-tab-container">
    <div id="saic-tab1" class="saic-tab-content">
      <!-- Activar Automáticamente -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Insert the comments box automatically', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">

            	<div class="saic-radio saic-radio-h saic-float-l saic-5-box">
            <input id="saic-auto-show-true" name="saic_options[auto_show]" type="radio" value="true" <?php checked('true', $options['auto_show']); ?> />
            <label for="saic-auto-show-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
        </div><!--.saic-radio-->
        <div class="saic-radio saic-radio-h saic-float-l saic-5-box">
            <input id="saic-auto-show-false" name="saic_options[auto_show]" type="radio" value="false" <?php checked('false', $options['auto_show']); ?> />
            <label for="saic-auto-show-false"><?php _e( 'Not', 'SAIC' ); ?></label>

        </div><!--.saic-radio-->
        <p class="saic-descrip-item"><?php echo sprintf(__( 'If you do not want to automatically display, add %s where you want to show comments. Or use %sshortcodes%s', 'SAIC' ), '<strong>&lt;?php if(function_exists("display_saic")) { echo display_saic();} ?&gt;</strong>', '<a href="http://ajax-insert-comments.info/how-to-insert-using-shortcode/" target="_blank">', '</a>'); ?></p>
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group option-where-add-comments-box">
        <div class="saic-control-label">
        <label><?php _e( 'Where add the comments box?', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-v">
          <input id="saic-add-in-end-content" name="saic_options[where_add_comments_box]" type="radio" value="end-content" <?php checked('end-content', $options['where_add_comments_box']); ?> />
          <label for="saic-add-in-end-content"><?php _e( 'At the end of content', 'SAIC' ); ?></label>
          <span class="saic-descrip-item"><?php _e( 'Adds the comment box at the end of the content of a post or page.', 'SAIC' ); ?></span>
        </div><!--.saic-radio-->
        <div class="saic-radio saic-radio-v">
          <input id="saic-add-in-same-place" name="saic_options[where_add_comments_box]" type="radio" value="same-place" <?php checked('same-place', $options['where_add_comments_box']); ?> />
          <label for="saic-add-in-same-place"><?php _e( 'In the same place where is default comment system.', 'SAIC' ); ?></label>
          <span class="saic-descrip-item"><?php _e( 'Adds the comment box in the same place where is the default comment system.', 'SAIC' ); ?></span>
        </div><!--.saic-radio-->
        </div><!--.saic-controls-->
      </fieldset>
      <!-- Excluir algunas páginas -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
        <label for="exclude_pages"><?php _e( 'Not show in', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
            	<div class="saic-float-l saic-3-box">
          <input id="exclude_pages" type="text" name="saic_options[exclude_pages]" value="<?php echo $options['exclude_pages']; ?>" />
        </div><!--.saic-3-box-->
        <div class="saic-float-l saic-3-box" style="padding-top:6px;">
              	<input id="exclude_home" name="saic_options[exclude_home]" type="checkbox" value="true" <?php if (isset($options['exclude_home'])) { checked('true', $options['exclude_home']); } ?> />
              	<label for="exclude_home"><?php _e( 'Not show in Home', 'SAIC' ); ?></label>
        </div><!--.saic-3-box-->
        <div class="saic-float-l saic-3-box saic-last" style="padding-top:6px;">
              	<input id="exclude_all_pages" name="saic_options[exclude_all_pages]" type="checkbox" value="true" <?php if (isset($options['exclude_all_pages'])) { checked('true', $options['exclude_all_pages']); } ?> />
              	<label for="exclude_all_pages"><?php _e( 'Exclude all pages', 'SAIC' ); ?></label>
        </div><!--.saic-3-box-->
        <p class="saic-descrip-item" style="clear:both; float:left;"><?php _e( 'Exclude Posts or Pages. Add IDs separated by commas. e.g: 4,72', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>
      <div class="saic-line-sep"></div>

      <!-- Carga Automáticamente -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
        <label><?php _e( 'Load Comments Automatically','SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-h saic-float-l saic-5-box">
          <input id="saic-auto-load-true" name="saic_options[auto_load]" type="radio" value="true" <?php checked('true', $options['auto_load']); ?> />
          <label for="saic-auto-load-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
        </div><!--.saic-radio-->
        <div class="saic-radio saic-radio-h saic-float-l saic-5-box">
          <input id="saic-auto-load-false" name="saic_options[auto_load]" type="radio" value="false" <?php checked('false', $options['auto_load']); ?> />
          <label for="saic-auto-load-false"><?php _e( 'Not', 'SAIC' ); ?></label>

        </div><!--.saic-radio-->
        <br />
  			  <p class="saic-descrip-item"><?php _e( 'If enabled, the comments will be loaded automatically on page load.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>


      <!-- Número de Comentarios -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
        <label for="num_comments"><?php _e( 'Number maximum of comments to load', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <input id="num_comments" type="text" name="saic_options[num_comments]" value="<?php echo $options['num_comments']; ?>" />
        <p class="saic-descrip-item"><?php _e( 'Default value', 'SAIC' ); ?>: 30. <?php _e( 'Indicates the maximum number of comments of a post to be extracted from the data base.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>

      <!-- Orden de los Comentarios -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
        <label><?php _e( 'Order of the comments', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-v">
            <input id="saic-order_comments-des" name="saic_options[order_comments]" type="radio" value="DESC" <?php checked('DESC', $options['order_comments']); ?> />
            <label for="saic-order_comments-des"><?php _e( 'The first new comments', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( 'Sorts the comments from newest to oldest', 'SAIC' ); ?></span>
        </div><!--.saic-radio-->
        <div class="saic-radio saic-radio-v">
          <input id="saic-order_comments-asc" name="saic_options[order_comments]" type="radio" value="ASC" <?php checked('ASC', $options['order_comments']); ?> />
          <label for="saic-order_comments-asc"><?php _e( 'The first ancient comments', 'SAIC' ); ?></label>
          <span class="saic-descrip-item"><?php _e( 'Sorts the comments from the oldest to the newest', 'SAIC' ); ?></span>
        </div><!--.saic-radio-->

        <div class="saic-radio saic-radio-v">
          <input id="saic-order_comments_likes" name="saic_options[order_comments]" type="radio" value="likes" <?php checked('likes', $options['order_comments']); ?> />
          <label for="saic-order_comments_likes"><?php _e( 'Most voted first', 'SAIC' ); ?></label>
          <span class="saic-descrip-item"><?php _e( 'Sort comments by using the number of likes you have.', 'SAIC' ); ?></span>
        </div><!--.saic-radio-->

        </div><!--.saic-controls-->
      </fieldset>
      <div class="saic-line-sep"></div>

      <!-- Quién puede Comentar -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Who can comment?', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <input id="saic-only-registered" name="saic_options[only_registered]" type="checkbox" value="true" <?php if (isset($options['only_registered'])) { checked('true', $options['only_registered']); } ?> />
        <label for="saic-only-registered"><?php _e( 'Only registered users can comment', 'SAIC' ); ?></label>
        <br/>
				<p class="saic-descrip-item"></p>
        </div><!--.saic-controls-->
      </fieldset>

      <!-- Texto quién puede Comentar -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="saic-text-only-registered"><?php _e( 'Text for Only registered users can comment', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <input id="saic-text-only-registered" name="saic_options[text_only_registered]" type="text" value="<?php echo $options['text_only_registered']; ?>" />
				<p class="saic-descrip-item"><?php _e( 'If the user is not registered, a link is displayed to log, you can accompany with some text', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Disable reply comments','SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <div class="saic-radio saic-radio-h saic-float-l saic-5-box">
            <input id="saic-disable-reply-true" name="saic_options[disable_reply]" type="radio" value="true" <?php checked('true', $options['disable_reply']); ?> />
            <label for="saic-disable-reply-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h saic-float-l saic-5-box">
            <input id="saic-disable-reply-false" name="saic_options[disable_reply]" type="radio" value="false" <?php checked('false', $options['disable_reply']); ?> />
            <label for="saic-disable-reply-false"><?php _e( 'Not', 'SAIC' ); ?></label>

          </div><!--.saic-radio-->
          <br />
          <p class="saic-descrip-item"><?php _e( 'If enabled, then the reply comments will be disabled for all post/pages.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>

      <div class="saic-line-sep"></div>

      <!-- Carga de jQuery -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'How to load jQuery?', 'SAIC' ); ?></label>
          <p class="saic-descrip-item"><?php echo SAIC_PLUGIN_NAME;?> <?php _e( 'need jQuery to run, as you want to load it?', 'SAIC' ); ?></p>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <div class="saic-radio saic-radio-v">
            <input id="saic-jq-theme" name="saic_options[typejquery]" type="radio" value="current-theme" <?php checked('current-theme', $options['typejquery']); ?> />
					<label for="saic-jq-theme"><?php _e( 'Current Template jQuery', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( 'Use this option if your site has already loaded the jQuery library', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-v">
            <input id="saic-gojquery" name="saic_options[typejquery]" type="radio" value="google" <?php checked('google', $options['typejquery']); ?> />
					<label for="saic-gojquery"><?php _e( 'jQuery Google CDN', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-v">
            <input id="saic-jquery-plugin" name="saic_options[typejquery]" type="radio" value="jquery-plugin" <?php checked('jquery-plugin', $options['typejquery']); ?> />
					<label for="saic-jquery-plugin"><?php _e( 'jQuery Plugin', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( 'Jquery will load from the file included with the plugin', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
        </div><!--.saic-controls-->
      </fieldset>

      <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="saic-defaults"><?php _e( 'Reset options to default', 'SAIC' ); ?></label>
          <p class="saic-descrip-item"></p>

        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-defaults" name="saic_options[default_options]" type="checkbox" value="true" <?php if (isset($options['default_options'])) { checked('true', $options['default_options']); } ?> />
          <label for="saic-defaults"><span style="color:#333333;margin-left:3px;"><?php _e( 'Restore to default values', 'SAIC' ); ?></span></label>
          <p class="saic-descrip-item"><?php _e( 'Mark this option only if you want to return to the original settings of the plugin.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>

    </div><!--.saic-tab1-->


    <div id="saic-tab2" class="saic-tab-content">
      <!-- Paginación de Comentarios -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Pagination of comments', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-v">
            <input id="saic-jpages-true" name="saic_options[jpages]" type="radio" value="true" <?php checked('true', $options['jpages']); ?> />
            <label for="saic-jpages-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-v">
            <input id="saic-jpages-false" name="saic_options[jpages]" type="radio" value="false" <?php checked('false', $options['jpages']); ?> />
            <label for="saic-jpages-false"><?php _e( 'Not', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"></span>
          </div><!--.saic-radio-->

        </div><!--.saic-controls-->
      </fieldset>

      <!-- Número de Comentarios por Página -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Number of comments per page', 'SAIC' ); ?></label>
          <p class="saic-descrip-item"></p>

        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-num-comments-by-page" type="text" name="saic_options[num_comments_by_page]" value="<?php echo $options['num_comments_by_page']; ?>" />
          <p class="saic-descrip-item"><?php _e( 'Default value', 'SAIC' ); ?>: 10<br/><strong><?php _e( 'Note: ', 'SAIC' ); ?></strong><?php _e( 'If the total number of comments is less than the number of comments per page, the pager will not be displayed.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>
      <div class="saic-line-sep"></div>

      <!-- Activar Textarea Counter -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Character limiter', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-v">
            <input id="saic-text_counter-true" name="saic_options[text_counter]" type="radio" value="true" <?php checked('true', $options['text_counter']); ?> />
            <label for="saic-text_counter-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-v">
            <input id="saic-text_counter-false" name="saic_options[text_counter]" type="radio" value="false" <?php checked('false', $options['text_counter']); ?> />
            <label for="saic-text_counter-false"><?php _e( 'Not', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"></span>
          </div><!--.saic-radio-->
        </div><!--.saic-controls-->
      </fieldset>

      <!-- Número de Máximo de Caracteres -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Maximum number of characters for comment', 'SAIC' ); ?></label>
          <p class="saic-descrip-item"></p>

        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text_counter_num" type="text" name="saic_options[text_counter_num]" value="<?php echo $options['text_counter_num']; ?>" />
          <p class="saic-descrip-item"><?php _e( 'Default value', 'SAIC' ); ?>: 300.</p>
        </div><!--.saic-controls-->
      </fieldset>

      <div class="saic-line-sep"></div>

      <!-- Formulario de Comentarios -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Display comment form?', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-v">
            <input id="saic-display-form-true" name="saic_options[display_form]" type="radio" value="true" <?php checked('true', $options['display_form']); ?> />
            <label for="saic-display-form-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( 'It displays the form to add a comment next to the list of comments', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-v">
            <input id="saic-display-form-false" name="saic_options[display_form]" type="radio" value="false" <?php checked('false', $options['display_form']); ?> />
            <label for="saic-display-form-false"><?php _e( 'Not', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( 'It does not show the comments form', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->

        </div><!--.saic-controls-->
      </fieldset>

      <!-- Captcha -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Show the captcha to', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-h saic-4-box saic-float-l">
            <input id="saic-captcha-all" name="saic_options[display_captcha]" type="radio" value="all" <?php checked('all', $options['display_captcha']); ?> />
            <label for="saic-captcha-all"><?php _e( 'Show all', 'SAIC' ); ?></label>

          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h saic-2-box saic-float-l">
            <input id="saic-captcha-non-registered" name="saic_options[display_captcha]" type="radio" value="non-registered" <?php checked('non-registered', $options['display_captcha']); ?> />
            <label for="saic-captcha-non-registered"><?php _e( 'Only to non-registered users', 'SAIC' ); ?></label>

          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h saic-4-box saic-float-l saic-last">
            <input id="saic-captcha-not-show" name="saic_options[display_captcha]" type="radio" value="not-show" <?php checked('not-show', $options['display_captcha']); ?> />
            <label for="saic-captcha-not-show"><?php _e( 'Not show', 'SAIC' ); ?></label>

          </div><!--.saic-radio-->
          <p class="saic-descrip-item"><?php _e( 'It is important to use a captcha to give more security to your forms.', 'SAIC' ); ?></p>

        </div><!--.saic-controls-->
      </fieldset>

      <!-- Botones para insertar imagenes, video y enlaces -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Display buttons to insert images, videos, and links?', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-h">
            <input id="saic-display_media_btns-true" name="saic_options[display_media_btns]" type="radio" value="true" <?php checked('true', $options['display_media_btns']); ?> />
            <label for="saic-display_media_btns-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( '', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h">
            <input id="saic-display_media_btns-false" name="saic_options[display_media_btns]" type="radio" value="false" <?php checked('false', $options['display_media_btns']); ?> />
            <label for="saic-display_media_btns-false"><?php _e( 'Not', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( '', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
				<br/>
				<p style="padding-top:6px;"></p>

        </div><!--.saic-controls-->
      </fieldset>

      <!-- Like / Dislike Iconos -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Display Like/Dislike Icons?', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-h">
            <input id="saic-display_rating_btns-true" name="saic_options[display_rating_btns]" type="radio" value="true" <?php checked('true', $options['display_rating_btns']); ?> />
            <label for="saic-display_rating_btns-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( '', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h">
            <input id="saic-display_rating_btns-false" name="saic_options[display_rating_btns]" type="radio" value="false" <?php checked('false', $options['display_rating_btns']); ?> />
            <label for="saic-display_rating_btns-false"><?php _e( 'Not', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( '', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
				<br/>

        </div><!--.saic-controls-->
      </fieldset>

      <!-- Email Field -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Show Field "Email"', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-h">
            <input id="saic-display_email-true" name="saic_options[display_email]" type="radio" value="true" <?php checked('true', $options['display_email']); ?> />
            <label for="saic-display_email-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( '', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h">
            <input id="saic-display_email-false" name="saic_options[display_email]" type="radio" value="false" <?php checked('false', $options['display_email']); ?> />
            <label for="saic-display_email-false"><?php _e( 'Not', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( '', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
				<br/>
        </div><!--.saic-controls-->
      </fieldset>

      <!-- Website Field -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Show Field "Website"', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-radio saic-radio-h">
            <input id="saic-display_website-true" name="saic_options[display_website]" type="radio" value="true" <?php checked('true', $options['display_website']); ?> />
            <label for="saic-display_website-true"><?php _e( 'Yes', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( '', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h">
            <input id="saic-display_website-false" name="saic_options[display_website]" type="radio" value="false" <?php checked('false', $options['display_website']); ?> />
            <label for="saic-display_website-false"><?php _e( 'Not', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( '', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
				<br/>
				<p style="padding-top:2px;"></p>

        </div><!--.saic-controls-->
      </fieldset>

      <div class="saic-line-sep"></div>

      <!-- Texto del enlace Mostrar Comentarios -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Show comments link text', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-float-l saic-3-box">
          <input id="text_0_comments" type="text" name="saic_options[text_0_comments]" value="<?php echo $options['text_0_comments']; ?>" />
            <span class="saic-descrip-item saic-first"><?php _e( 'If the post has no comments', 'SAIC' ); ?></span>
          </div><!--.saic-3-box-->
          <div class="saic-float-l saic-3-box">
                 		<input id="text_1_comment" type="text" name="saic_options[text_1_comment]" value="<?php echo $options['text_1_comment']; ?>" />
            <span class="saic-descrip-item saic-first"><?php _e( 'If the post has 1 comment', 'SAIC' ); ?></span>
          </div><!--.saic-3-box-->
          <div class="saic-float-l saic-3-box saic-last">
          <input id="text_more_comments" type="text" name="saic_options[text_more_comments]" value="<?php echo $options['text_more_comments']; ?>" />
            <span class="saic-descrip-item saic-first"><?php _e( 'For more than one comment', 'SAIC' ); ?></span>
          </div><!--.saic-3-box-->

          <p class="saic-descrip-item"><?php _e( 'Use #N# to display the number of comments,  remove it if you don\'t want to show it.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>

      <!-- Icono del enlace Mostrar Comentarios -->
      <fieldset class="saic-control-group"  style="padding-top:2px;">
        <div class="saic-control-label">
          <label for="width_comments"><?php _e( 'The link icon', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <div class="saic-radio saic-radio-h saic-float-l">
            <input id="saic-icon-link-true" name="saic_options[icon-link]" type="radio" value="true" <?php checked('true', $options['icon-link']); ?> />
					<label for="saic-icon-link-true"><?php _e( 'Show icon', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h saic-float-l">
            <input id="saic-icon-link-false" name="saic_options[icon-link]" type="radio" value="false" <?php checked('false', $options['icon-link']); ?> />
					<label for="saic-icon-link-false"><?php _e( 'Not show icon', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"></span>
          </div><!--.saic-radio-->
          <p class="saic-descrip-item"><?php _e( 'You can hide or show the icon that appears next to the link to show all comments.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>
      <div class="saic-line-sep"></div>

      <!-- Formato de la fecha de los Comentarios -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Comments date format', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">

          <div class="saic-radio saic-radio-h saic-2-box saic-float-l">
            <input id="saic-date-format-true" name="saic_options[date_format]" type="radio" value="date_fb" <?php checked('date_fb', $options['date_format']); ?> />
					<label for="saic-date-format-true"><?php _e( 'Facebook-style format', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( 'E.g: 8 mins ago', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
          <div class="saic-radio saic-radio-h saic-2-box saic-float-l saic-last">
            <input id="saic-date-format-false" name="saic_options[date_format]" type="radio" value="date_wp" <?php checked('date_wp', $options['date_format']); ?> />
					<label for="saic-date-format-false"><?php _e( 'Wordpress default format', 'SAIC' ); ?></label>
            <span class="saic-descrip-item"><?php _e( 'E.g: 05/09/2013', 'SAIC' ); ?></span>
          </div><!--.saic-radio-->
          <p class="saic-descrip-item"><?php _e( 'Use the format of facebook makes more appealing to your comments.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>


      <div class="saic-line-sep"></div>

      <!-- Tamaño Máximo para las imágenes -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label><?php _e( 'Max width of images', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-float-l saic-5-box">
          <input id="saic-max_width_images" type="text" name="saic_options[max_width_images]" value="<?php echo $options['max_width_images']; ?>" />
          </div><!--.saic-3-box-->
          <div class="saic-float-l saic-9-box" style="padding-top:6px;">
                 		<input id="saic-unit_%_size_images" name="saic_options[unit_images_size]" type="radio" value="%" <?php checked('%', $options['unit_images_size']); ?> />
            <label for="saic-unit_%_size_images"><?php _e( '%', 'SAIC' ); ?></label>
          </div><!--.saic-3-box-->
          <div class="saic-float-l saic-9-box" style="padding-top:6px;">
          <input id="saic-unit_px_size_images" name="saic_options[unit_images_size]" type="radio" value="px" <?php checked('px', $options['unit_images_size']); ?> />
            <label for="saic-unit_px_size_images"><?php _e( 'px', 'SAIC' ); ?></label>
          </div><!--.saic-3-box-->

          <p class="saic-descrip-item"><?php _e( 'By default the maximum width of the images in the comments is 100%. If you want to change that value add it here.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>

      <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>


    </div><!--.saic-tab2-->

    <div id="saic-tab3" class="saic-tab-content">
      <!-- Ancho de la caja de Comentarios -->
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="width_comments"><?php _e( 'Width of the container of the comments', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
        <div class="saic-float-l saic-5-box">
          <input id="width_comments" type="text" name="saic_options[width_comments]" value="<?php echo $options['width_comments']; ?>" />
          </div><!--.saic-3-box-->
          <div class="saic-float-l saic-2-box saic-last" style="padding-top:6px;">
          <input id="saic-border" name="saic_options[border]" type="checkbox" value="false" <?php if (isset($options['border'])) { checked('false', $options['border']); } ?> />
          <label for="saic-border"><?php _e( 'Remove the container edge', 'SAIC' ); ?></label>
          </div><!--.saic-3-box-->

          <p class="saic-descrip-item"><?php _e( 'Minimum width 180px. It adds the width in pixels of the box containing the comments. If you leave blank are shall refer to the width of the parent div.', 'SAIC' ); ?></p>
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="saic-theme"><?php _e( 'Comments Box Style', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <select name="saic_options[theme]" id="saic-theme">
            <option value='default' <?php selected('default', $options['theme']); ?> style="padding:2px 8px;" ><?php _e( 'Default', 'SAIC' ); ?></option>
            <option value='facebook' <?php selected('facebook', $options['theme']); ?> style="padding:2px 8px;" ><?php _e( 'Facebook', 'SAIC' ); ?></option>
            <option value='golden' <?php selected('golden', $options['theme']); ?> style="padding:2px 8px;" ><?php _e( 'Golden', 'SAIC' ); ?></option>
            <option value='dark' <?php selected('dark', $options['theme']); ?> style="padding:2px 8px;" ><?php _e( 'Dark', 'SAIC' ); ?></option>
            <option value='custom' <?php selected('custom', $options['theme']); ?> style="padding:2px 8px;" ><?php _e( 'Custom', 'SAIC' ); ?></option>
          </select>
          <span class="saic-descrip-item"><?php _e( 'Select "Custom" to use the below custom colors.', 'SAIC' ); ?></span>

        </div><!--.saic-controls-->
      </fieldset>

      <div class="saic-line-sep"></div>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_background_box"><?php _e( 'Main Background', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_background_box" type="text" name="saic_options[css_background_box]" class="saic-colorpicker" value="<?php echo $options['css_background_box']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Main background the comment box.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_border_color"><?php _e( 'Borders', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_border_color" type="text" name="saic_options[css_border_color]" class="saic-colorpicker" value="<?php echo $options['css_border_color']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Border for input, textarea, comments.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_text_color"><?php _e( 'Text', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_text_color" type="text" name="saic_options[css_text_color]" class="saic-colorpicker" value="<?php echo $options['css_text_color']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Text color of comments.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_link_color"><?php _e( 'Text links', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_link_color" type="text" name="saic_options[css_link_color]" class="saic-colorpicker" value="<?php echo $options['css_link_color']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Text color of links.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_link_color_hover"><?php _e( 'Text links hover', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_link_color_hover" type="text" name="saic_options[css_link_color_hover]" class="saic-colorpicker" value="<?php echo $options['css_link_color_hover']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Text color of links on hover.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_text_color_secondary"><?php _e( 'Date comment', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_text_color_secondary" type="text" name="saic_options[css_text_color_secondary]" class="saic-colorpicker" value="<?php echo $options['css_text_color_secondary']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Text color for the date of each comment.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_background_input"><?php _e( 'Input Background', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_background_input" type="text" name="saic_options[css_background_input]" class="saic-colorpicker" value="<?php echo $options['css_background_input']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Background color for input and textarea.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_background_button"><?php _e( 'Submit button', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_background_button" type="text" name="saic_options[css_background_button]" class="saic-colorpicker" value="<?php echo $options['css_background_button']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Background color for the submit button.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_background_button_hover"><?php _e( 'Submit button hover', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_background_button_hover" type="text" name="saic_options[css_background_button_hover]" class="saic-colorpicker" value="<?php echo $options['css_background_button_hover']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Background color for the submit button on hover.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_text_color_button"><?php _e( 'Text submit button', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_text_color_button" type="text" name="saic_options[css_text_color_button]" class="saic-colorpicker" value="<?php echo $options['css_text_color_button']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Text color for the submit button.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_rating_color"><?php _e( 'Thumbs rating', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_rating_color" type="text" name="saic_options[css_rating_color]" class="saic-colorpicker" value="<?php echo $options['css_rating_color']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Color for the icons "like/dislike".', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_rating_color_hover"><?php _e( 'Thumbs rating hover', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_rating_color_hover" type="text" name="saic_options[css_rating_color_hover]" class="saic-colorpicker" value="<?php echo $options['css_rating_color_hover']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Color for the icons "like/dislike" on hover', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_rating_positive_color"><?php _e( 'Counter positive rating', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_rating_positive_color" type="text" name="saic_options[css_rating_positive_color]" class="saic-colorpicker" value="<?php echo $options['css_rating_positive_color']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Color positive number.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_rating_negative_color"><?php _e( 'Counter negative rating', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_rating_negative_color" type="text" name="saic_options[css_rating_negative_color]" class="saic-colorpicker" value="<?php echo $options['css_rating_negative_color']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Color negative number.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_success_color"><?php _e( 'Success Message', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_success_color" type="text" name="saic_options[css_success_color]" class="saic-colorpicker" value="<?php echo $options['css_success_color']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Text color of success message.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="css_error_color"><?php _e( 'Error Message', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="css_error_color" type="text" name="saic_options[css_error_color]" class="saic-colorpicker" value="<?php echo $options['css_error_color']; ?>" />
          <span class="saic-descrip-item"><?php _e( 'Text color of error message.', 'SAIC' ); ?></span>
        </div><!--.saic-controls-->
      </fieldset>

    </div><!--.saic-tab3-->

    <div id="saic-tab4" class="saic-tab-content saic-translation">
     	<fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Write comment', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-write-comment" type="text" name="saic_options[text-write-comment]" value="<?php echo $options['text-write-comment']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Send', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-send" type="text" name="saic_options[text-send]" value="<?php echo $options['text-send']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Reply', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-reply" type="text" name="saic_options[text-reply]" value="<?php echo $options['text-reply']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Insert image', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-insert-image" type="text" name="saic_options[text-insert-image]" value="<?php echo $options['text-insert-image']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Insert video', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-insert-video" type="text" name="saic_options[text-insert-video]" value="<?php echo $options['text-insert-video']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Insert link', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-insert-link" type="text" name="saic_options[text-insert-link]" value="<?php echo $options['text-insert-link']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Thanks for your comment!', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-thanks-comment" type="text" name="saic_options[text-thanks-comment]" value="<?php echo $options['text-thanks-comment']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Thanks for answering the comment!', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-thanks-reply-comment" type="text" name="saic_options[text-thanks-reply-comment]" value="<?php echo $options['text-thanks-reply-comment']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'You might have left one of the fields blank, or duplicate comments', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-duplicate-comment" type="text" name="saic_options[text-duplicate-comment]" value="<?php echo $options['text-duplicate-comment']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Accept', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-accept" type="text" name="saic_options[text-accept]" value="<?php echo $options['text-accept']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Cancel', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-cancel" type="text" name="saic_options[text-cancel]" value="<?php echo $options['text-cancel']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Check video', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-check-video" type="text" name="saic_options[text-check-video]" value="<?php echo $options['text-check-video']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Like', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-like" type="text" name="saic_options[text-like]" value="<?php echo $options['text-like']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Unlike', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-unlike" type="text" name="saic_options[text-unlike]" value="<?php echo $options['text-unlike']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Comments are closed', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-comments-closed" type="text" name="saic_options[text-comments-closed]" value="<?php echo $options['text-comments-closed']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Name field', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-name" type="text" name="saic_options[text-name]" value="<?php echo $options['text-name']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Email field', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-email" type="text" name="saic_options[text-email]" value="<?php echo $options['text-email']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <fieldset class="saic-control-group">
        <div class="saic-control-label">
          <label for="group-name"><?php _e( 'Website field', 'SAIC' ); ?></label>
        </div><!--.saic-control-label-->
        <div class="saic-controls">
          <input id="saic-text-website" type="text" name="saic_options[text-website]" value="<?php echo $options['text-website']; ?>" />
        </div><!--.saic-controls-->
      </fieldset>
      <div class="saic-line-sep"></div>

    </div><!--.saic-tab4-->

    <div id="saic-tab5" class="saic-tab-content saic-help">
      <h3><?php _e( 'How to display the '.SAIC_PLUGIN_NAME.'?', 'SAIC' ); ?></h3>
      <p><?php echo sprintf(__( 'Check Yes the box %s "Insert the comments box automatically" %s in this options panel. %s If you do not want to automatically display, insert %s where you want to show comments. Or use %sshortcodes%s', 'SAIC' ), '<strong>', '</strong>', '<br/>', '<strong>&lt;?php if(function_exists("display_saic")) { echo display_saic();} ?&gt;</strong>', '<a href="http://ajax-insert-comments.info/how-to-insert-using-shortcode/" target="_blank">', '</a>' ); ?></p>
      <div class="saic-line-sep"></div>
      <p class="saic-easy"><?php _e( 'This plugin works super easy, I do not think that you need more help!', 'SAIC' ); ?></p>
    </div><!--.saic-tab5-->

  </div><!--.saic-tab-container-->

  <fieldset id="saic-item-submit" class="saic-control-group" style="padding:0">
    <div class="saic-control-label">
        <p class="submit">
          <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'SAIC') ?>" />
        </p>
    </div><!--.saic-control-label-->
    <div class="saic-controls">
    </div><!--.saic-controls-->
  </fieldset>
</form>

</div><!--.wrap-->

<?php
?>