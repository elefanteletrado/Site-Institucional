<?php
/**
 * Plugin Name: Cupid Our Staffs
 * Plugin URI: http://g5plus.net
 * Description: This is plugin that create our team post type
 * Version: 1.0
 * Author: g5plus
 * Author URI: http://g5plus.net
 * License: GPLv2 or later
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if(!class_exists('Cupid_Our_Staffs')){
    class Cupid_Our_Staffs{
        function __construct(){
            add_action('init', array($this,'register_post_types'), 5 );
            add_shortcode('cupid_our_staffs', array($this, 'cupid_our_staffs_shortcode'));
            add_filter( 'rwmb_meta_boxes', array($this,'cupid_register_meta_boxes' ));
        }

        function cupid_register_meta_boxes( $meta_boxes )
        {
            $meta_boxes[] = array(
                'title'  => __( 'Our Staffs Information', 'cupid' ),
                'pages'  => array( 'our-staffs' ),
                'fields' => array(
                    array(
                        'name' => __( 'Job', 'cupid' ),
                        'id'   => 'job',
                        'type' => 'text',
                    ),
                    array(
                        'name' => __( 'Facebook URL', 'cupid' ),
                        'id'   => 'face_url',
                        'type' => 'url',
                    ),
                    array(
                        'name' => __( 'Twitter URL', 'cupid' ),
                        'id'   => 'twitter_url',
                        'type' => 'url',
                    ),
                    array(
                        'name' => __( 'Google URL', 'cupid' ),
                        'id'   => 'google_url',
                        'type' => 'url',
                    ),
                    array(
                        'name' => __( 'Linked In URL', 'cupid' ),
                        'id'   => 'linkedin_url',
                        'type' => 'url',
                    ),
                    array(
                        'name' => __( 'Phone', 'cupid' ),
                        'id'   => 'phone',
                        'type' => 'text',
                    ),
                    array(
                        'name' => __( 'Email', 'cupid' ),
                        'id'   => 'email',
                        'type' => 'text',
                    ),
                )
            );
            return $meta_boxes;
        }
        function register_post_types() {
            if ( post_type_exists('our-staffs') ) {
                return;
            }

            register_post_type( 'our-staffs',
                array(
                    'label'       => __( 'cupid_our_staffs', 'cupid' ),
                    'description' => __( 'Our Staffs Description', 'cupid' ),
                    'labels'      => array(
                        'name'               => _x( 'Our Staffs', 'Post Type General Name', 'cupid' ),
                        'singular_name'      => _x( 'Our Staffs', 'Post Type Singular Name', 'cupid' ),
                        'menu_name'          => __( 'Our Staffs', 'cupid' ),
                        'all_items'          => __( 'All Our Staff', 'cupid' ),
                        'add_new_item'       => __( 'Add New Our Staff', 'cupid' ),
                    ),
                    'supports'    => array( 'title','editor', 'thumbnail'),
                    'public'      => true,
                    'has_archive' => true
                )
            );
        }
        function cupid_our_staffs_shortcode($atts){
            $item_amount = $column = $html = $el_class = $g5plus_animation = $css_animation = $duration = $delay = $styles_animation ='';
            extract( shortcode_atts( array(
                'column'        => '',
                'item_amount'   => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => ''
            ), $atts ) );

            $g5plus_animation .= ' ' . esc_attr($el_class);
            $g5plus_animation .= g5plus_getCSSAnimation( $css_animation );
            $styles_animation= g5plus_getStyleAnimation($duration,$delay);
            $args    = array(
                'posts_per_page'   	=> $item_amount,
                'post_type'      => 'our-staffs',
                'orderby'   => 'date',
                'order'     => 'ASC',
                'post_status'      	=> 'publish'
            );
            $data = new WP_Query( $args );
            if ( $data->have_posts() ) {
                $html .= '<div class="cupid-our-staffs ' . $g5plus_animation . '" '.$styles_animation.'>
                           <div class="row">
                            <div class="owl-carousel" data-plugin-options=\'{"items" : '.$column.',"itemsDesktop" : [1199,3],"pagination": false, "autoPlay": true}\'>';
                while ( $data->have_posts() ): $data->the_post();
                    $job   = get_post_meta(get_the_ID(), 'job', true);
                    $image_id  = get_post_thumbnail_id();
                    $image_url = wp_get_attachment_image( $image_id, 'full  img-circle', false, array( 'alt' => get_the_title(), 'title' => get_the_title()));
                    $html .= '<div class="our-staffs-item">
                                <div class="our-staffs-image"><a href="' . get_permalink() . '" title="' . get_the_title() . '" >'.wp_kses_post($image_url).'</a></div>
                                <a class="our-staffs-name" href="' . get_permalink() . '" title="' . get_the_title() . '" >' . get_the_title() . '</a>
                                <p>'.esc_html($job).'</p>';
                    $html .= '</div>';
                endwhile;
                $html .= '</div>
                        </div>
                     </div>';
            }
            wp_reset_postdata();
            return $html;
        }
    }
    new Cupid_Our_Staffs;
}