<?php
function el_cupid_theme_setup() {
	register_nav_menus( array(
		'el-footer-menu-main' => __('Footer Menu Main', 'el_cupid'),
		'el-footer-menu-auxiliary' => __('Footer Menu Auxiliary', 'el_cupid'),
		'el-footer-menu-social-networks' => __('Footer Menu Social Networks', 'el_cupid'),
	) );
}
add_action( 'after_setup_theme', 'el_cupid_theme_setup');