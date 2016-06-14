<?php
function el_cupid_stylesheet(){
	wp_enqueue_style( 'el_cupid', get_template_directory_uri(). '/el-assets/sass/style.css' );
}
add_action('wp_enqueue_scripts','el_cupid_stylesheet', 11);


function el_cupid_script() {
	wp_enqueue_script('el_cupid', get_template_directory_uri() . '/el-assets/js/default.js');
}
add_action('wp_enqueue_scripts','el_cupid_script');