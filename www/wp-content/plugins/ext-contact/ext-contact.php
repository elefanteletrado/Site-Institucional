<?php
/*
Plugin Name: Ext - Contato
Description: Formulário de contato com consulta local de dados e aviso de novos contatos por e-mail.
Version: 1.4
Author: CWI Software - Luiz Felipe Bertoldi de Oliveira
Author URI: http://www.cwi.com.br
*/
define( 'EXT_CONTACT_FILE', __FILE__ );
define( 'EXT_CONTACT_DIR', __DIR__ . '/' );
define( 'EXT_CONTACT_INCLUDE_DIR', __DIR__ . '/includes/' );
define( 'EXT_CONTACT_ADMIN', is_admin() && isset( $_REQUEST['page'] ) && strpos( $_REQUEST['page'], 'ext_contact' ) !== false );
define( 'EXT_CONTACT_CAPTCHA', 2 );
define( 'EXT_CONTACT_RECAPTCHA', 1 );
define( 'EXT_CONTACT_MULTIPLE_SUBJECTS', true );
define( 'EXT_CONTACT_CODE_ALL_SUBJECTS', 9 );
define( 'EXT_CONTACT_SUBJECT_EDIT', false );
define( 'EXT_CONTACT_SUBJECT_DEMO', 6 );
define( 'EXT_CONTACT_SUBJECT_CONTACT', 7 );

require_once EXT_CONTACT_INCLUDE_DIR . 'site-functions.php';

if( EXT_CONTACT_ADMIN ) {
	require EXT_CONTACT_INCLUDE_DIR . 'class-ext-contact-model.php';
}
if( is_admin() ) {
	require EXT_CONTACT_INCLUDE_DIR . 'class-ext-contact-admin.php';
	
	$instance = Ext_Contact_Admin::get_instance( __FILE__ );
	
	require_once ABSPATH . 'wp-admin/includes/screen.php';
	
	register_activation_hook( __FILE__, array($instance, 'activate') );
	
	register_deactivation_hook( __FILE__, array($instance, 'deactivate') );
	
	add_filter( 'map_meta_cap', array($instance, 'map_meta_cap'), 10, 4 );
	
	add_action( 'admin_menu', array($instance, 'menu') );
}