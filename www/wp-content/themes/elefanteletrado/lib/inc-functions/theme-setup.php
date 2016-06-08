<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/24/14
 * Time: 3:39 PM
 */

if (!function_exists('cupid_theme_setup')) {
    function cupid_theme_setup() {

        if ( ! isset( $content_width ) ) $content_width = 1170;

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Declare WooCommerce support
        add_theme_support( 'woocommerce' );

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary'     => __( 'Primary Menu', 'cupid' ),
			'left-menu'     => __( 'Left Menu', 'cupid' ),
			'right-menu'     => __( 'Right Menu', 'cupid' ),
			'footer-menu' => __('Footer Menu','cupid'),
        ) );

        // Enable support for Post Formats.
        add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio', 'quote', 'link', 'aside' ) );


        global $wp_version;

        if (version_compare($wp_version,'4.1','>=')){
            add_theme_support( "title-tag" );
        }
        if ( version_compare( $wp_version, '3.4', '>=' ) ) {
            add_theme_support( "custom-header");
            add_theme_support( "custom-background");
        }

        // Enable support for HTML5 markup.
        add_theme_support( 'html5', array(
            'comment-list',
            'search-form',
            'comment-form',
            'gallery',
        ) );

        $language_path = get_stylesheet_directory() .'/languages';
        if(!is_dir($language_path)){
            $language_path = get_template_directory() . '/languages';
        }
        load_theme_textdomain( 'cupid', $language_path );

        add_filter('widget_text', 'do_shortcode');
		add_filter('widget_content', 'do_shortcode');

        add_image_size( 'cupid_medium_thumbnail', 560, 345, true ); // Size 1/3, Ratio 2:1
        add_image_size( 'cupid_square_thumbnail', 600, 600, true ); // Size 1/1, Ratio 1:1


    }
}

add_action( 'after_setup_theme', 'cupid_theme_setup');


/**
 * Admin Bar
 */
function cupid_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu( array(
        'parent' => 'site-name', // use 'false' for a root menu, or pass the ID of the parent menu
        'id'     => 'smof_options', // link ID, defaults to a sanitized title value
        'title'  => __( 'Theme Options', 'cupid' ), // link title
        'href'   => admin_url( 'themes.php?page=optionsframework' ), // name of file
        'meta'   => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
    ) );
    $wp_admin_bar->add_menu( array(
        'parent' => 'site-name', // use 'false' for a root menu, or pass the ID of the parent menu
        'id'     => 'widget_sidebar', // link ID, defaults to a sanitized title value
        'title'  => __( 'Widgets', 'cupid' ), // link title
        'href'   => admin_url( 'widgets.php' ), // name of file
        'meta'   => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
    ) );
    $wp_admin_bar->add_menu( array(
        'parent' => 'site-name', // use 'false' for a root menu, or pass the ID of the parent menu
        'id'     => 'menus_sidebar', // link ID, defaults to a sanitized title value
        'title'  => __( 'Menus', 'cupid' ), // link title
        'href'   => admin_url( 'nav-menus.php' ), // name of file
        'meta'   => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
    ) );
}
add_action( 'wp_before_admin_bar_render', 'cupid_admin_bar_render' );

function cupid_ajax_url() {
    echo '<script type="text/javascript">
			var cupid_ajax_url ="' . get_site_url() . '/wp-admin/admin-ajax.php?activate-multi=true";
			var cupid_theme_url="'. THEME_URL .'";
			var cupid_site_url="'.site_url().'";
	</script>';
}
add_action( 'wp_print_scripts', 'cupid_ajax_url' );

function cupid_start_session() {
    if(!isset($_SESSION)) {
        session_start();
    }
}
add_action('init', 'cupid_start_session', 1);

add_action('after_switch_theme', 'cupid_setup_options');

