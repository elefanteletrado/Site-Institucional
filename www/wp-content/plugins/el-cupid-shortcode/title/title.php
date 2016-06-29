<?php
class El_Cupid_Title{
    function __construct() {
        add_shortcode('el_cupid_title', array($this, 'el_cupid_title_shortcode'));
    }
    function el_cupid_title_shortcode($atts, $content) {
        return '<h1>'.$content.'</h1>';
    }
}
new El_Cupid_Title;