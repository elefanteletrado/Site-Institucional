<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<?php get_template_part('content','top');?>
<main role="main" class="site-content-product-single">
    <div class="container clearfix">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php wc_get_template_part( 'content', 'single-product' ); ?>
        <?php endwhile; // end of the loop. ?>
    </div>
</main>
<?php get_footer(); ?>
