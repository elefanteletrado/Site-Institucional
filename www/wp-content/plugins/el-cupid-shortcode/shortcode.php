<?php
/**
* Plugin Name: Elefante Letrado - Cupid Shortcode
* Description: Adiciona shortcodes ao tema Cupid par o Elefante Letrado.
* Version: 1.0
* Author: CWI Software - Luiz Felipe Bertoldi de Oliveira
* Author URI: http://www.cwi.com.br
*/


require_once __DIR__.'/heading/heading.php';
require_once __DIR__.'/quote/quote.php';
require_once __DIR__.'/title/title.php';
require_once __DIR__.'/colfeatured/colfeatured.php';
require_once __DIR__.'/row/row.php';
require_once __DIR__.'/rowinner/rowinner.php';
require_once __DIR__.'/col/col.php';
require_once __DIR__.'/colinner/colinner.php';
require_once __DIR__.'/readmore/readmore.php';
require_once __DIR__.'/collection/collection.php';
require_once __DIR__.'/page-collection/page-collection.php';
require_once __DIR__.'/page-feature/page-feature.php';
require_once __DIR__.'/collection-single/collection-single.php';
require_once __DIR__.'/banner-main/banner-main.php';
require_once __DIR__.'/textblock/textblock.php';
require_once __DIR__.'/faqitem/faqitem.php';
require_once __DIR__.'/image/image.php';
require_once __DIR__.'/banner-page-content/banner-page-content.php';
require_once __DIR__.'/team-item/team-item.php';

class El_Cupid_Shortcode{
    function __construct(){
        add_action('init', array($this, 'register_vc_map'), 10);
    }

    function register_vc_map() {
        $this->add_heading();
        $this->add_quote();
        $this->add_title();
        $this->add_colfeatured();
    }

    function dropdown_image_predefined() {
        return array(
            'type'       => 'dropdown',
            'heading'    => 'Imagem pré-definida',
            'param_name' => 'image_predefined',
            "value"       => array(
                'Selecione' => '',
                'Toga rosa' => 'icon-toga.svg',
                'Pilha de Livros rosa' => 'icon-stack-books.svg',
                'Toga azul (círculo)' => 'icon-round-toga.svg',
                'Tablet amarelo (círculo)' => 'icon-round-tablet.svg',
                'Monitoramento verde (círculo)' => 'icon-round-monitor-graph.svg',
                'Livro rosa (círculo)' => 'icon-round-book.svg',
                'Gráfico de pizza rosa' => 'icon-pie-chart.svg',
                'Monitor rosa' => 'icon-monitor.svg',
                'Livro rosa (gota)' => 'icon-drop-book.svg',
                'Livro tablet branco' => 'icon-book.svg'
            )
        );
    }

    function add_heading() {
        vc_map( array(
            'name'     => 'Introdução',
            'base'     => 'el_cupid_heading',
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Título',
                    'param_name' => 'title',
                    'value'      => '',
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Texto',
                    'param_name'  => 'text',
                    'value'       => ''
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => 'Imagem grande',
                    'param_name' => 'image',
                    'value' => '',
                    'description' => 'Exibido para tablet e desktop.'
                ),
                array(
                    'type' => 'attach_images',
                    'heading' => 'Imagem (exibido para mobile)',
                    'param_name' => 'images_mobile',
                    'value' => '',
                    'description' => 'Imagens pequenas para mobile. É exibido um carousel.'
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Coluna esquerda (título)',
                    'param_name' => 'collefttitle',
                    'value'      => ''
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Coluna direita (texto)',
                    'param_name' => 'colrighttext',
                    'value'      => ''
                )
            )
        ) );
    }

    function add_quote() {
        vc_map( array(
            'name'     => 'Citação de autor',
            'base'     => 'el_cupid_quote',
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Nome do Autor',
                    'param_name' => 'author_name',
                    'value'      => '',
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Texto',
                    'param_name'  => 'text',
                    'value'       => ''
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => 'Imagem',
                    'param_name' => 'image',
                    'value' => ''
                ),
                $this->dropdown_image_predefined(),
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Largura da imagem',
                    'param_name' => 'image_width',
                    'value'      => ''
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Altura da imagem',
                    'param_name' => 'image_height'
                )
            )
        ) );
    }

    function add_title() {
        vc_map( array(
            'name'     => 'Título',
            'base'     => 'el_cupid_title',
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Título',
                    'param_name' => 'content',
                    'value'      => '',
                    'admin_label' =>  true
                ),
                array(
                    'type'       => 'dropdown',
                    'heading'    => 'Nível',
                    'param_name' => 'level',
                    'value'      => array(
                        '1º nível' => '',
                        '2º nível' => '2'
                    )
                )
            )
        ) );
    }

    function add_colfeatured() {
        vc_map( array(
            'name'     => 'Coluna de Funcionalidade',
            'base'     => 'el_cupid_colfeatured',
            'class'    => '',
            'icon'     => 'icon-wpb-title',
            'category' => 'Elefante Letrado Shortcodes',
            'params'   => array(
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Título',
                    'param_name' => 'title',
                    'value'      => '',
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Texto',
                    'param_name'  => 'text',
                    'value'       => ''
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => 'Imagem',
                    'param_name' => 'image',
                    'value' => ''
                ),
                $this->dropdown_image_predefined(),
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Largura da imagem',
                    'param_name' => 'image_width',
                    'value'      => ''
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => 'Altura da imagem',
                    'param_name' => 'image_height'
                )
            )
        ) );
    }
}
new El_Cupid_Shortcode;
