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
$class = array();
$class[]= "clearfix";
?>
<article  id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
    <div class="entry-wrapper clearfix">
        <div class="entry-content-wrapper clearfix">
            <div class="entry-content-container clearfix">
                <div class="entry-categories">
                    <?php the_category(); ?>
                </div>
                <h3 class="entry-title">
                    <a href="<?php echo esc_url( cupid_get_link_url() ); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="entry-meta">
                    <?php cupid_post_meta(); ?>
                </div>

                <?php if (!is_single()) : ?>
                <div class="entry-content-link entry-content">
                    <?php the_content(); ?>
                </div>
                <?php else : ?>
                    <div class="entry-content">
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

