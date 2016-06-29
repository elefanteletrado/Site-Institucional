<?php
class El_Cupid_Text_Block{
    function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode('el_cupid_text_block', array($this, 'el_cupid_text_block_shortcode'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Bloco de Texto',
            'base'     => 'el_cupid_text_block',
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type'       => 'textarea_html',
                    'heading'    => 'Texto',
                    'param_name' => 'content',
                    'holder'     => 'div',
                    'value'      => ''
                )
            )
        ) );
    }

    function el_cupid_text_block_shortcode($atts, $content) {
        return apply_filters('the_content', preg_replace(array('@^\s*</p>\s*<pre>@', '@</pre>\s*<p>\s*$@'), array('', ''), $content));
    }
}
new El_Cupid_Text_Block;