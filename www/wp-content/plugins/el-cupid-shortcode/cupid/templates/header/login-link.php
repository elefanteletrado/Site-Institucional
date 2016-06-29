<?php
	global $cupid_data;
	$show_login_link = isset($cupid_data['show-login-link']) ? $cupid_data['show-login-link'] : 0;
?>
<?php if ($show_login_link):?>
	<div class="cupid-login-link">
		<ul>
			<?php if ( !is_user_logged_in() ):?>
				<li class="login-link"><a href="#"><i class="fa fa-key"></i> <?php _e('Login','cupid'); ?></a></li>
				<li class="sign-up-link"><a href="#"><i class="fa fa-lock"></i> <?php _e('Sign Up','cupid'); ?></a></li>
			<?php else:?>
				<li class="logout-link"><a href="<?php echo esc_url(wp_logout_url(is_home()? home_url() : get_permalink()) ); ?>"><i class="fa fa-power-off"></i> <?php _e('Logout','cupid'); ?></a></li>
			<?php endif;?>
		</ul>
	</div>
<?php endif;?>