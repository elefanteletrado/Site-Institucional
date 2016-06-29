<?php
class El_Cupid_Page_Feature {
    private $name = 'el_cupid_page_feature';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_page_features'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Item da Página de Funcionalidades',
            'base'     => $this->name,
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type' => 'textfield',
                    'heading' => 'Título',
                    'param_name' => 'title',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Texto',
                    'param_name' => 'text',
                    'value' => ''
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => 'Imagem',
                    'param_name' => 'image',
                    'value' => ''
                )
            )
        ) );
    }

    public function el_cupid_page_features($atts) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');
        $tpl->title = $atts['title'];
        $tpl->text = $atts['text'];

        if(isset($atts['image'])) {
            $post = get_post($atts['image']);
            $tpl->image_src = $post->guid;
            $tpl->image_title = $post->post_title;
        }

        return $tpl->parse();
    }
}
new El_Cupid_Page_Feature;