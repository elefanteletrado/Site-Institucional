<?php
global $cupid_data,$cupid_archive_loop;

$archive_layout = $cupid_data['post-archive-layout'];


$class_col = 'col-md-12';
$blog_col = '4';

if ($archive_layout == 'left-sidebar' || $archive_layout == 'right-sidebar' ){
    $class_col = 'col-md-9';
    $blog_col = '3';
}

if ($archive_layout == 'left-sidebar') {
    $class_col .= ' col-md-push-3';
}


$post_archive_paging_style = $cupid_data['post-archive-paging-style'];

wp_enqueue_style( 'cupid-jplayer-pixel-industry', get_template_directory_uri() . '/assets/plugins/jquery.jPlayer/skin/cupid/skin.css', array(), true );
wp_enqueue_script( 'cupid-jplayer', get_template_directory_uri() . '/assets/plugins/jquery.jPlayer/jquery.jplayer.min.js', array( 'jquery' ), '', true );

if(!isset($_COOKIE['cupid-blog-style'])) {
  $blog_style= 'blog-list';
} else {
    $blog_style =  $_COOKIE['cupid-blog-style'];
}

if (is_search()) {
    $blog_style= 'blog-list';
}

?>
<main role="main" class="site-content-archive">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="<?php echo esc_attr($class_col); ?>">
                <div class="blog-wrapper">
                    <div class="blog-nav">
                        <?php cupid_the_breadcrumb(); ?>
                        <?php if (!is_search() ) : ?>
                        <div class="blog-switcher-wrapper">
                            <a data-rel="blog-list" data-unrel="blog-grid" class="blog-switcher <?php echo esc_attr($blog_style == 'blog-list' ? 'blog-switcher-active' : '')  ?>" href="javascript:;"><?php _e("Lista","cupid"); ?><i class="fa fa-th-list"></i></a>
                            <a data-rel="blog-grid" data-unrel="blog-list" class="blog-switcher <?php echo esc_attr( $blog_style == 'blog-grid' ? 'blog-switcher-active' : '') ?>" href="javascript:;"><?php _e("Blocos","cupid"); ?><i class="fa fa-th-large"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div data-hr="true" data-col="<?php echo esc_attr($blog_col); ?>" class="blog-inner <?php echo esc_attr($blog_style);?> blog-col-<?php echo esc_attr($blog_col); ?>  clearfix">
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
                    <?php
                    global $wp_query;
                    if ( $wp_query->max_num_pages > 1 ) :
                    ?>
                    <div class="blog-paging-wrapper blog-paging-<?php echo esc_attr($post_archive_paging_style); ?>">
                        <div class="blog-paging-inner">
                    <?php
                    switch($post_archive_paging_style) {
                        case 'load-more':
                            cupid_paging_load_more();
                            break;
                        case 'infinite-scroll':
                            cupid_paging_infinitescroll();
                            break;
                        default:
                            echo cupid_paging_nav();
                            cupid_paging_load_more();
                            break;
                    }
                    ?>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
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

