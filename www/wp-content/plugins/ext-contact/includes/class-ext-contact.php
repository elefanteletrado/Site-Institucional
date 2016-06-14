<?php
class Ext_Contact {
	public static function sendMail( $option_id, $insert ) {
		$option = get_option( 'ext_contact_type_item_' . $option_id );
		$dir_img = plugin_dir_url( EXT_CONTACT_FILE ) . 'email/images/';
		$admin_url = admin_url('admin.php?page=ext_contact_' . $option['name'] . '-list');
		ob_start();
		include EXT_CONTACT_DIR . 'email/view.php';
		$content = ob_get_clean();
		$option_subject = get_option( 'ext_contact_item_' . $option['subject_list'][$insert['assunto']]['id'] );
		$settings = get_option( 'exttheme_settings_options' );
		wp_mail( $option_subject['to'], '[' . get_bloginfo('name') . '] ' . $option['title']  . ' - ' . $option_subject['title'], $content, 'Content-Type: text/html; charset=utf-8' );
	}
	
	public static function filter_captcha_mode( $mode ) {
		switch( $mode ) {
			case EXT_CONTACT_CAPTCHA:
				if( !defined( 'EXT_CAPTCHA_FILE' ) || !ext_captcha_check_dependencies() ) {
					return 0;
				}
				break;
		}
		return $mode;
	}
}