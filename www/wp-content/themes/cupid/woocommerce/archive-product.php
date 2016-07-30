<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $cupid_data,$woocommerce_loop;

$archive_layout = isset($_GET['layout']) ? $_GET['layout'] : '' ;
$layouts = array('full-content','left-sidebar','right-sidebar');
if (!in_array($archive_layout,$layouts)) {
    $archive_layout = isset($cupid_data['product-archive-layout']) ? $cupid_data['product-archive-layout'] : 'left-sidebar' ;
}

$class_col = 'col-md-12';
$woocommerce_loop['columns'] = 4;
if ($archive_layout == 'left-sidebar' || $archive_layout == 'right-sidebar' ){
    $class_col = 'col-md-9';
    $woocommerce_loop['columns'] = 3;
}
if ($archive_layout == 'left-sidebar') {
    $class_col .= ' col-md-push-3';
}
get_header(); ?>
<?php get_template_part('archive-product','top') ?>
<main role="main" class="site-content-product-archive">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="<?php echo esc_attr($class_col); ?>">
                <div class="product-wrapper clearfix">
                    <?php if ( have_posts() ) : ?>
                        <div class="category-filter clearfix">
                            <?php
                            /**
                             * woocommerce_before_shop_loop hook
                             *
                             * @hooked woocommerce_result_count - 20
                             * @hooked woocommerce_catalog_ordering - 30
                             */
                            do_action( 'woocommerce_before_shop_loop' );
                            ?>
                        </div>
                        <?php woocommerce_product_loop_start(); ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php wc_get_template_part( 'content', 'product' ); ?>

                        <?php endwhile; // end of the loop. ?>

                        <?php woocommerce_product_loop_end(); ?>

                        <?php
                        /**
                         * woocommerce_after_shop_loop hook
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                        do_action( 'woocommerce_after_shop_loop' );
                        ?>
                    <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
                        <?php wc_get_template( 'loop/no-products-found.php' ); ?>
                    <?php endif; ?>

                </div>
            </div>
            <?php
            if ($archive_layout == 'left-sidebar') {
                get_sidebar('shop-left');
            }
            if ($archive_layout == 'right-sidebar') {
                get_sidebar('shop');
            }
            ?>
        </div>
    </div>
    <?php get_template_part('el-templates/section-contact'); ?>
</main>
<?php get_footer(); ?>
