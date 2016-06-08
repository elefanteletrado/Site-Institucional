<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Cupid
 * @since Cupid 1.0
 */
?>
<?php

global $cupid_archive_loop;
if (isset($cupid_archive_loop['image-size'])) {
    $size = $cupid_archive_loop['image-size'];
} else {
    $size = 'cupid_medium_thumbnail';
}
if (is_single()) {
    $size = 'full';
}
$class = array();
$class[]= "clearfix";
?>
<article  id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
    <div class="entry-wrapper clearfix">
        <?php
        $thumbnail = cupid_post_thumbnail($size);
        if (!empty($thumbnail)) : ?>
            <div class="entry-image-wrapper">
                <?php echo wp_kses_post($thumbnail); ?>
            </div>
        <?php endif; ?>
        <div class="entry-content-wrapper clearfix">
            <div class="entry-content-container clearfix">
                <div class="entry-categories">
                    <?php the_category(); ?>
                </div>
                <h3 class="entry-title">
                    <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="entry-meta">
                    <?php cupid_post_meta(); ?>
                </div>
                <?php if (!is_single()) : ?>
                    <div class="entry-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="entry-read-more">
                        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e("Leia mais","cupid"); ?>"><?php _e("Leia mais","cupid"); ?></a>
                    </div>

                <?php else : ?>
                    <div class="entry-content clearfix">
                        <?php the_content(); ?>
                    </div>

                    <?php wp_link_pages( array(
                        'before'      => '<div class="cupid-page-links"><span class="cupid-page-links-title">' . __( 'Pages:', 'cupid' ) . '</span>',
                        'after'       => '</div>',
                        'link_before' => '<span class="cupid-page-link">',
                        'link_after'  => '</span>',
                    ) ); ?>

                    <?php cupid_post_nav(); ?>


                <?php endif; ?>
            </div>
        </div>
    </div>
</article>