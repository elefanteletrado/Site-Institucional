<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/24/14
 * Time: 4:39 PM
 */

function cupid_stylesheet(){
    global $cupid_data;

    $elCupidAssets = (false === strpos(get_page_template(), 'el-page-templates'));

    $min_suffix = defined( 'CUPID_SCRIPT_DEBUG' ) && CUPID_SCRIPT_DEBUG ? '' : '.min';
    $url_font_awesome =  get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome.min.css';
    if ( isset( $cupid_data['font-awesome'] ) && !empty($cupid_data['font-awesome']) ) {
        $url_font_awesome = $cupid_data['font-awesome'];
    }
	$url_bootstrap_css = get_template_directory_uri() . '/assets/plugins/bootstrap/css/bootstrap.min.css';
	if ( isset( $cupid_data['bootstrap-css'] ) && !empty($cupid_data['bootstrap-css']) ) {
		$url_bootstrap_css = $cupid_data['bootstrap-css'];
	}
    wp_enqueue_style( 'cupid_awesome', $url_font_awesome, array() );
    if($elCupidAssets) {
        wp_enqueue_style( 'cupid_bootstrap', $url_bootstrap_css, array() );
        wp_enqueue_style( 'cupid_font_ProximaNova', get_template_directory_uri() . '/assets/css/proximaNova-fonts'.$min_suffix.'.css', array() );
        wp_enqueue_style( 'cupid_awesome-animation', get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome-animation.min.css', array() );
    }

    /*google fonts*/
    $google_fonts = array(
    );

    if (isset($cupid_data['body-font']['face-type']) && ($cupid_data['body-font']['face-type'] == '1') &&
        (!in_array($cupid_data['body-font']['face'],$google_fonts)) &&
        ($cupid_data['body-font']['face'] != 'none')){
        $google_fonts[] = $cupid_data['body-font']['face'];
    }

    if (isset($cupid_data['heading-font']['face-type']) && ($cupid_data['heading-font']['face-type'] == '1') &&
        (!in_array($cupid_data['heading-font']['face'],$google_fonts))&&
        ($cupid_data['heading-font']['face'] != 'none')){
        $google_fonts[] = $cupid_data['heading-font']['face'];
    }

    if (isset($cupid_data['h1-font']['face-type']) && ($cupid_data['h1-font']['face-type'] == '1') &&
        (!in_array($cupid_data['h1-font']['face'],$google_fonts))&&
        ($cupid_data['h1-font']['face'] != 'none')){
        $google_fonts[] = $cupid_data['h1-font']['face'];
    }

    if (isset($cupid_data['h2-font']['face-type']) && ($cupid_data['h2-font']['face-type'] == '1') &&
        (!in_array($cupid_data['h2-font']['face'],$google_fonts))&&
        ($cupid_data['h2-font']['face'] != 'none')){
        $google_fonts[] = $cupid_data['h2-font']['face'];
    }

    if (isset($cupid_data['h3-font']['face-type']) && ($cupid_data['h3-font']['face-type'] == '1') &&
        (!in_array($cupid_data['h3-font']['face'],$google_fonts))&&
        ($cupid_data['h3-font']['face'] != 'none')){
        $google_fonts[] = $cupid_data['h3-font']['face'];
    }

    if (isset($cupid_data['h4-font']['face-type']) && ($cupid_data['h4-font']['face-type'] == '1') &&
        (!in_array($cupid_data['h4-font']['face'],$google_fonts))&&
        ($cupid_data['h4-font']['face'] != 'none')){
        $google_fonts[] = $cupid_data['h4-font']['face'];
    }

    if (isset($cupid_data['h5-font']['face-type']) && ($cupid_data['h5-font']['face-type'] == '1') &&
        (!in_array($cupid_data['h5-font']['face'],$google_fonts))&&
        ($cupid_data['h5-font']['face'] != 'none')){
        $google_fonts[] = $cupid_data['h5-font']['face'];
    }

    if (isset($cupid_data['h6-font']['face-type']) && ($cupid_data['h6-font']['face-type'] == '1') &&
        (!in_array($cupid_data['h6-font']['face'],$google_fonts))&&
        ($cupid_data['h6-font']['face'] != 'none')){
        $google_fonts[] = $cupid_data['h6-font']['face'];
    }

    $fonts = '';
    foreach($google_fonts as $google_font)
    {
        $fonts .= str_replace('','+',$google_font) . ':300,300italic,400,400italic,500,600,700,800|' .$fonts;
    }
    if ($fonts != '')
    {
        $protocol = is_ssl() ? 'https' : 'http';
        if($elCupidAssets) {
            wp_enqueue_style('g5plus-google-fonts', $protocol . '://fonts.googleapis.com/css?family=' . substr_replace( $fonts, "", - 1 )  );
        }
    }

    /* plugin owl-carousel */
    wp_enqueue_style('cupid_plugin-owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel.min.css', array());
    wp_enqueue_style('cupid_plugin-owl-carousel-theme', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.theme.min.css', array());
    wp_enqueue_style('cupid_plugin-owl-carousel-transitions', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.transitions.css', array());

    if (!(defined( 'CUPID_SCRIPT_DEBUG' ) && CUPID_SCRIPT_DEBUG)) {
        wp_enqueue_style( 'cupid_style-min', get_template_directory_uri() . '/style.min.css');
    }

    wp_enqueue_style( 'el_cupid', get_template_directory_uri().'/el-assets/sass/style.css' );
    //wp_enqueue_style( 'cupid_style', get_stylesheet_uri() );
}
add_action('wp_enqueue_scripts','cupid_stylesheet', 11);


function cupid_script() {
    global $cupid_data;

    $elCupidAssets = (false === strpos(get_page_template(), 'el-page-templates'));

    wp_enqueue_script( 'jquery' );

    if($elCupidAssets) {
        $min_suffix = defined( 'CUPID_SCRIPT_DEBUG' ) && CUPID_SCRIPT_DEBUG ? '' : '.min';
        $url_bootstrap = get_template_directory_uri() . '/assets/plugins/bootstrap/js/bootstrap.min.js';
        if ( isset( $cupid_data['bootstrap-js'] ) && !empty($cupid_data['bootstrap-js']) ) {
            $url_bootstrap = $cupid_data['bootstrap-js'];
        }

        wp_enqueue_script( 'cupid_bootstrap', $url_bootstrap, array( 'jquery' ), false, true );

        if (is_single()) {
            wp_enqueue_script( 'comment-reply' );
        }

        wp_enqueue_script('cupid_plugins',get_template_directory_uri() . '/assets/js/plugins.js', array(), false,true);
        wp_enqueue_script('cupid_app',get_template_directory_uri() . '/assets/js/app'.$min_suffix.'.js',array(), false, true);

        /*plugin infinitescroll*/
        wp_enqueue_script('cupid_infinitescroll_plugins',get_template_directory_uri() . '/assets/plugins/jquery.infinitescroll/jquery.infinitescroll.min.js',array(), false, true);
    }

    $uri = get_template_directory_uri();
    wp_enqueue_script( 'el_owl_carousel', $uri.'/el-assets/owl.carousel/owl-carousel/owl.carousel.min.js', array(), false, true );
    wp_enqueue_script( 'el_cupid', $uri.'/el-assets/js/default.js', array(), false, true );
}
add_action('wp_enqueue_scripts','cupid_script');

if (is_admin()) {
    /*Register admin script and css*/
    function cupid_admin_stylesheet(){
		wp_enqueue_script('g5plus-media-init',get_template_directory_uri() . '/assets/admin/js/g5plus-media-init.js', false, true);
        wp_enqueue_style( 'g5plus_admin_css', get_template_directory_uri() . '/assets/admin/css/template.css', false, '1.0.0' );
		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
    }
    add_action('admin_enqueue_scripts','cupid_admin_stylesheet');
    add_editor_style(get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome.min.css');

    /*
	 * Load script and css for icon box control
	 */
    function g5plus_popup_icon_script() {
        wp_register_style( 'g5plus_popup_icon_css', get_template_directory_uri() . '/assets/admin/css/popup-icon.css', false, '1.0.0' );
        wp_enqueue_style( 'g5plus_popup_icon_css' );

        global $cupid_data;

        $url_font_awesome =  get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome.min.css';
        if ( isset( $cupid_data['font-awesome'] ) && !empty($cupid_data['font-awesome']) ) {
            $url_font_awesome = $cupid_data['font-awesome'];
        }
        wp_enqueue_style( 'cupid_awesome', $url_font_awesome, array() );

        wp_register_script('g5plus_popup_icon_js', get_template_directory_uri() . '/assets/admin/js/popup-icon.js', false, '1.0' );
        wp_enqueue_script( 'g5plus_popup_icon_js' );

        $wnm_custom = array( 'theme_url' => THEME_URL );
        wp_localize_script( 'g5plus_popup_icon_js', 'g5Constant', $wnm_custom );
    }
    add_action( 'admin_enqueue_scripts', 'g5plus_popup_icon_script' );
}