<?php
class El_Cupid_Row {
    public function __construct() {
        add_action('vc_before_init', array($this, 'add_vc_param'));
        add_shortcode('vc_row', array($this, 'cupid_vc_row_shortcode'));
    }

    public function add_vc_param() {
        vc_add_param('vc_row',
            array(
                'type' => 'dropdown',
                'heading' => 'Estilo Elefante Letrado',
                'param_name' => 'el_elefante_letrado',
                'value' => array(
                    'Selecione' => '',
                    'Funcionalidades' => 'el-article-style-2',
                    'Página de Funcionalidades' => 'page-features',
                    'Container de Banner Principal' => 'owl-carousel-main',
                    'Sem estilo' => 'no'
                )
            )
        );
    }

    public function cupid_vc_row_shortcode($atts, $content = null) {
        if(!empty($atts['el_elefante_letrado'])) {
            switch($atts['el_elefante_letrado']) {
                case 'no':
                    return wpb_js_remove_wpautop( $content );
                    break;
                case 'page-features':
                    return '<article class="el-page-content el-page-features">
                            <div id="owl-carousel-features">
                                '.wpb_js_remove_wpautop( $content ).'
                            </div>
                        </article>';
                    break;
                case 'page-collection':
                    return '<section class="el-collection-rotate el-section-collection-state-one fade-effect-rotate" style="height: 262px;" aria-hidden="true">
                            <div class="el-section-collection-content" style="height: 262px; width: 1991px;">
                                <img src="<?php echo get_template_directory_uri(); ?>/el-images-optimized/collection-rotate-mobile.jpg" width="1991" height="262" style="max-width: 1991px;" align="Conheça o Acervo de Livros do elefante Letrado.">
                            </div>
                        </section>';
                default:
                    $output = '<div class="'.$atts['el_elefante_letrado'].'">';
                    $output .= wpb_js_remove_wpautop( $content );
                    $output .= '</div>';
                    return $output;
            }
        }
        $video_link=$css_animation = $duration = $delay=$output = $style_css = $layout = $parallax_style = $parallax_scroll_effect = $parallax_speed = $overlay_set = $overlay_color = $overlay_image = $overlay_opacity = $el_id = $el_class = $bg_image = $bg_color = $bg_image_repeat = $pos = $font_color = $padding = $margin_bottom = $css = '';
        extract( shortcode_atts( array(
            'el_class'        => '',
            'el_id'           => '',
            'bg_image'        => '',
            'bg_color'        => '',
            'bg_image_repeat' => '',
            'font_color'      => '',
            'padding'         => '',
            'margin_bottom'   => '',
            'css'             => '',
            'layout'          => '',
            'parallax_style'  => 'none',
            'video_link'   => '',
            'parallax_scroll_effect'  => '',
            'parallax_speed'  => '',
            'overlay_set'     => 'hide_overlay',
            'overlay_color'   => '',
            'overlay_image'   => '',
            'overlay_opacity' => '',
            'css_animation'   => '',
            'duration'        => '',
            'delay'           => ''
        ), $atts ) );

        wp_enqueue_script( 'wpb_composer_front_js' );

        $el_class = g5plus_vc_getExtraClass($el_class );
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row ' . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $atts );

        $style = g5plus_vc_buildStyle( $bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
        /*************edit**************/

        $str_el_id='';
        $css_overlay_video='';
        if($el_id!='')
        {
            $str_el_id='id="'.esc_attr($el_id).'"';
        }
        if ( $layout == 'boxed' ) {
            $style_css='container';
        } elseif ( $layout == 'container-fluid' ) {
            $style_css='container-fluid';
        }else
        {
            $style_css='fullwidth';
        }
        $output .= '<div '.$str_el_id.' class="'.$style_css . g5plus_getCSSAnimation($css_animation) .'" '.g5plus_getStyleAnimation($duration,$delay).'>';
        if ($parallax_style != 'none' && $parallax_style != 'video-background') {
            if($overlay_set!='hide_overlay'){
                $css_overlay_video=' overlay-wapper';
            }
            $output .= '<div data-parallax_speed="'.(esc_attr($parallax_speed)/100) .'" data-scroll_effect="'.esc_attr($parallax_scroll_effect).'" class="' . esc_attr($css_class) .  ' '.esc_attr($parallax_style).$css_overlay_video.'"' . $style .'>';
        }
        else
        {
            if($overlay_set!='hide_overlay'){
                $css_overlay_video=' overlay-wapper';
            }
            if ($parallax_style == 'video-background') {
                $css_overlay_video.=' video-background-wapper';
            }
            $output .= '<div class="' . esc_attr($css_class) . $css_overlay_video.'"' . $style .'>';
        }
        if ($parallax_style == 'video-background') {
            $output .= '<video data-top-default="0" muted="muted" loop="loop" autoplay="true" preload="auto">
                                <source src="' . esc_url($video_link) . '">
                            </video>';
        }
        if($overlay_set!='hide_overlay'){
            $overlay_id='overlay-'.uniqid();
            if($overlay_set=='show_overlay_color'){
                $overlay_color = g5plus_hex_to_rgba(esc_attr($overlay_color),(esc_attr($overlay_opacity)/100));
                $style_css=' data-overlay_color= '.esc_attr($overlay_color);
            }
            else if($overlay_set=='show_overlay_image'){
                $image_attributes = wp_get_attachment_image_src( $overlay_image,'full' );
                $style_css=' data-overlay_image= '.$image_attributes[0].' data-overlay_opacity='.(esc_attr($overlay_opacity)/100);
            }
            $output .= '<div id="'.$overlay_id.'" class="overlay" '.$style_css.'></div>';
        }
        $output .= wpb_js_remove_wpautop( $content );
        $output .= '</div></div>';
        return $output;
    }
}
new El_Cupid_Row;