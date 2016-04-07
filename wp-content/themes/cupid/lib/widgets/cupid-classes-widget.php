<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/5/15
 * Time: 8:56 AM
 */
class Cupid_Classes_Category_Widget extends G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'cupid-calsses-category-widget';
        $this->widget_description = __( "List Category", 'cupid' );
        $this->widget_id          = 'widget_cupid_classes_category';
        $this->widget_name        = __( 'cupid: Classes Category', 'cupid' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => __( 'Categories', 'cupid' ),
                'label' => __( 'Title', 'cupid' )
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $title         = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
        $widget_id = $args['widget_id'];
        $class_custom   = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_class_custom', $instance['class_custom'] );
        echo wp_kses_post($before_widget);

        $args = array(
            'orderby' => 'count',
            'hide_empty' => '0'
        );
        $taxonomy = 'classes_category';
        $tax_terms = get_terms($taxonomy, $args );
        ?>
        <?php if ( $class_custom <> '' ) {
            echo '<div class="' . $class_custom . '">';
        }
        ?>
            <h4 class="widget-title"><span><?php echo esc_html($title) ?></span></h4>
            <ul>
            <?php foreach ($tax_terms as $tax_term) {
                    if($tax_term->name!='')
            ?>
                <li class="cat-item">
                    <a href="<?php echo esc_url(get_term_link($tax_term)); ?>"><?php echo esc_attr($tax_term->name);  ?></a>
                </li>
            <?php } ?>
            </ul>
        <?php if ( $class_custom <> '' ) {
            echo '</div>';
        } ?>
        <?php
        echo wp_kses_post($after_widget);
    }
}

class Cupid_Classes_Popular_Widget extends G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'cupid-calsses-popular-widget';
        $this->widget_description = __( "Popular Classes", 'cupid' );
        $this->widget_id          = 'widget_cupid_classes_popular';
        $this->widget_name        = __( 'cupid: Popular Classes', 'cupid' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => __( 'Popular Classes', 'cupid' ),
                'label' => __( 'Title', 'cupid' )
            ),
            'number'  => array(
                'type'  => 'text',
                'std'   => __( '3', 'cupid' ),
                'label' => __( 'Number Classes Display', 'cupid' )
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $title         = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
        $number         = empty( $instance['number'] ) ? '' : apply_filters( 'widget_number', $instance['number'] );
        $widget_id = $args['widget_id'];
        $class_custom   = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_class_custom', $instance['class_custom'] );
        echo wp_kses_post($before_widget);

        $post_per_page = -1;
        if($number<>'')
            $post_per_page = $number;



        $args = array(
            'posts_per_page'    => $post_per_page,
            'meta_key'          => 'popular-class',
            'orderby'           => 'meta_value_num',
            'order'             => 'DESC',
            'post_type'         => 'cupid_classes',
            'post_status'       => 'publish');
        $posts  = new WP_Query( $args );
        ?>
        <?php if ( $class_custom <> '' ) {
            echo '<div class="' . $class_custom . '">';
        }
        ?>
        <h4 class="widget-title"><span><?php echo esc_html($title); ?></span></h4>
        <ul>
            <?php
                while ( $posts->have_posts() ) : $posts->the_post();
                    $images = '';
                    if(has_post_thumbnail()){
                        $arrImages = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail-350x350' );
                        $images =  $arrImages[0];
                    }
                    $month_old = get_post_meta( get_the_ID(), 'month-olds', false );
            ?>
                <li>
                    <div class="popular-item">
                        <div class="col-md-4">
                            <div class="popular-thumbnail-wrap">
                                <img class="popular-thumbnail" src="<?php echo esc_url($images) ?>" alt="<?php echo get_the_title() ?>">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6><a href="<?php echo esc_attr(get_permalink())?>" title="<?php echo esc_attr($title) ?>"><?php echo get_the_title(); ?></a></h6>
                            <div class="month-old"><?php  if(count($month_old)>0){ echo esc_html($month_old[0].__(' month old','cupid'));}?></div>
                        </div>
                    </div>
                </li>
            <?php
                endwhile;
                wp_reset_postdata();
            ?>
        </ul>
        <?php if ( $class_custom <> '' ) {
            echo '</div>';
        } ?>
        <?php
        echo wp_kses_post($after_widget);
    }
}

if (!function_exists('cupid_register_widget_classes')) {
    function cupid_register_widget_classes() {
        register_widget('Cupid_Classes_Category_Widget');
        register_widget('Cupid_Classes_Popular_Widget');
    }
    add_action('widgets_init', 'cupid_register_widget_classes', 1);
}