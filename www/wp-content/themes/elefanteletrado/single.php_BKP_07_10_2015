<?php get_header(); ?>
<?php get_template_part('content','top');?>
<?php
global $cupid_data,$cupid_archive_loop;

$use_custom_layout = get_post_meta(get_the_ID(),'use-custom-layout',true);
$archive_layout = get_post_meta(get_the_ID(),'page-layout',true);

if (!isset($archive_layout) || empty($archive_layout) || $archive_layout == 'none' || $use_custom_layout == '0') {
    $archive_layout = $cupid_data['post-archive-layout'];
}

$class_col = 'col-md-12';
if ($archive_layout == 'left-sidebar' || $archive_layout == 'right-sidebar' ){
    $class_col = 'col-md-9';
}

if ($archive_layout == 'left-sidebar') {
    $class_col .= ' col-md-push-3';
}

if (get_post_format() == 'audio') {
    wp_enqueue_style( 'cupid-jplayer-pixel-industry', get_template_directory_uri() . '/assets/plugins/jquery.jPlayer/skin/cupid/skin.css', array(), true );
    wp_enqueue_script( 'cupid-jplayer', get_template_directory_uri() . '/assets/plugins/jquery.jPlayer/jquery.jplayer.min.js', array( 'jquery' ), false, true );
}
?>
<main role="main" class="site-content-archive">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="<?php echo esc_attr($class_col); ?>">
                <div class="blog-wrapper">
                    <div class="blog-nav">
                        <?php cupid_the_breadcrumb(); ?>
                    </div>
                    <div  class="blog-inner blog-single clearfix">
                        <?php
                        if ( have_posts() ) :
                            // Start the Loop.
                            while ( have_posts() ) : the_post();
                                /*
                                 * Include the post format-specific template for the content. If you want to
                                 * use this in a child theme, then include a file called called content-___.php
                                 * (where ___ is the post format) and that will be used instead.
                                 */
                                get_template_part( 'content', get_post_format() );
                            endwhile;
                        else :
                            // If no content, include the "No posts found" template.
                            get_template_part( 'content', 'none' );
                        endif;
                        ?>
                    </div>
                </div>
                <div class="row entry-tag-social">
                    <?php the_tags('<div class="entry-tag-wrapper"><div class="entry-tag"><div class="entry-tag-inner"><span>'. __("Tags: ",'cupid') .'</span>', ', ', '</div></div></div>' ); ?>
                    <?php cupid_post_social(); ?>
                </div>
                <?php comments_template(); ?>
            </div>
            <?php if ($archive_layout == 'left-sidebar') :
                get_sidebar('left');
            endif;
            ?>
            <?php if ($archive_layout == 'right-sidebar') :
                get_sidebar();
            endif;
            ?>
        </div>
    </div>
</main>


<?php get_footer(); ?>

