<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

global $woocommerce_loop,$cupid_product_layout;
if (empty( $woocommerce_loop['columns'] ) ) {
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4);
}
$class = array();
$class[] = 'product-listing woocommerce clearfix';
if (isset($cupid_product_layout) && $cupid_product_layout == 'slider') {
    $class[] = 'product-slider';
} else {
    $class[] = 'columns-' . $woocommerce_loop['columns'];
}
$class[] = 'product_animated';
$class_names = join(' ',$class);

?>

<div data-col="<?php echo esc_attr($woocommerce_loop['columns']); ?>" class="<?php echo esc_attr($class_names); ?>">
    <?php if (isset($cupid_product_layout) && ($cupid_product_layout  == 'slider')) : ?>
    <div class="owl-carousel" data-plugin-options='{"items": <?php echo esc_attr($woocommerce_loop['columns']); ?>, "pagination" : false, "navigation" : true }'>
        <?php endif; ?>

