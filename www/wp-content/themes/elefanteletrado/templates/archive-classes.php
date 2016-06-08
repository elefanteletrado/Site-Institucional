<?php
global $cupid_data,$cupid_archive_loop;


$column = 4;
$item_col = 'classes-col-3';
$class_col = 'col-md-12';
if (function_exists('dynamic_sidebar')&& is_active_sidebar('archive-classes-left-sidebar')){
    $column = 3;
    $item_col = 'classes-col-4';
    $class_col = 'col-md-9';
}

if(!isset($_COOKIE['cupid-classes-style'])) {
    $classes_style= 'grid';
} else {
    $classes_style =  $_COOKIE['cupid-classes-style'];
}
$image_size ='thumbnail-350x350';
global $wp_query;
?>
<main role="main" class="site-content-archive">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="<?php echo esc_attr($class_col)?>" >
                <div class="archive-cupid-class">
                    <div class="classes-wrapper">
                        <div class="classes-nav">
                            <div class="classes-switcher-wrapper">
                                <a data-rel="grid" data-unrel="list" class="classes-switcher <?php echo esc_attr($classes_style == 'grid' ? 'classes-switcher-active' : '')  ?>" href="javascript:;"><i class="fa fa-th-large"></i><?php _e("Grid","cupid"); ?></a>
                                <a data-rel="list" data-unrel="grid" class="classes-switcher <?php echo esc_attr( $classes_style == 'list' ? 'classes-switcher-active' : '') ?>" href="javascript:;"><i class="fa fa-th-list"></i><?php _e("List","cupid"); ?></a>
                            </div>
                            <div class="classes-search">
                                    <span class="keyword-wrapper">
                                        <input type="text" class="keyword" id="keyword_classes" autocomplete=off>
                                        <span><i class="fa fa-close" ></i></span>
                                    </span>
                                    <button type="submit" id="bt_search"><i class="fa fa-search"></i></button>
                            </div>

                        </div>

                        <div class="classes-inner <?php echo esc_attr($classes_style) ?>" data-col="<?php echo esc_attr($column) ?>">
                        <?php
                        $index = 1;
                        if ( have_posts() ) :
                            // Start the Loop.
                            while ( have_posts() ) : the_post();
                                $month_old = get_post_meta( get_the_ID(), 'month-olds', false );
                                $class_size = get_post_meta( get_the_ID(), 'class-size', false );
                                $img = '';
                                if( has_post_thumbnail()){
                                    $img = get_the_post_thumbnail(get_the_ID(),$image_size);
                                }
                                ?>
                                <div class="classes-item  <?php echo esc_attr($item_col)?>">
                                    <div class="thumbnail-wrap">
                                        <?php echo wp_kses_post($img) ?>
                                    </div>
                                    <div class="content-wrap">
                                        <h6><a href="<?php echo esc_url(get_permalink())?>" title="<?php echo get_the_title() ?>"><?php echo get_the_title() ?></a></h6>
                                        <div class="excerpt"><?php echo get_the_excerpt() ?></div>
                                    </div>
                                </div>
                                <?php if($index%$column==0 || $classes_style=='list') {?>
                                    <hr class="separate-line" />
                                <?php } ?>
                                <?php
                                $index++;
                            endwhile;
                            wp_reset_postdata();
                        else :
                            ?>
                            <div class="no-post">
                                <?php _e('No posts found','cupid'); ?>
                            </div>
                        <?php
                            endif;
                        ?>
                        </div>
                        <?php cupid_paging_load_more(); ?>
                    </div>


                </div>
            </div>
            <div class="col-md-3 sidebar">
                <div class="primary-sidebar">
                    <?php if (function_exists('dynamic_sidebar')){
                        dynamic_sidebar('archive-classes-left-sidebar');
                    } else { get_sidebar(); } ?>
                </div>
            </div>

        </div>
    </div>
</main>

