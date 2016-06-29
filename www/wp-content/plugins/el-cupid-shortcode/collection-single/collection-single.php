<?php
class El_Cupid_Collection_Single {
    private $name = 'el_collection_single';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_collection_single'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Banner rotativo de página',
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
                )
            )
        ) );
    }

    public function el_cupid_collection_single($atts) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');
        $tpl->width = $atts['width'];
        $tpl->height = $atts['height'];

        $post = get_post($atts['image']);
        $tpl->image_src = $post->guid;
        $tpl->image_alt = $post->post_title;
        
        return $tpl->parse();
    }
}
new El_Cupid_Collection_Single;