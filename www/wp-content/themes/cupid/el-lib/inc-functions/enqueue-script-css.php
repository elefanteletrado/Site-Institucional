<?php
function el_cupid_stylesheet(){
	$uri = get_template_directory_uri();
	wp_enqueue_style( 'el_cupid', $uri.'/el-assets/sass/style.css' );
	wp_enqueue_style( 'el_own_carousel', $uri.'/el-assets/owl.carousel/owl-carousel/owl.carousel.css' );
	wp_enqueue_style( 'el_own_carousel', $uri.'/el-assets/owl.carousel/owl-carousel/owl.theme.css' );
}
add_action('wp_enqueue_scripts','el_cupid_stylesheet', 11);


function el_cupid_script() {
	$uri = get_template_directory_uri();
	wp_enqueue_script( 'el_own_carousel', $uri.'/el-assets/owl.carousel/owl-carousel/owl.carousel.min.js' );
	wp_enqueue_script( 'el_cupid', $uri.'/el-assets/js/default.js' );
}
add_action('wp_enqueue_scripts','el_cupid_script');