<?php
// Login Popup
function cupid_login_callback() {
ob_start();
?>
<div id="cupid-popup-login-wrapper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<form id="cupid-popup-login-form" class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="<?php _e('Close','cupid'); ?>"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php _e('Login','cupid'); ?></h4>
			</div>
			<div class="modal-body">
					<div class="cupid-popup-login-content">
						<div class="form-group">
							<label for="username"><?php _e('Username:','cupid') ?></label>
							<div class="input-icon">
								<input type="text" id="username" class="form-control"  name="username" required="required" placeholder="<?php _e('Username','cupid') ?>">
								<i class="fa fa-user"></i>
							</div>
						</div>
						<div class="form-group">
							<label for="password"><?php _e('Password:','cupid') ?></label>
							<div class="input-icon">
								<input type="password" id="password" name="password" class="form-control" required="required" placeholder="<?php _e('Password','cupid') ?>">
								<i class="fa fa-lock"></i>
							</div>
						</div>
						<div class="login-message"></div>
					</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="action" value="cupid_login_ajax"/>
				<div class="modal-footer-left">
					<input id="remember-me" type="checkbox" name="rememberme" checked="checked"/>
					<label for="remember-me" no-value="<?php _e('NO','cupid') ?>" yes-value="<?php _e('YES','cupid') ?>"></label>
					<?php _e('Remember me','cupid') ?>
				</div>
				<div class="modal-footer-right">
					<button type="submit" class="button" style="width: 100%"><?php echo __('Login','cupid'); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
die(); // this is required to return a proper result
}
add_action( 'wp_ajax_nopriv_cupid_login', 'cupid_login_callback' );
add_action( 'wp_ajax_cupid_login', 'cupid_login_callback' );

function cupid_login_ajax_callback () {
	ob_start();
	global $wpdb;

	//We shall SQL escape all inputs to avoid sql injection.
	$username = esc_sql($_REQUEST['username']);
	$password = esc_sql($_REQUEST['password']);
	$remember = esc_sql($_REQUEST['rememberme']);

	if($remember) $remember = "true";
	else $remember = "false";

	$login_data = array();
	$login_data['user_login'] = $username;
	$login_data['user_password'] = $password;
	$login_data['remember'] = $remember;
	$user_verify = wp_signon( $login_data, false );


	$code = 1;
	$message = '';

	if ( is_wp_error($user_verify) )
	{
		$message = $user_verify->get_error_message();
		$code = -1;
	}
	else {
		wp_set_current_user( $user_verify->ID, $username );
		do_action('set_current_user');
		$message = '';
	}

	$response_data = array(
		'code' 	=> $code,
		'message' 	=> $message
	);

	ob_end_clean();
	echo json_encode( $response_data );
	die(); // this is required to return a proper result
}
add_action( 'wp_ajax_nopriv_cupid_login_ajax', 'cupid_login_ajax_callback' );
add_action( 'wp_ajax_cupid_login_ajax', 'cupid_login_ajax_callback' );

//---------------------------------------------------
// SIGN UP Popup
//---------------------------------------------------
function cupid_sign_up_callback() {
	ob_start();
	?>
	<div id="cupid-popup-login-wrapper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<form id="cupid-popup-login-form" class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="<?php _e('Close','cupid'); ?>"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><?php _e('Sign Up','cupid'); ?></h4>
				</div>
				<div class="modal-body">
					<div class="cupid-popup-login-content">
						<div class="form-group">
							<label for="username"><?php _e('Username:','cupid') ?></label>
							<div class="input-icon">
								<input type="text" id="username" class="form-control"  name="username" required="required" placeholder="<?php _e('Username','cupid') ?>">
								<i class="fa fa-user"></i>
							</div>
						</div>
						<div class="form-group">
							<label for="email"><?php _e('Email:','cupid') ?></label>
							<div class="input-icon">
								<input type="email" id="email" name="email" class="form-control" required="required" placeholder="<?php _e('Email','cupid') ?>">
								<i class="fa fa-envelope"></i>
							</div>
						</div>
						<div><?php _e('A password will be e-mailed to you','cupid') ?></div>
						<div class="login-message"></div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="action" value="cupid_sign_up_ajax"/>
					<div class="modal-footer-right">
						<button type="submit" class="button" style="width: 100%"><?php echo __('Register','cupid'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php
	die(); // this is required to return a proper result
}
add_action( 'wp_ajax_nopriv_cupid_sign_up', 'cupid_sign_up_callback' );
add_action( 'wp_ajax_cupid_sign_up', 'cupid_sign_up_callback' );

function cupid_sign_up_ajax_callback () {
	include_once ABSPATH . WPINC . '/ms-functions.php';
	include_once ABSPATH . WPINC . '/user.php';

	ob_start();
	global $wpdb;

	//We shall SQL escape all inputs to avoid sql injection.
	$user_name = esc_sql($_REQUEST['username']);
	$user_email = esc_sql($_REQUEST['email']);


	$error = wpmu_validate_user_signup($user_name, $user_email);
	$code = 1;
	$message = '';
	if ($error['errors']->get_error_code() != '') {
		$code = -1;
		foreach ($error['errors']->get_error_messages() as $key => $value) {
			$message .= '<div/>' . __('<strong>ERROR:</strong> ','cupid') . esc_html($value) . '</div>';
		}
	}
	else {
		register_new_user($user_name, $user_email);
	}

	$response_data = array(
		'code' 	=> $code,
		'message' 	=> $message
	);

	ob_end_clean();
	echo json_encode( $response_data );
	die(); // this is required to return a proper result
}
add_action( 'wp_ajax_nopriv_cupid_sign_up_ajax', 'cupid_sign_up_ajax_callback' );
add_action( 'wp_ajax_cupid_sign_up_ajax', 'cupid_sign_up_ajax_callback' );

