<div<?php if (! has_post_thumbnail() ) { echo ' class="no-img item-wrapper"'; }else{echo ' class="item-wrapper"';} ?>>

  <div class="info"><strong><?php the_author(); ?></strong><br>@<?php the_time("F d, Y"); ?></div>

   <div class="content">
     <?php if ( has_post_thumbnail() ) {
        the_post_thumbnail(array(150,150));
     }?>
    <?php the_excerpt(); ?>
  </div>
  <?php echo do_shortcode('[simple-comments post_id="'.get_the_ID().'" style="default" get="20" border="true" order="DESC" auto_load="true"]'); ?>
</div>
