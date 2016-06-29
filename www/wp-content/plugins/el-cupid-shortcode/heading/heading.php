<?php
class El_Cupid_Heading{
    function __construct() {
        add_shortcode('el_cupid_heading', array($this, 'el_cupid_heading_shortcode'));
    }
    function el_cupid_heading_shortcode($atts) {
        require_once EXT_BASE_DIR.'/includes/class-ext-base-template.php';

        $template = new Ext_Base_Template(__DIR__.'/view.tpl');
        $template->title = $atts['title'];
        $template->text = $atts['text'];
        $template->collefttitle = $atts['collefttitle'];
        $template->colrighttext = $atts['colrighttext'];
        if(isset($atts['images_mobile'])) {
            $imagesId = explode(',', $atts['images_mobile']);
            foreach ($imagesId as $imageId) {
                $post = get_post($imageId);
                $template->image_mobile_src = $post->guid;
                $template->image_mobile_title = $post->post_title;
                $template->block('BLOCK_IMAGE_MOBILE');
            }
        }

        $post = get_post($atts['image']);
        $template->image_src = $post->guid;
        $template->image_title = $post->post_title;
        $template->block('BLOCK_IMAGE');

        return $template->parse();
    }
}
new El_Cupid_Heading;