<?php
/*
Plugin Name: Ext - Base de desenvolvimento
Description: Conjunto de funções e classes utilizadas por plugins para extender as funcionalidades do Wordpress.
Version: 1.2
Author: Luiz Felipe Bertoldi de Oliveira
*/
define( 'EXT_BASE_FILE', __FILE__ );
define( 'EXT_BASE_DIR', __DIR__ );
define( 'EXT_BASE_INCLUDE_DIR', EXT_BASE_DIR . '/includes' );
define( 'EXT_BASE_ADMIN', is_admin() && isset( $_REQUEST['page'] ) && strpos( $_REQUEST['page'], 'ext_base' ) !== false );

require EXT_BASE_INCLUDE_DIR.'/class-ext-base-model.php';
require EXT_BASE_INCLUDE_DIR.'/class-ext-base-list-table.php';
require EXT_BASE_INCLUDE_DIR.'/class-ext-base-debug.php';
require EXT_BASE_INCLUDE_DIR.'/class-ext-base-image.php';
require EXT_BASE_INCLUDE_DIR.'/class-ext-base-format.php';
require EXT_BASE_INCLUDE_DIR.'/class-ext-base-pagination.php';

if( is_admin() ) {
	require EXT_BASE_INCLUDE_DIR.'/class-ext-base-admin.php';

	$instance = Ext_Base_Admin::get_instance( __FILE__ );

	require_once ABSPATH.'wp-admin/includes/screen.php';

	register_activation_hook( __FILE__, array( $instance, 'activate' ) );

	add_action( 'admin_menu', array( $instance, 'menu' ) );
}