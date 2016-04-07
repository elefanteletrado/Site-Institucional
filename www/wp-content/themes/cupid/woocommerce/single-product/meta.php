<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

$weight = $product->get_weight();
$dimensions = $product->get_dimensions();


?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span>.</span>

	<?php endif; ?>

    <span class="product-stock-status-wrapper"><label><?php _e('Availability:','cupid') ?></label> <span class="product-stock-status" itemprop="stock"><?php echo ($product->is_in_stock()) ? __('In Stock','woocommerce') : __( 'Out Of Stock', 'woocommerce' ); ?></span></span>

    <?php if (!empty($dimensions)) : ?>
        <span><label><?php _e("Size:",'cupid'); ?></label><span> <?php echo esc_html($product->get_dimensions());?></span></span>
    <?php endif; ?>

    <?php if (!empty($weight)) : ?>
        <span><label><?php _e("Shipping Weight:",'cupid'); ?></label><span> <?php echo esc_html($weight) . ' ' .get_option( 'woocommerce_weight_unit' ) ?></span></span>
    <?php endif; ?>

	<?php echo $product->get_categories( ', ', '<span class="posted_in"><label>' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' </label>', '.</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as"><label>' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' </label>', '.</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