function cupid_setup_options () {
    // reset Theme options
    global $of_options, $options_machine;
    $smof_data = of_get_options();
    if(!isset($smof_data) || !array_key_exists('smof_init',$smof_data) || empty($smof_data['smof_init'])){
        $options_machine = new Options_Machine($of_options);
        of_save_options($options_machine->Defaults);
    }


    // generate less to css
    require get_template_directory() . '/lib/inc-generate-less/generate-less.php';
    cupid_generate_less();
}

// Add to the allowed tags array and hook into WP comments
function cupid_allowed_tags() {
    global $allowedposttags;

    $allowedposttags['a']['data-hash'] = true;
    $allowedposttags['div']['data-plugin-options'] = true;
    $allowedposttags['div']['data-player'] = true;
    $allowedposttags['div']['data-audio'] = true;
    $allowedposttags['div']['data-title'] = true;

    $allowedposttags['textarea']['placeholder'] = true;


    $allowedposttags['iframe']['align'] = true;
    $allowedposttags['iframe']['frameborder'] = true;
    $allowedposttags['iframe']['height'] = true;
    $allowedposttags['iframe']['longdesc'] = true;
    $allowedposttags['iframe']['marginheight'] = true;
    $allowedposttags['iframe']['marginwidth'] = true;
    $allowedposttags['iframe']['name'] = true;
    $allowedposttags['iframe']['sandbox'] = true;
    $allowedposttags['iframe']['scrolling'] = true;
    $allowedposttags['iframe']['seamless'] = true;
    $allowedposttags['iframe']['src'] = true;
    $allowedposttags['iframe']['srcdoc'] = true;
    $allowedposttags['iframe']['width'] = true;
	$allowedposttags['iframe']['defer'] = true;

	$allowedposttags['input']['accept'] = true;
	$allowedposttags['input']['align'] = true;
	$allowedposttags['input']['alt'] = true;
	$allowedposttags['input']['autocomplete'] = true;
	$allowedposttags['input']['autofocus'] = true;
	$allowedposttags['input']['checked'] = true;
	$allowedposttags['input']['class'] = true;
	$allowedposttags['input']['disabled'] = true;
	$allowedposttags['input']['form'] = true;
	$allowedposttags['input']['formaction'] = true;
	$allowedposttags['input']['formenctype'] = true;
	$allowedposttags['input']['formmethod'] = true;
	$allowedposttags['input']['formnovalidate'] = true;
	$allowedposttags['input']['formtarget'] = true;
	$allowedposttags['input']['height'] = true;
	$allowedposttags['input']['list'] = true;
	$allowedposttags['input']['max'] = true;
	$allowedposttags['input']['maxlength'] = true;
	$allowedposttags['input']['min'] = true;
	$allowedposttags['input']['multiple'] = true;
	$allowedposttags['input']['name'] = true;
	$allowedposttags['input']['pattern'] = true;
	$allowedposttags['input']['placeholder'] = true;
	$allowedposttags['input']['readonly'] = true;
	$allowedposttags['input']['required'] = true;
	$allowedposttags['input']['size'] = true;
	$allowedposttags['input']['src'] = true;
	$allowedposttags['input']['step'] = true;
	$allowedposttags['input']['type'] = true;
	$allowedposttags['input']['value'] = true;
	$allowedposttags['input']['width'] = true;
	$allowedposttags['input']['accesskey'] = true;
	$allowedposttags['input']['class'] = true;
	$allowedposttags['input']['contenteditable'] = true;
	$allowedposttags['input']['contextmenu'] = true;
	$allowedposttags['input']['dir'] = true;
	$allowedposttags['input']['draggable'] = true;
	$allowedposttags['input']['dropzone'] = true;
	$allowedposttags['input']['hidden'] = true;
	$allowedposttags['input']['id'] = true;
	$allowedposttags['input']['lang'] = true;
	$allowedposttags['input']['spellcheck'] = true;
	$allowedposttags['input']['style'] = true;
	$allowedposttags['input']['tabindex'] = true;
	$allowedposttags['input']['title'] = true;
	$allowedposttags['input']['translate'] = true;

}
add_action('init', 'cupid_allowed_tags', 10);