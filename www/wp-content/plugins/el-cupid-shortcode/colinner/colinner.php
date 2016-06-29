<?php
class El_Cupid_Col_Inner {
    public function __construct() {
        add_action('vc_before_init', array($this, 'add_vc_param'));
        add_shortcode('vc_column_inner', array($this, 'cupid_vc_column_inner_shortcode'));
    }

    public function add_vc_param() {
        vc_add_param('vc_column_inner',
            array(
                'type' => 'dropdown',
                'heading' => 'Estilo Elefante Letrado',
                'param_name' => 'el_elefante_letrado',
                'value' => array(
                    'Selecione' => '',
                    'Sim' => 'yes',
                    'Sem estilo' => 'no'
                )
            )
        );
    }

    public function cupid_vc_column_inner_shortcode($atts, $content = null) {
        Vc_Manager::getInstance()->vc()->addShortCode(array('vc_column_inner'));
        $shortcode = Vc_Manager::getInstance()->vc()->getShortCode('vc_column_inner');
        if(!empty($atts['el_elefante_letrado'])) {
            if('no' == $atts['el_elefante_letrado']) {
                return wpb_js_remove_wpautop( $content );
            }
            $width = wpb_translateColumnWidthToSpan( $atts['width'] );
            $width = str_replace('vc_', '', vc_column_offset_class_merge( $atts['offset'], $width ));
            $output = '<div class="'.$width.'">';
            $output .= wpb_js_remove_wpautop( $content );
            $output .= '</div>';
            return $output;
        }
        return $shortcode->render($atts, $content);
    }
}
new El_Cupid_Col_Inner;