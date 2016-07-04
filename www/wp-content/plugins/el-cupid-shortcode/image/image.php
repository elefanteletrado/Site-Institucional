<?php
class El_Cupid_Image {
    private $name = 'el_cupid_image';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_image'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Imagem',
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

    public function el_cupid_image($atts) {
        $post = get_post($atts['image']);
        return '<img src="'.$post->guid.'" title="'.$post->post_title.'">';
    }
}
new El_Cupid_Image;