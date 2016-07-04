<?php
class El_Cupid_Banner_Page_Content {
    private $name = 'el_cupid_banner_page_content';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_banner_page_content'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Banner de página conteúdo',
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
                )
            )
        ) );
    }

    public function el_cupid_banner_page_content($atts) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');

        $post = get_post($atts['image']);
        $tpl->image_src = $post->guid;
        
        return $tpl->parse();
    }
}
new El_Cupid_Banner_Page_Content;