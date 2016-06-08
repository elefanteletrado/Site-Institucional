<?php
function g5plus_register_sidebar() {
	register_sidebar( array(
		'name'          => __("Primary Widget Area",'cupid'),
		'id'            => 'primary-sidebar',
		'description'   => __("Primary Widget Area",'cupid'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );

	register_sidebar( array(
		'name'          => __("Footer 1 Widget Area",'cupid'),
		'id'            => 'footer-1-sidebar',
		'description'   => __("Footer 1 Widget Area",'cupid'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
	register_sidebar( array(
		'name'          => __("Footer 2 Widget Area",'cupid'),
		'id'            => 'footer-2-sidebar',
		'description'   => __("Footer 2 Widget Area",'cupid'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );
	register_sidebar( array(
		'name'          => __("Footer 3 Widget Area",'cupid'),
		'id'            => 'footer-3-sidebar',
		'description'   => __("Footer 3 Widget Area",'cupid'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title"><span>',
		'after_title'   => '</span></h4>',
	) );

    register_sidebar( array(
        'name'          => __("Archive Classes Widget Area",'cupid'),
        'id'            => 'archive-classes-left-sidebar',
        'description'   => __("Left Widget Area Display on Archive Classes",'cupid'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="widget-title"><span>',
        'after_title'   => '</span></h4>',
    ) );

    register_sidebar( array(
        'name'          => __("Shop Widget Area",'cupid'),
        'id'            => 'shop-sidebar',
        'description'   => __("Shop Widget Area",'cupid'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="widget-title"><span>',
        'after_title'   => '</span></h4>',
    ) );
}

add_action( 'widgets_init', 'g5plus_register_sidebar' );