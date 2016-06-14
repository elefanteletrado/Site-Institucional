<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */


add_filter( 'rwmb_meta_boxes', 'g5plus_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * Remember to change "your_prefix" to actual prefix in your project
 *
 * @return void
 */
function g5plus_register_meta_boxes( $meta_boxes )
{
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'g5plus-';
	// Post Format
	$meta_boxes[] = array(
		'title'  => __('Post Format: Image','cupid'),
		'id'     => $prefix. 'meta-box-post-format-image',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name'             => __( 'Image', 'cupid' ),
				'id'               => 'post-format-image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
		),
	);

	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Gallery', 'cupid' ),
		'id'     => $prefix. 'meta-box-post-format-gallery',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => __( 'Images', 'cupid' ),
				'id'   => 'post-format-gallery',
				'type' => 'image_advanced',
			),
		),
	);

	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Video', 'cupid' ),
		'id'     => $prefix. 'meta-box-post-format-video',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => __( 'Video URL or Embeded Code', 'cupid' ),
				'id'   => 'post-format-video',
				'type' => 'textarea',
			),
		)
	);

	$meta_boxes[] = array(
		'title'  => __( 'Post Format: Audio', 'cupid' ),
		'id'     => $prefix. 'meta-box-post-format-audio',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => __( 'Audio URL or Embeded Code', 'cupid' ),
				'id'   => 'post-format-audio',
				'type' => 'textarea',
			),
		)
	);




	// Display Settings
	$meta_boxes[] = array(
		'title'  => __( 'Page Settings', 'cupid' ),
		'pages'  => array( 'page','post' ),
		'fields' => array(
			array(
				'name' => __( 'Page Title Area', 'cupid' ),
				'id'   => 'heading-title',
				'type' => 'heading',
			),
            array(
                'name'  => __( 'Hide Page Title Area?', 'cupid' ),
                'id'    => 'hide-page-title',
                'type'  => 'checkbox',
                'class' => 'checkbox-toggle reverse',
            ),

			array(
				'name'   => __( 'Custom Page Title', 'cupid' ),
				'id'     => 'custom-page-title',
				'type'   => 'text',
				'desc'   => __( 'Leave empty to use post title', 'cupid' ),
                'before'  => '<div>'
			),

			array(
				'name'   => __( 'Custom Page Sub Title', 'cupid' ),
				'id'     => 'custom-page-sub-title',
				'type'   => 'text',
                'after' => '</div>'
			),

			array(
				'name' => __( 'Custom Layout', 'cupid' ),
				'id'   => 'heading-layout',
				'type' => 'heading'
            ),
			array(
				'name'  => __( 'Use Custom Layout?', 'cupid' ),
				'id'    => 'use-custom-layout',
				'type'  => 'checkbox',
				'class' => 'checkbox-toggle',
				'desc'  => sprintf( __( 'This will <b>overwrite</b> layout settings in <a href="%s" target="_blank">Theme Options</a> with values different <b>none</b>.', 'cupid' ), admin_url( 'themes.php?page=optionsframework' ) ),
			),
			array(
				'name'     => __( 'Select Layout Style', 'cupid' ),
				'id'       => "layout-style",
				'type'     => 'select',
				'options'  => array(
					'none' => __('None','cupid'),
					'wide' => __( 'Wide', 'cupid' ),
					'boxed' => __( 'Boxed', 'cupid' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'none',
				'before'  => '<div>'
			),
			array(
				'name'    => __( 'Page Layout', 'cupid' ),
				'id'      => 'page-layout',
				'type'    => 'select',
				'std'     => 'none',
				'options' => array(
					'none' => 'None',
					'full-content'  => __('Full Width','cupid'),
                    'container-full-content'  => __('Container Full Width','cupid'),
					'left-sidebar'  => __('Left Sidebar','cupid'),
					'right-sidebar' => __('Right Sidebar','cupid'),
				),
				'after'   => '</div>'
			),

            array(
                'name' => __( 'Custom Header', 'cupid' ),
                'id'   => 'custom-header',
                'type' => 'heading'
            ),

            array(
                'name'    => __( 'Logo', 'cupid' ),
                'id'      => 'site-logo',
                'type'    => 'file_input',
                'std'     => '',
            ),

            array(
                'name'    => __( 'Header Layout', 'cupid' ),
                'id'      => 'header-layout',
                'type'    => 'select',
                'std'     => 'none',
                "options" => array(
                    'none' => 'Default',
                    '1' =>  'Header-1',
                    '2' =>  'Header-2',
                    '3' =>  'Header-3',
                    '4' =>  'Header-4',
                    '5' => 'Header-5',
                    '6' =>  'Header-6'
                ),
            ),
            array(
                'name'    => __( 'Site Top Layout', 'cupid' ),
                'id'      => 'site-top-layout',
                'type'    => 'select',
                'std'     => 'none',
                "options" => array(
                    'none' => 'Default',
                    '1' =>  'Layout-1',
                    '2' =>  'Layout-2',
                    '3' =>  'Layout-3',
                    '4' =>  'Layout-4'
                ),
            ),


            array(
                'name' => __( 'Custom Color', 'cupid' ),
                'id'   => 'custom-color',
                'type' => 'heading'
            ),
            array(
                'name'     => __( 'Primary Color', 'cupid' ),
                'id'       => "primary-color",
                'type'     => 'color',
                'std'         => '',
            ),
            array(
                'name'     => __( 'Secondary Color', 'cupid' ),
                'id'       => "secondary-color",
                'type'     => 'color',
                'std'         => '',
            ),
            array(
                'name'     => __( 'Button Color', 'cupid' ),
                'id'       => "button-color",
                'type'     => 'color',
                'std'         => '',
            ),
            array(
                'name'     => __( 'Bullet Color', 'cupid' ),
                'id'       => "bullet-color",
                'type'     => 'color',
                'std'         => '',
            ),

            array(
                'name'     => __( 'IconBox Color', 'cupid' ),
                'id'       => "icon-box-color",
                'type'     => 'color',
                'std'         => '',
            ),




		)
	);

	return $meta_boxes;
}

add_action( 'admin_enqueue_scripts', 'g5plus_admin_script_meta_box' );

function g5plus_admin_script_meta_box() {
	$screen = get_current_screen();
	if ( ! in_array( $screen->post_type, array( 'post', 'page') ) ) {
		return;
	}
	wp_enqueue_script( 'g5plus-meta-box', THEME_URL . 'assets/admin/js/meta-boxes.js', array( 'jquery' ), '', true );
}