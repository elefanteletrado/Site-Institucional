<?php
class El_Cupid_Collection {
    private $name = 'el_collection';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_collection'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Banner rotativo',
            'base'     => $this->name,
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type' => 'attach_image',
                    'heading' => 'Imagem',
                    'param_name' => 'image',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Largura',
                    'param_name' => 'width',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Altura',
                    'param_name' => 'height',
                    'value' => ''
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => 'Mobile - Imagem',
                    'param_name' => 'mobile_image',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Mobile - Largura',
                    'param_name' => 'mobile_width',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Mobile - Altura',
                    'param_name' => 'mobile_height',
                    'value' => ''
                )
            )
        ) );
    }

    public function el_cupid_collection($atts) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');
        $tpl->width = $atts['width'];
        $tpl->height = $atts['height'];

        $post = get_post($atts['image']);
        $tpl->image_src = $post->guid;
        $tpl->image_alt = $post->post_title;

        $tpl->mobile_width = $atts['mobile_width'];
        $tpl->mobile_height = $atts['mobile_height'];

        $post = get_post($atts['mobile_image']);
        $tpl->mobile_image_src = $post->guid;
        $tpl->mobile_image_alt = $post->post_title;

        return $tpl->parse();
    }
}
new El_Cupid_Collection;