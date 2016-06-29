<?php
class El_Cupid_Page_Collection {
    private $name = 'el_cupid_page_collection';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_page_collection'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Lista de Autores',
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
                    'heading' => 'Introdução',
                    'param_name' => 'introduction',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Título da Lista',
                    'param_name' => 'title_list',
                    'value' => ''
                ),
                array(
                    'type' => 'attach_images',
                    'heading' => 'Imagem dos autores',
                    'param_name' => 'images',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Título Editoras',
                    'param_name' => 'title_brand',
                    'value' => ''
                ),
                array(
                    'type' => 'attach_images',
                    'heading' => 'Imagem das editoras',
                    'param_name' => 'images_brand',
                    'value' => ''
                )
            )
        ) );
    }

    public function el_cupid_page_collection($atts) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');
        $tpl->title = $atts['title'];
        $tpl->introduction = $atts['introduction'];
        $tpl->title_list = $atts['title_list'];
        $tpl->title_brand = $atts['title_brand'];

        if(isset($atts['images'])) {
            $imagesId = explode(',', $atts['images']);
            $i = 0;
            foreach ($imagesId as $imageId) {
                $post = get_post($imageId);
                $tpl->image_src = $post->guid;
                $tpl->image_title = $post->post_title;
                $tpl->block('BLOCK_AUTHOR');
                $i++;
                if($i == 4) {
                    $tpl->block('LIST');
                    $i = 0;
                }
            }
            if($i > 0 && $i < 4) {
                $tpl->block('LIST');
            }
        }
        if(isset($atts['images_brand'])) {
            $imagesId = explode(',', $atts['images_brand']);
            foreach ($imagesId as $imageId) {
                $post = get_post($imageId);
                $tpl->brand_image_src = $post->guid;
                $tpl->brand_image_title = $post->post_title;
                $tpl->block('BRAND');
            }
        }

        return $tpl->parse();
    }
}
new El_Cupid_Page_Collection;