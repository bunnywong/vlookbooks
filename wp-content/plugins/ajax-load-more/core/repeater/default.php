<div<?php if (! has_post_thumbnail() ) { echo ' class="no-img item-wrapper"'; }else{echo ' class="item-wrapper"';} ?>>
   <?php if ( has_post_thumbnail() ) { 
      the_post_thumbnail(array(150,150));
   }?>
   <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
   <p class="entry-meta">
       <?php the_time("F d, Y"); ?>
   </p>
   <?php the_excerpt(); ?> 
<?php echo do_shortcode('[simple-comments post_id="'.get_the_ID().'" style="default" get="20" border="true" order="DESC" auto_load="true"]'); ?>
</div>