<?php
/**
 * Single Product Sale Flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$sale_percent = 0;
if ($product->is_on_sale()&& $product->product_type != 'grouped') {
    if ($product->product_type == 'variable') {
        $available_variations =  $product->get_available_variations();
        for ($i = 0; $i < count($available_variations); ++$i) {
            $variation_id = $available_variations[$i]['variation_id'];
            $variable_product1 = new WC_Product_Variation( $variation_id );
            $regular_price = $variable_product1->get_regular_price();
            $sales_price = $variable_product1->get_sale_price();
            $price = $variable_product1->get_price();
            if ( $sales_price != $regular_price && $sales_price == $price ) {
                $percentage= round((( ( $regular_price - $sales_price ) / $regular_price ) * 100),1) ;
                if ($percentage > $sale_percent) {
                    $sale_percent = $percentage;
                }
            }
        }
    } else {
        $sale_percent = round((( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100),1) ;
    }
}
?>

<?php if ( $sale_percent > 0 ) : ?>
    <div class="product-item-feature">
        <?php echo apply_filters( 'woocommerce_sale_flash', '<div class="on-sale"><span>-' . $sale_percent . '%</span></div>', $post, $product ); ?>
    </div>
<?php endif; ?>

