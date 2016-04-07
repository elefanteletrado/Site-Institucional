<?php
/**
 * Add less for developer
 */
function cupid_add_less_for_dev () {
    if (defined( 'CUPID_SCRIPT_DEBUG' ) && CUPID_SCRIPT_DEBUG) {
        global $cupid_data;
        $primary_color = $cupid_data['primary-color'];
        $primary_color = str_replace('#','',$primary_color);

        $secondary_color = $cupid_data['secondary-color'];
        $secondary_color = str_replace('#','',$secondary_color);

        $button_color = $cupid_data['button-color'];
        $button_color = str_replace('#','',$button_color);

        $bullet_color = $cupid_data['bullet-color'];
        $bullet_color = str_replace('#','',$bullet_color);

        $icon_box_color = $cupid_data['icon-box-color'];
        $icon_box_color = str_replace('#','',$icon_box_color);


        echo '<link rel="stylesheet/less" type="text/css" href="'. get_template_directory_uri(). '/less.php?primary-color=' . $primary_color.'&amp;secondary-color=' . $secondary_color.'&amp;button-color=' . $button_color.'&amp;bullet-color=' . $bullet_color.'&amp;icon-box-color=' . $icon_box_color.'&amp;theme_url=' . THEME_URL.'"/>';
        echo '<script src="'. THEME_URL. 'assets/js/less-1.7.3.min.js"></script>';

        require_once ( THEME_DIR . "lib/inc-generate-less/custom-css.php" );
        $css = cupid_custom_css();
        echo '<style>' . $css . '</style>';
    }
}
add_action('wp_head','cupid_add_less_for_dev', 100);