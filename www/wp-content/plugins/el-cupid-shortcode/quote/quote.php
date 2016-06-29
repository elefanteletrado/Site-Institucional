<?php
class El_Cupid_Quote{
    function __construct() {
        add_shortcode('el_cupid_quote', array($this, 'el_cupid_quote_shortcode'));
    }
    function el_cupid_quote_shortcode($atts) {
        require_once EXT_BASE_DIR.'/includes/class-ext-base-template.php';

        $tpl = new Ext_Base_Template(__DIR__.'/view.tpl');
        $tpl->author_name = $atts['author_name'];
        $tpl->text = $atts['text'];

        if(!empty($atts['image'])) {
            $post = get_post($atts['image']);
            $tpl->image_src = $post->guid;
            $tpl->image_title = $post->post_title;
        } else {
            $tpl->image_src = get_template_directory_uri().'/el-assets/images/layout/'.$atts['image_predefined'];
        }
        $tpl->image_width = $atts['image_width'];
        $tpl->image_height = $atts['image_height'];

        return $tpl->parse();
    }
}
new El_Cupid_Quote;