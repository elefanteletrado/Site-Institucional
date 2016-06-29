<?php
class El_Cupid_Banner_Main {
    private $name = 'el_cupid_banner_main';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_banner_main'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Banner principal',
            'base'     => $this->name,
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type' => 'dropdown',
                    'heading' => 'Estilo',
                    'param_name' => 'bannerstyle',
                    'value' => array(
                        'Centralizado' => 'center',
                        'Esquerdo' => 'left'
                    )
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Título',
                    'param_name' => 'title',
                    'value' => '',
                    'description' => 'Adicione asterísco no início e no fim do texto para usar negrito. Exemplo: Elefante *Letrado*',
                    'admin_label' => true
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
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Texto botão rosa',
                    'param_name' => 'button_contrast_text',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Link botão rosa',
                    'param_name' => 'button_contrast_url',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'ID botão rosa',
                    'param_name' => 'button_contrast_id',
                    'value' => '',
                    'description' => 'Use "popup-contact-open" para abrir o Popup de contato.'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Texto botão branco',
                    'param_name' => 'button_outline_text',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Link botão branco',
                    'param_name' => 'button_outline_url',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'ID botão branco',
                    'param_name' => 'button_outline_id',
                    'value' => ''
                )
            )
        ) );
    }

    public function el_cupid_banner_main($atts) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');

        $tpl->title = preg_replace('@\*(.+)\*@', '<strong>$1</strong>', $atts['title']);
        $tpl->text = preg_replace('@\*(.+)\*@', '<strong>$1</strong>', $atts['text']);
        $tpl->style = $atts['bannerstyle'] == 'left' ? '' : 'el-banner-container-style-2';

        $post = get_post($atts['image']);
        $tpl->image_src = $post->guid;
        
        if($atts['button_contrast_text']) {
            $tpl->button_contrast_text = $atts['button_contrast_text'];
            $tpl->button_contrast_url = $atts['button_contrast_url'];
            $tpl->button_contrast_id = $atts['button_contrast_id'];
            $tpl->block('BUTTON_CONTRAST');
        }
        if($atts['button_outline_text']) {
            $tpl->button_outline_text = $atts['button_outline_text'];
            $tpl->button_outline_url = $atts['button_outline_url'];
            $tpl->button_outline_id = $atts['button_outline_id'];
            $tpl->block('BUTTON_OUTLINE');
        }
        if($atts['button_contrast_text'] || $atts['button_outline_text']) {
            $tpl->block('BUTTONS');
        }
        
        return $tpl->parse();
    }
}
new El_Cupid_Banner_Main;