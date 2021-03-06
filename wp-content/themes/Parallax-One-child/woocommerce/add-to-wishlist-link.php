<?php global $woocommerce_wishlist, $add_to_wishlist_args, $product; ?>
<input type="hidden" name="wlid" id="wlid" />
<input type="hidden" name="add-to-wishlist-type" value="<?php echo $product->product_type; ?>" />
<input type="hidden" name="wl_from_single_product" value="<?php echo is_product() ? '1' : '0'; ?>" />

<div id="wl-wrapper" class="woocommerce wl-button-wrap wl-row wl-clear <?php echo $product->is_type('variable') ? 'hide' : ''; ?>" >
  <a href="" data-productid="<?php echo $product->id; ?>" data-listid="<?php echo $add_to_wishlist_args['single_id']; ?>" class="<?php echo implode(' ', $add_to_wishlist_args['btn_class']); ?>">
    <?php echo apply_filters('woocommerce_wishlist_add_to_wishlist_text', WC_Wishlists_Settings::get_setting('wc_wishlist_button_text', 'Add to wishlist'), $product->product_type); ?>
  </a>

	<?php if (woocommerce_wishlists_get_wishlists_for_product($product->id)) : ?>
		<div class="wl-already-in">
			<?php _e('This item is already in one of your wishlists', 'wc_wishlist'); ?>
			<ul>
				<?php foreach (woocommerce_wishlists_get_wishlists_for_product($product->id) as $list_id) : ?>
					<li>
						<a href="<?php echo WC_Wishlists_Wishlist::get_the_url_edit($list_id); ?>" title="<?php echo get_the_title($list_id); ?>"><?php echo get_the_title($list_id); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</div>

<?php if ($product->product_type != 'external') : ?>
<script type="text/javascript">
	window.woocommerce_wishlist_add_to_wishlist_url = "<?php echo esc_url( add_query_arg(array('add-to-wishlist-itemid' => $product->id), $product->add_to_cart_url()) ); ?>";
</script>
<?php else : ?>
<script type="text/javascript">
	window.woocommerce_wishlist_add_to_wishlist_url = "<?php echo esc_url( add_query_arg(array('add-to-wishlist-itemid' => $product->id) ) ); ?>";
</script>
<?php endif; ?>
