<?php
/*
Plugin Name: Comscore Tag
Plugin URI: http://www.marcocanestrari.it
Description: Add Comscore tracking tag to your pages
Version: 1.0
Author: Marco Canestrari
Author URI: http://www.marcocanestrari.it
License: GPL2
*/

// some definition we will use
define( 'COMSCORE_PLUGIN_DIRECTORY', 'comscore-tag');
define( 'COMSCORE_LOCALE', 'comscore_language' );

// add menu item
add_action('admin_menu', 'comscore_menu');
add_action('wp_head','comscore_tag');

// register activation/deactivation hooks
register_uninstall_hook(__FILE__, 'comscore_uninstall');

// localization
comscore_set_lang_file();

// Menu item
function comscore_menu() {
	add_options_page( 'Comscore Settings', 'Comscore', 'manage_options', 'comscore-tag','comscore_config' );
}

// load language files
function comscore_set_lang_file() {
	# set the language file
	$currentLocale = get_locale();
	if(!empty($currentLocale)) {
		$moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
		if (@file_exists($moFile) && is_readable($moFile)) {
			load_textdomain(COMSCORE_LOCALE, $moFile);
		}

	}
}


// uninstalling
function comscore_uninstall() {
	# delete all data stored
	delete_option('comscore_settings');
	
}


/*
	Comscore Configuration page
*/
function comscore_config() {
	
	?>
	<div class="wrap">
	<?php
	
	
    
	if($_POST['comscore_settings']) {
		$nonce = $_REQUEST['_wpnonce'];
		$saved;
		if ( ! wp_verify_nonce( $nonce, 'comscore_settings_saved' ) ) {
			// This nonce is not valid.
			$saved = "nonce_error";			
		} else {
			update_option('comscore_settings', $_POST['comscore_settings']);
			$saved = "saved";
			
		}
		
		comscore_settings_saved($saved);
	}
	
	
	
	$comscore_settings = get_option('comscore_settings');
	$nonce = wp_create_nonce( 'comscore_settings_saved' );
	
	?>

	<h2><?=__('Comscore settings',COMSCORE_LOCALE)?></h2>
	<form method="post" action="">
		<label for="comscore_settings['C2']" ><?=__('Comscore Primary ID (C2)',COMSCORE_LOCALE)?></label> <input type="text" name="comscore_settings[C2]" value="<?=$comscore_settings[C2]?>" />
		<input type="hidden" name="_wpnonce" value="<?=$nonce?>" />
	<?php submit_button(); ?>
	</form>
	
	<?php
	echo '	<div style="text-align: center;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="675M7SC9CN9BN">
			<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal Ð The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
			</form>

		</div>';
	?>
	
	</div>
	<?php
	
}

/*
	Shows alert messages
*/
function comscore_settings_saved($saved) {
	
	switch ($saved) {
		
		case 'saved':
			echo '<div id="pg-warning" class="updated fade"><p><strong>Comscore Tag: </strong>'.__("new settings saved",COMSCORE_LOCALE ) .'.</p></div>';
			break;
		case 'nonce_error':
			echo '<div id="pg-warning" class="error fade"><p><strong>Comscore Tag: </strong>'.__("settings not saved due to not valid nonce",COMSCORE_LOCALE ) .'.</p></div>';
			break;
		
	}
	
	
	
}

function comscore_tag() {
	
	$comscore_settings = get_option('comscore_settings');
	if($comscore_settings[C2]) {
		?>

		<!-- Begin comScore Tag -->
		<script>
		document.write(unescape("%3Cscript src='" + (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js' %3E%3C/script%3E"));
		</script>
		<script>
		COMSCORE.beacon({
		c1:2, c2:"<?=$comscore_settings[C2]?>", c3:"", c4:"", c5:"", c6:"", c15:""
		}); </script>
		<noscript>
		<img src="http://b.scorecardresearch.com/p?c1=2&c2=<?=$comscore_settings[C2]?>&c3=&c4=&c5=&c6=&c15=&cj=1" />
		</noscript>
		<!-- End comScore Tag -->
		
		<?php
	}
}

?>
