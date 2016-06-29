<?php
class El_Cupid_Readmore {
    private $name = 'el_readmore';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_readmore'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Botão Leia Mais',
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
                    'heading' => 'Link',
                    'param_name' => 'link',
                    'value' => ''
                )
            )
        ) );
    }

    public function el_cupid_readmore($atts) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');
        $tpl->link = $atts['link'];
        $tpl->title = $atts['title'];
        return $tpl->parse();
    }
}
new El_Cupid_Readmore;