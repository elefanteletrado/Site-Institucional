<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );
$index = 0;
if ( ! empty( $tabs ) ) : ?>

    <div class="panel-group" id="woocommerce-tabs" role="tablist" aria-multiselectable="true">
        <?php foreach ( $tabs as $key => $tab ) : ?>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading<?php echo esc_attr($key);?>">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#woocommerce-tabs" href="#<?php echo esc_attr($key) ?>" aria-expanded="<?php echo esc_attr($index == 0 ? 'true' : 'false');?>" aria-controls="<?php echo esc_attr($key) ?>">
                            <?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?>
                        </a>
                    </h4>
                </div>
                <div id="<?php echo esc_attr($key) ?>" class="panel-collapse collapse<?php echo esc_attr($index == 0 ? ' in' : '');?>" role="tabpanel" aria-labelledby="heading<?php echo esc_attr($key); ?>">
                    <div class="panel-body">
                        <?php call_user_func( $tab['callback'], $key, $tab ) ?>
                    </div>
                </div>
            </div>
            <?php $index++; ?>

        <?php endforeach; ?>
    </div>
<?php endif; ?>
