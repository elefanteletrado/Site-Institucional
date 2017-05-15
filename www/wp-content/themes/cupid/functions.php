<?php
/**
 * G5Plus Theme Framework includes
 *
 * The $g5plus_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link http://g5plus.net
 */

define( 'HOME_URL', trailingslashit( home_url() ) );
define( 'THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'THEME_URL', trailingslashit( get_template_directory_uri() ) );



cupid_include_one();
// include lib for theme framework
function cupid_include_one() {
	$cupid_includes = array(
		'lib/install-demo/install-demo.php',
        'lib/meta-box.php', // meta-box
        'admin/index.php', // SMOF theme options
		'lib/common-lib.php', // Common functions
		'lib/widgets.php', // Utility functions
		'lib/sidebar.php', // Register Sidebar
        'lib/breadcrumb.php', // Register Sidebar
		'lib/ajax-action/search-ajax-action.php', // search ajax action
        'lib/ajax-action/register-ajax-action.php', // search ajax action
		'lib/ajax-action/login-link-action.php', // search ajax action
        'lib/template-tags.php', // Plugin installation and activation for WordPress themes
        'lib/filter.php', // register filter
		'lib/inc-generate-less/color.php', // color css
        'lib/inc-functions/class-tgm-plugin-activation.php', // Plugin installation and activation for WordPress themes
        'lib/inc-functions/theme-setup.php', // Plugin installation and activation for WordPress themes
        'lib/inc-functions/register-require-plugin.php', // Plugin installation and activation for WordPress themes
        'lib/inc-functions/enqueue-script-css.php', // Plugin installation and activation for WordPress themes
        'lib/inc-functions/use-less-js.php', // Plugin installation and activation for WordPress themes
		'lib/inc-functions/menu-mega.php', // Plugin installation and activation for WordPress themes
        'lib/woocommerce-lib.php', // Plugin installation and activation for WordPress themes

		'el-lib/theme-setup.php'
	);

	foreach ( $cupid_includes as $file ) {
		if ( ! $filepath = locate_template( $file ) ) {
			trigger_error( sprintf( __( 'Error locating %s for inclusion', 'cupid' ), $file ), E_USER_ERROR );
		}
		require_once $filepath;
	}
	unset( $file, $filepath );
}
function cupid_vc_remove_wp_admin_bar_button() {
    remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}
add_action( 'vc_after_init', 'cupid_vc_remove_wp_admin_bar_button' );

function wpb_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

function my_mce_before_init_insert_formats( $init_array ) {
    $style_formats = array(
        array(
            'title' => 'Citação 1',
            'block' => 'blockquote',
            'classes' => 'el-blog-blockquote',
            'wrapper' => true,
        ),
        array(
            'title' => 'Citação 2',
            'block' => 'blockquote',
            'classes' => 'el-blog-blockquote2',
            'wrapper' => true,
        ),
        array(
            'title' => 'Legenda de Imagem',
            'block' => 'span',
            'classes' => 'el-image-legend',
            'wrapper' => true,
        )
    );
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );