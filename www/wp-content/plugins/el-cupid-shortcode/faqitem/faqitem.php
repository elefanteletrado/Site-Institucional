<?php
class El_Cupid_Faq_Item{
    private $name = 'el_cupid_faq_item';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_action('init', array($this, 'add_shortcode'));
    }

    public function add_shortcode() {
        add_shortcode($this->name, array($this, 'el_cupid_faq_item'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Item de Dúvida',
            'base'     => $this->name,
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Pergunta',
                    'param_name' => 'question',
                    'value'      => ''
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Resposta',
                    'param_name' => 'content',
                    'value'      => ''
                )
            )
        ) );
    }

    public function el_cupid_faq_item($atts, $content) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');
        $tpl->question = $atts['question'];
        $tpl->answer = $content;

        return $tpl->parse();
    }
}
new El_Cupid_Faq_Item;