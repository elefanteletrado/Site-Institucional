<?php
function cupid_color_style() {
	/*if (!is_page_template() || (defined( 'CUPID_SCRIPT_DEBUG' ) && CUPID_SCRIPT_DEBUG) ) {
		return;
	}*/

	global $cupid_data;

	require_once ('Less.php');

	$primary_color = $cupid_data['primary-color'];
	$secondary_color = $cupid_data['secondary-color'];
	$button_color = $cupid_data['button-color'];
	$bullet_color = $cupid_data['bullet-color'];
	$icon_box_color = $cupid_data['icon-box-color'];

	$css = '@primary_color:'.$primary_color.';';
	$css .= '@secondary_color:'.$secondary_color.';';
	$css .= '@button_color:'.$button_color.';';
	$css .= '@bullet_color:'.$bullet_color.';';
	$css .= '@icon_box_color:'.$icon_box_color.';';

	$options = array( 'compress'=>true );
	$parser = new Less_Parser($options);
	$parser->parse($css);
	$parser->parseFile(THEME_DIR.'assets/css/less/color.less');
	$css = $parser->getCss();
	echo '<style type="text/css" media="screen">'  . $css . '</style>';
}
add_action('wp_head','cupid_color_style', 1000);