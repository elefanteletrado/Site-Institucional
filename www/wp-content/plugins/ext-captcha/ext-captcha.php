<?php
/*
Plugin Name: Ext - Captcha
Description: Personaliza o plugin Securimage-WP.
Version: 1.0
Author: Luiz Felipe Bertoldi de Oliveira
*/
define( 'EXT_CAPTCHA_FILE', __FILE__ );
define( 'EXT_CAPTCHA_DIR', dirname( EXT_CAPTCHA_FILE ) );

register_activation_hook( EXT_CAPTCHA_FILE, 'ext_captcha_activate' );

function ext_captcha_activate() {
	if( !ext_captcha_check_dependencies() ) {
		exit( 'Não foi possível ativar o plugin Ext Captcha porque as funções "siwp_validate_captcha_by_id" e "siwp_get_captcha_image_url" não foram encontradas. Certifique que o plugin Securimage-WP esteja instalado corretamente.' );
	}
}

function ext_captcha_check_dependencies() {
	return function_exists( 'siwp_validate_captcha_by_id' ) && function_exists( 'siwp_get_captcha_image_url' );
}

function ext_captcha_init() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'ext-captcha', plugin_dir_url( EXT_CAPTCHA_FILE ) . '/site/functions.captcha.js' );
	wp_enqueue_style( 'ext-captcha-style', plugin_dir_url( EXT_CAPTCHA_FILE ) . '/site/style.css' );
}

function ext_captcha_get_key( $prefix = '' ) {
	return sha1( uniqid( $prefix . $_SERVER['REMOTE_ADDR'] . $_SERVER['REMOTE_PORT'] ) );
}

function ext_captcha_show_html( $id ) {
	$key = uniqid();
	?>
	<div class="coluna-2d2">
		<label for="siwp_captcha_value">Código de Segurança (<strong>*</strong>):</label>
	</div>
	<br class="clr"/>
	<div class="f-left mg-right-10">
		<div class="ext-captcha-img-update" id="ext-captcha-img-update-<?php echo $key; ?>" data-key="<?php echo $key; ?>">
			&nbsp;
		</div>
	</div>
	<div class="coluna-2d2 no-margin">
		<a href="#" id="ext-captcha-update-<?php echo $key; ?>"
			data-key="<?php echo $key; ?>"
			data-url_key="<?php echo admin_url('admin-ajax.php?action=ext_captcha_show_key'); ?>"
			data-url_img="<?php echo siwp_get_captcha_image_url(); ?>"
			class="ext-captcha-update"> 
			Atualizar
		</a>
	</div>
	<br class="clr"/>
	<div class="coluna-2d2 mg-top-6">
		<input type="hidden" id="input_siwp_captcha_id" name="siwp_captcha_id" value="<?php echo $id; ?>" />
		<input class="campo-padrao" type="text" id="siwp_captcha_value" name="siwp_captcha_value" maxlength="100" required />
	</div>
	<?php
}

function ext_captcha_check( $id, $code ) {
	return siwp_validate_captcha_by_id($id, $code );
}

add_action( 'wp_ajax_nopriv_ext_captcha_show_key', 'ext_captcha_show_key' );
add_action( 'wp_ajax_ext_captcha_show_key', 'ext_captcha_show_key' );
function ext_captcha_show_key() {
	$id_old = $_REQUEST['id'];
	siwp_delete_captcha_id($id_old);
	echo ext_captcha_get_key();
	exit;
}