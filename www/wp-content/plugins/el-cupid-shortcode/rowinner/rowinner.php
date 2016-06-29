<?php
class El_Cupid_Row_Inner {
    public function __construct() {
        add_action('vc_before_init', array($this, 'add_vc_param'));
        add_shortcode('vc_row_inner', array($this, 'cupid_vc_row_inner_shortcode'));
    }

    public function add_vc_param() {
        vc_add_param('vc_row_inner',
            array(
                'type' => 'dropdown',
                'heading' => 'Estilo Elefante Letrado',
                'param_name' => 'el_elefante_letrado',
                'value' => array(
                    'Selecione' => '',
                    'Sim' => 'row'
                )
            )
        );
    }

    public function cupid_vc_row_inner_shortcode($atts, $content = null){
        if(!empty($atts['el_elefante_letrado'])) {
            $output = '<div class="'.$atts['el_elefante_letrado'].'">';
            $output .= wpb_js_remove_wpautop( $content );
            $output .= '</div>';
            return $output;
        }
        $output = $style_css = $layout = $parallax_style = $parallax_scroll_effect = $parallax_speed = $overlay_set = $overlay_color = $overlay_image = $overlay_opacity = $el_id = $el_class = $bg_image = $bg_color = $bg_image_repeat = $pos = $font_color = $padding = $margin_bottom = $css = '';
        extract( shortcode_atts( array(
            'el_class'        => '',
            'el_id'        => '',
            'bg_image'        => '',
            'bg_color'        => '',
            'bg_image_repeat' => '',
            'font_color'      => '',
            'padding'         => '',
            'margin_bottom'   => '',
            'css'             => '',
            'layout'          => '',
            'parallax_style'  => 'none',
            'parallax_scroll_effect'  => '',
            'parallax_speed'  => '',
            'overlay_set'     => 'hide_overlay',
            'overlay_color'   => '',
            'overlay_image'   => '',
            'overlay_opacity' => '',
        ), $atts ) );

        //wp_enqueue_style( 'js_composer_front' );
        wp_enqueue_script( 'wpb_composer_front_js' );
        //wp_enqueue_style( 'js_composer_custom_css' );
        $el_class = g5plus_vc_getExtraClass( $el_class );
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row vc_inner ' . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $atts );
#
        $style = g5plus_vc_buildStyle( $bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
        /*************edit**************/
        $str_el_id='';

        if($el_id!='')
        {
            $str_el_id='id="'.esc_attr($el_id).'"';
        }
        else
        {
            if($overlay_set!='hide_overlay'){
                if($el_id=='')
                {
                    $el_id = 'row-'.rand( 0, 10000 ).'-'.rand( 0, 10000 );
                    $str_el_id='id="'.esc_attr($el_id).'"';
                }
            }
        }
        if ( $layout == 'boxed' ) {
            $output .= '<div '.$str_el_id.' class="container">';
        } else {
            $output .= '<div '.$str_el_id.' class="fullwidth">';
        }
        if ($parallax_style != 'none') {
            $output .= '<div data-parallax_speed="'.(esc_attr($parallax_speed)/100) .'" data-scroll_effect="'.esc_attr($parallax_scroll_effect).'" class="' . esc_attr($css_class) .  ' '.esc_attr($parallax_style).'"' . $style .'>';
        }
        else
        {
            if($overlay_set!='hide_overlay'){
                $output .= '<div class="' . esc_attr($css_class) . '"' . $style .' style="position: static;">';
            }
            else
            {
                $output .= '<div class="' . esc_attr($css_class) . '"' . $style .'>';
            }
        }
        if($overlay_set!='hide_overlay'){
            if($overlay_set=='show_overlay_color'){
                $overlay_color = g5plus_hex_to_rgba(esc_attr($overlay_color),(esc_attr($overlay_opacity)/100));
                $style_css=' data-overlay_id='.$el_id.' data-overlay_color= '.esc_attr($overlay_color);
            }
            else if($overlay_set=='show_overlay_image'){
                $arrImages = wp_get_attachment_image_src($overlay_image,'full');
                $style_css=' data-overlay_id='.esc_attr($el_id).' data-overlay_image= '.$arrImages[0].' data-overlay_opacity='.($overlay_opacity/100);
            }
            $output .= '<div class="overlay" '.$style_css.'></div>';
        }
        $output .= wpb_js_remove_wpautop( $content );
        $output .= '</div></div>';
        return $output;
    }
}
new El_Cupid_Row_Inner;