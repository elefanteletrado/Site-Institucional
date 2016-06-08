<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/2/15
 * Time: 10:06 AM
 */
$cat = get_queried_object();
$page_sub_title = '';

if ($cat && property_exists( $cat, 'term_id' )) {
    $term_id = $cat->term_id;
    $page_sub_title =  strip_tags(term_description());
}
?>
<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
<section class="page-title-wrapper">
    <div class="container clearfix">
        <div class="cupid-heading">
            <h2><?php woocommerce_page_title(); ?></h2>
            <?php if (!empty($page_sub_title)) : ?>
                <span><?php echo esc_html($page_sub_title); ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>