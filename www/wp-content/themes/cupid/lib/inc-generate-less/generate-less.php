<?php
/**
 * Created by PhpStorm.
 * User: duonglh
 * Date: 8/23/14
 * Time: 3:01 PM
 */

function cupid_generate_less()
{
	require_once ('Less.php');

    $cupid_data = of_get_options();

	try {
        $primary_color = $cupid_data['primary-color'];
        $secondary_color = $cupid_data['secondary-color'];
        $button_color = $cupid_data['button-color'];
        $bullet_color = $cupid_data['bullet-color'];
        $icon_box_color = $cupid_data['icon-box-color'];

		$site_logo_url = $cupid_data['site-logo'];
		$site_logo_white_url = $cupid_data['site-logo-white'];

		$site_logo_url = str_replace(THEME_URL, '', $site_logo_url);
		$site_logo_white_url = str_replace(THEME_URL, '', $site_logo_white_url);

		$css = '@primary_color:'.$primary_color.';';
        $css .= '@secondary_color:'.$secondary_color.';';
        $css .= '@button_color:'.$button_color.';';
        $css .= '@bullet_color:'.$bullet_color.';';
        $css .= '@icon_box_color:'.$icon_box_color.';';

        $css .= "@logo_url : '". $site_logo_url ."';@logo_white_url : '". $site_logo_white_url ."';";
		$css .= '@theme_url:"' . THEME_URL . '";';


        $style = $css;

		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once ( THEME_DIR . "lib/inc-generate-less/custom-css.php" );
		$custom_css = cupid_custom_css();

		WP_Filesystem();
		global $wp_filesystem;

        $options = array( 'compress'=>true );
        $parser = new Less_Parser($options);
        $parser->parse($css);
        $parser->parseFile(THEME_DIR.'assets/css/less/style.less');
		$parser->parse($custom_css);
        $css = $parser->getCss();

		if (!$wp_filesystem->put_contents( THEME_DIR.   "style.min.css", $css, FS_CHMOD_FILE)) {
			echo __('Could not save file','cupid');
			return '0';
		}



        /*$theme_info = $wp_filesystem->get_contents( THEME_DIR . "theme-info.txt" );
        $parser = new Less_Parser();
        $parser->parse($style);
        $parser->parseFile(THEME_DIR . 'assets/css/less/style.less',THEME_URL);
        $style = $parser->getCss();
		$parser->parse($custom_css);
        $style = $theme_info . "\n" . $style;
        $style = str_replace("\r\n","\n", $style);
        $wp_filesystem->put_contents( THEME_DIR.   "style.css", $style, FS_CHMOD_FILE);*/
		return '1';
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
		return '0';
	}
}
