<?php
global $cupid_product_layout;
if ( ! function_exists( 'cupid_woocommerce_reset_loop' ) ) {
    /**
     * Reset the loop's index and columns when we're done outputting a product loop.
     *
     * @subpackage	Loop
     */
    function cupid_woocommerce_reset_loop() {
        global $cupid_product_layout;
        $cupid_product_layout = '';
    }
}

add_filter('loop_shop_per_page', 'cupid_show_products_per_page' );
function cupid_show_products_per_page() {
    $page_size = isset($_GET['page_size'] ) ? wc_clean($_GET['page_size']) : 12;
    return $page_size;
}

if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) :
    /**
     * Get the product thumbnail for the loop.
     *
     * @access public
     * @subpackage	Loop
     * @return void
     */
    function woocommerce_template_loop_product_thumbnail() {
        global $product;
        $attachment_ids = $product->get_gallery_attachment_ids();
        $secondary_image = '';
        if ( $attachment_ids ) {
            $secondary_image_id = $attachment_ids['0'];
            $secondary_image = wp_get_attachment_image($secondary_image_id, apply_filters( 'shop_catalog', 'shop_catalog' ));
        }
        ?>
        <div class="product-thumb-container">
            <?php if (has_post_thumbnail()) : ?>
                <div class="product-thumb-primary">
                    <?php echo woocommerce_get_product_thumbnail(); ?>
                </div>
            <?php if (!empty( $secondary_image)) : ?>
                <div class="product-thumb-secondary">
                    <?php echo wp_kses_post($secondary_image); ?>
                </div>
            <?php endif; ?>
        <?php elseif(!empty($secondary_image)) : ?>
            <div class="product-thumb-primary">
                <?php echo wp_kses_post($secondary_image); ?>
            </div>
        <?php endif; ?>
        </div>
    <?php
    }
endif;

add_action( 'woocommerce_after_shop_loop_item_title', 'cupid_woocommerce_template_loop_title', 9 );
if ( ! function_exists( 'cupid_woocommerce_template_loop_title' ) ) {

    /**
     * Get the product price for the loop.
     *
     * @subpackage	Loop
     */
    function cupid_woocommerce_template_loop_title() {
        wc_get_template( 'loop/title.php' );
    }
}

add_filter( 'woocommerce_output_related_products_args', 'cupid_related_products_args' );
function cupid_related_products_args( $args ) {
    $args['posts_per_page'] = 8; // 4 related products
    return $args;
}

function cupid_product_search_form( $form ) {
    $form =  '<form role="search" class="cupid-search-form" method="get" id="searchform" action="' . home_url( '/' ) . '">
                <input type="text" value="' . get_search_query() . '" name="s" id="s"  placeholder="'.__( 'Search for products', 'woocommerce' ).'">
                <button type="submit"><i class="fa fa-search"></i></button>
                <input type="hidden" name="post_type" value="product" />
     		</form>';
    return $form;
}
add_filter( 'get_product_search_form', 'cupid_product_search_form' );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs',10);
add_action('woocommerce_single_product_summary','woocommerce_output_product_data_tabs',55);

add_filter('woocommerce_product_description_heading','cupid_product_description_heading');
function cupid_product_description_heading() {
    return '';
}

/*cart*/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals');
add_action('woocommerce_before_cart_totals','woocommerce_shipping_calculator',5);