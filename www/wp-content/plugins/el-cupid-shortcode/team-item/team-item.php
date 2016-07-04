<?php
class El_Cupid_Team_Item {
    private $name = 'el_cupid_team_item';

    public function __construct() {
        add_action('init', array($this, 'add_vc_map'));
        add_shortcode($this->name, array($this, 'el_cupid_team_item'));
    }

    public function add_vc_map() {
        vc_map( array(
            'name'     => 'Item de Equipe',
            'base'     => $this->name,
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type' => 'textfield',
                    'heading' => 'Nome',
                    'param_name' => 'name',
                    'value' => '',
                    'admin_label' => true
                ),
                array(
                    'type' => 'textarea',
                    'heading' => 'Descrição',
                    'param_name' => 'description',
                    'value' => ''
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => 'Imagem',
                    'param_name' => 'image',
                    'value' => ''
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => 'Margem inicial',
                    'param_name' => 'initial_margin',
                    'value' => '',
                    'description' => 'Marque essa opção se estiver sendo mostrado apenas 3 membros de equipe.'
                )
            )
        ) );
    }

    public function el_cupid_team_item($atts) {
        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');

        $tpl->name = $atts['name'];
        $tpl->description = $atts['description'];
        $tpl->class = empty($atts['initial_margin']) ? '' : 'el-first-3';

        $post = get_post($atts['image']);
        $tpl->image_src = $post->guid;
        
        return $tpl->parse();
    }
}
new El_Cupid_Team_Item;