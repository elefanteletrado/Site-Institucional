<?php
/**
 * Product Loop End
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $cupid_product_layout;
?>
<?php if (isset($cupid_product_layout) && ($cupid_product_layout  == 'slider')) : ?>
    </div>
<?php endif; ?>
    </div>
<?php cupid_woocommerce_reset_loop(); ?>