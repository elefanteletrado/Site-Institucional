<?php

add_action( 'init', 'of_options' );

if ( ! function_exists( 'of_options' ) ) {
	function of_options() {
		//Access the WordPress Categories via an Array
		$of_categories     = array();
		$of_categories_obj = get_categories( 'hide_empty=0' );
		foreach ( $of_categories_obj as $of_cat ) {
			$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
		}
		$categories_tmp = array_unshift( $of_categories, "Select a category:" );

		//Access the WordPress Pages via an Array
		$of_pages     = array();
		$of_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
		foreach ( $of_pages_obj as $of_page ) {
			$of_pages[$of_page->ID] = $of_page->post_name;
		}
		$of_pages_tmp = array_unshift( $of_pages, "Select a page:" );

		//Testing 
		$of_options_select = array( "one", "two", "three", "four", "five" );
		$of_options_radio  = array( "one" => "One", "two" => "Two", "three" => "Three", "four" => "Four", "five" => "Five" );

		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		(
			"disabled" => array(
				"placebo"     => "placebo", //REQUIRED!
				"block_one"   => "Block One",
				"block_two"   => "Block Two",
				"block_three" => "Block Three",
			),
			"enabled"  => array(
				"placebo"    => "placebo", //REQUIRED!
				"block_four" => "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets     = array();

		if ( is_dir( $alt_stylesheet_path ) ) {
			if ( $alt_stylesheet_dir = opendir( $alt_stylesheet_path ) ) {
				while ( ( $alt_stylesheet_file = readdir( $alt_stylesheet_dir ) ) !== false ) {
					if ( stristr( $alt_stylesheet_file, ".css" ) !== false ) {
						$alt_stylesheets[] = $alt_stylesheet_file;
					}
				}
			}
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory() . '/assets/images/patterns/'; // change this to where you store your patterns images
        if(!is_dir( $bg_images_path )){
            $bg_images_path = get_template_directory() . '/assets/images/patterns/';
        }
		$bg_images_url  = get_template_directory_uri() . '/assets/images/patterns/'; // change this to where you store your patterns images
		$bg_images      = array();

		if ( is_dir( $bg_images_path ) ) {
			if ( $bg_images_dir = opendir( $bg_images_path ) ) {
				while ( ( $bg_images_file = readdir( $bg_images_dir ) ) !== false ) {
					if ( stristr( $bg_images_file, ".png" ) !== false || stristr( $bg_images_file, ".jpg" ) !== false ) {
						natsort( $bg_images ); //Sorts the array into a natural order
						$bg_images[] = $bg_images_url . $bg_images_file;
					}
				}
			}
		}


		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/

		//More Options
		$uploads_arr      = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads      = get_option( 'of_uploads' );
		$other_entries    = array( "Select a number:", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" );
		$body_repeat      = array( "no-repeat", "repeat-x", "repeat-y", "repeat" );
		$body_pos         = array( "top left", "top center", "top right", "center left", "center center", "center right", "bottom left", "bottom center", "bottom right" );

		// Image Alignment radio box
		$of_options_thumb_align = array( "alignleft" => "Left", "alignright" => "Right", "aligncenter" => "Center" );

		// Image Links to Options
		$of_options_image_link_to = array( "image" => "The Image", "post" => "The Post" );


		/*-----------------------------------------------------------------------------------*/
		/* The Options Array */
		/*-----------------------------------------------------------------------------------*/

// Set the Options Array
		global $of_options;
		$of_options = array();

		/*General Settings*/
		$of_options[] = array( "name" => __( 'General Settings', 'cupid' ),
							   "type" => "heading",
							   "icon" => ADMIN_IMAGES . "icon-settings.png"
		);
		$logo         = THEME_URL . 'assets/images/logo.png';

		$of_options[] = array( "name" => __( 'Logo', 'cupid' ),
							   "desc" => __( 'Enter URL or Upload an image file as your logo.', 'cupid' ),
							   "id"   => "site-logo",
							   "std"  => $logo,
							   "type" => "media"
		);

		$logo_second  = THEME_URL . 'assets/images/logo-white.png';
		$of_options[] = array( "name" => __( 'Logo Footer', 'cupid' ),
							   "desc" => __( 'Enter URL or Upload an image file as your logo.', 'cupid' ),
							   "id"   => "site-logo-white",
							   "std"  => $logo_second,
							   "type" => "media"
		);

		$favicon      = THEME_URL . 'assets/images/favicon.ico';
		$of_options[] = array( "name" => __( 'Favicon', 'cupid' ),
							   "desc" => __( "Enter URL or upload an icon image to represent your website's favicon (16px x 16px)", 'cupid' ),
							   "id"   => "favicon",
							   "std"  => $favicon,
							   "type" => "media"
		);


		$of_options[] = array( "name"    => __( 'Archive Paging Style', 'cupid' ),
							   "desc"    => __( 'Select paging style for Archive Page', 'cupid' ),
							   "id"      => "post-archive-paging-style",
							   "std"     => "default",
							   "type"    => "select",
							   "options" => array(
								   'default'         => 'Default',
								   'load-more'       => 'Load More',
								   'infinite-scroll' => 'Infinite Scroll'
							   )
		);


		$url          = ADMIN_DIR . 'assets/images/';
		$of_options[] = array( "name"    => __( 'Archive Layout', 'cupid' ),
							   "desc"    => __( 'Select layout for Archive Page', 'cupid' ),
							   "id"      => "post-archive-layout",
							   "std"     => "right-sidebar",
							   "type"    => "images",
							   "options" => array(
								   'full-content'  => $url . '1col.png',
								   'left-sidebar'  => $url . '2cl.png',
								   'right-sidebar' => $url . '2cr.png'
							   )
		);

		$of_options[] = array( "name"    => __( 'Page Layout', 'cupid' ),
							   "desc"    => __( 'Select layout for Page', 'cupid' ),
							   "id"      => "page-layout",
							   "std"     => "right-sidebar",
							   "type"    => "images",
							   "options" => array(
								  /* 'full-content'  => $url . '1col.png',*/
                                   'container-full-content'  => $url . '3cm.png',
                                   'left-sidebar'  => $url . '2cl.png',
								   'right-sidebar' => $url . '2cr.png'
							   )
		);


		$of_options[] = array( "name" => __( 'Show Back To Top', 'cupid' ),
							   "id"   => __( 'show-back-to-top', 'cupid' ),
							   "std"  => 1,
							   "type" => "switch",
							   "on"   => "Show",
							   "off"  => "Hide"
		);

        $of_options[] = array( "name" => __( 'Show Loading', 'cupid' ),
            "id"   => __( 'show-loading', 'cupid' ),
            "std"  => 1,
            "type" => "switch",
            "on"   => "Show",
            "off"  => "Hide"
        );



        $of_options[] = array( "name" => __( 'Archive Classes sub title', 'cupid' ),
            "id"   => "archive_classes_sub_title",
            "std"  => "",
            "type" => "text"
        );

        /*Page 404 Options*/
        $of_options[] = array( "name" => __( '404 Options', 'cupid' ),
            "type" => "heading",
            "icon" => ADMIN_IMAGES . "icon-header.png"
        );

        $of_options[] = array( "name" => __( 'Url Support Forum', 'cupid' ),
            "id"   => "url-support-forum",
            "std"  => "",
            "type" => "text"
        );

        $of_options[] = array( "name" => __( 'Phone Contact', 'cupid' ),
            "id"   => "phone",
            "std"  => "",
            "type" => "text"
        );
        $page_404_bg = THEME_URL . 'assets/images/404.jpg';
        $of_options[] = array( "name" => __( '404 Background', 'cupid' ),
            "desc" => __( "Enter URL or upload an image to set background for 404 page", 'cupid' ),
            "id"   => "page-404-background",
            "std"  => $page_404_bg,
            "type" => "media"
        );

		/*Site Top Options*/
		$of_options[] = array( "name" => __( 'Site Top Options', 'cupid' ),
							   "type" => "heading",
							   "icon" => ADMIN_IMAGES . "icon-header.png"
		);

		$of_options[] = array( "name"  => __( 'Show Site Top', 'cupid' ),
							   "desc"  => "",
							   "id"    => "show-site-top",
							   "std"   => 1,
							   "type"  => "switch"
		);

		$of_options[] = array( "name"    => __( 'Site Top Layout', 'cupid' ),
							   "desc"    => __( 'Select layout for Site Top', 'cupid' ),
							   "id"      => "site-top-layout",
							   "std"     => "1",
							   "type"    => "images",
							   "options" => array(
								   '1' => $url . 'header/site-top-1.jpg',
								   '2' => $url . 'header/site-top-2.jpg',
								   '3' => $url . 'header/site-top-3.jpg',
								   '4' => $url . 'header/site-top-4.jpg',
							   )
		);

		$of_options[] = array( "name"  => __( 'Show Language Selector', 'cupid' ),
							   "desc"  => "",
							   "id"    => "show-language-selector",
							   "std"   => 1,
							   "type"  => "switch"
		);

		$of_options[] = array( "name"  => __( 'Show Login Link', 'cupid' ),
							   "desc"  => "",
							   "id"    => "show-login-link",
							   "std"   => 1,
							   "type"  => "switch"
		);

		$of_options[] = array( "name"  => __( 'Site Top Content', 'cupid' ),
							   "desc"  => "",
							   "id"    => "site-top-content",
							   "std"   => '<ul><li><i class="fa fa-phone-square"></i>HOTLINE: (+84)98 902 9128</li></ul>',
							   "type"  => "textarea"
		);


		/*Header Options*/
		$of_options[] = array( "name" => __( 'Header Options', 'cupid' ),
							   "type" => "heading",
							   "icon" => ADMIN_IMAGES . "icon-header.png"
		);


		$of_options[] = array( "name"    => __( 'Header Layout', 'cupid' ),
							   "desc"    => __( 'Select layout for Header', 'cupid' ),
							   "id"      => "header-layout",
							   "std"     => "1",
							   "type"    => "images",
							   "options" => array(
								   '1' => $url . 'header/header-1.jpg',
								   '2' => $url . 'header/header-2.jpg',
                                   '3' => $url . 'header/header-3.jpg',
                                   '4' => $url . 'header/header-4.jpg',
                                   '5' => $url . 'header/header-5.jpg',
                                   '6' => $url . 'header/header-6.jpg'
							   )
		);
		$of_options[] = array( "name"  => __( 'Show Search Button', 'cupid' ),
							   "desc"  => "",
							   "id"    => "show-search-button",
							   "std"   => 1,
							   "type"  => "switch"
		);

		$of_options[] = array( "name"  => __( 'Show Mini Cart', 'cupid' ),
							   "desc"  => "",
							   "id"    => "show-mini-cart",
							   "std"   => 1,
							   "type"  => "switch"
		);

		/*Footer Options*/

        $of_options[] = array( 	"name" 		=> __('Footer Options','cupid'),
            "type" 		=> "heading",
            "icon" 		=> ADMIN_IMAGES . "icon-footer.png"
        );

		$of_options[] = array( "name" => __( 'Copyright Text', 'cupid' ),
							   "desc" => __( 'You can use the following shortcodes in your footer text: [wp-link] [theme-link] [loginout-link] [blog-title] [blog-link] [the-year]', 'cupid' ),
							   "id"   => "copyright-text",
							   "std"  => "Powered by <a href=\"http://wordpress.org\">WordPress</a>. Built on the <a href=\"http://g5plus.net\">G5Plus</a>.",
							   "type" => "textarea"
		);
		/*Styling Options*/
		$of_options[] = array( "name" => __( 'Styling Options', 'cupid' ),
							   "type" => "heading"
		);

		$of_options[] = array( "name"    => __( 'Layout Style', 'cupid' ),
							   "desc"    => __( 'Select a layout', 'cupid' ),
							   "id"      => "layout-style",
							   "std"     => "wide",
							   "type"    => "radio",
							   "options" => array(
								   'boxed' => 'Boxed',
								   'wide'  => 'Wide',
							   ) );


		$of_options[] = array( "name"  => __( 'Background Images', 'cupid' ),
							   "desc"  => "",
							   "id"    => "use-bg-image",
							   "std"   => 0,
							   "folds" => 1,
							   "type"  => "switch"
		);

		$of_options[] = array( "name"    => __( 'Background Pattern', 'cupid' ),
							   "desc"    => __( 'Select a background pattern.', 'cupid' ),
							   "id"      => "bg-pattern",
							   "type"    => "tiles",
							   "options" => $bg_images,
							   "fold"    => "use-bg-image",
							   "std"     => $bg_images[1]
		);

		$of_options[] = array( "name" => __( 'Upload Background', 'cupid' ),
							   "desc" => __( 'Upload your own background', 'cupid' ),
							   "id"   => "bg-pattern-upload",
							   "std"  => THEME_URL . '/assets/images/bg-images/bg-0.jpg',
							   "type" => "upload",
							   "fold" => "use-bg-image"
		);

		$of_options[] = array( "name"    => __( 'Background Repeat', 'cupid' ),
							   "desc"    => "",
							   "id"      => "bg-repeat",
							   "std"     => "no-repeat",
							   "type"    => "select",
							   "options" => array( 'repeat' => __( 'repeat', 'cupid' ), 'repeat-x' => __( 'repeat-x', 'cupid' ), 'repeat-y' => __( 'repeat-y', 'cupid' ), 'no-repeat' => __( 'no-repeat', 'cupid' ) ),
							   "fold"    => "use-bg-image"
		);
		$of_options[] = array( "name"    => __( 'Background Position', 'cupid' ),
							   "desc"    => "",
							   "id"      => "bg-position",
							   "std"     => "center center",
							   "type"    => "select",
							   "options" => array( 'left top'      => __( 'left top', 'cupid' ),
												   'left center'   => __( 'left center', 'cupid' ),
												   'left bottom'   => __( 'left bottom', 'cupid' ),
												   'right top'     => __( 'right top', 'cupid' ),
												   'right center'  => __( 'right center', 'cupid' ),
												   'right bottom'  => __( 'right bottom', 'cupid' ),
												   'center top'    => __( 'center top', 'cupid' ),
												   'center center' => __( 'center center', 'cupid' ),
												   'center bottom' => __( 'center bottom', 'cupid' )
							   ),
							   "fold"    => "use-bg-image"
		);
		$of_options[] = array( "name"    => __( 'Background Attachment', 'cupid' ),
							   "desc"    => "",
							   "id"      => "bg-attachment",
							   "std"     => "fixed",
							   "type"    => "select",
							   "options" => array( 'scroll'  => __( 'scroll', 'cupid' ),
												   'fixed'   => __( 'fixed', 'cupid' ),
												   'local'   => __( 'local', 'cupid' ),
												   'initial' => __( 'initial', 'cupid' ),
												   'inherit' => __( 'inherit', 'cupid' )
							   ),
							   "fold"    => "use-bg-image"
		);
		$of_options[] = array( "name"    => __( 'Background Size', 'cupid' ),
							   "desc"    => "",
							   "id"      => "bg-size",
							   "std"     => "cover",
							   "type"    => "select",
							   "options" => array( 'auto'    => __( 'auto', 'cupid' ),
												   'cover'   => __( 'cover', 'cupid' ),
												   'contain' => __( 'contain', 'cupid' ),
												   'initial' => __( 'initial', 'cupid' ),
												   'inherit' => __( 'inherit', 'cupid' )
							   ),
							   "fold"    => "use-bg-image"
		);

		$of_options[] = array( "name" => __( 'Primary Color', 'cupid' ),
							   "desc" => __( 'Pick a primary color for the theme.', 'cupid' ),
							   "id"   => "primary-color",
							   "std"  => "#D93F63",
							   "type" => "color"
		);

		$of_options[] = array( "name" => __( 'Secondary Color', 'cupid' ),
							   "desc" => __( 'Pick a secondary color for the theme.', 'cupid' ),
							   "id"   => "secondary-color",
							   "std"  => "#FFA73C",
							   "type" => "color"
		);

		$of_options[] = array( "name" => __( 'Button Color', 'cupid' ),
							   "desc" => __( 'Pick a button color for the theme.', 'cupid' ),
							   "id"   => "button-color",
							   "std"  => "#D93F63",
							   "type" => "color"
		);

		$of_options[] = array( "name" => __( 'Bullet Color', 'cupid' ),
							   "desc" => __( 'Pick a bullet color for the theme.', 'cupid' ),
							   "id"   => "bullet-color",
							   "std"  => "#A273B9",
							   "type" => "color"
		);

		$of_options[] = array( "name" => __( 'Icon Box Color', 'cupid' ),
							   "desc" => __( 'Pick a icon box color for the theme.', 'cupid' ),
							   "id"   => "icon-box-color",
							   "std"  => "#FFA73C",
							   "type" => "color"
		);

		/*Social Sharing Box*/
		$of_options[] = array( "name" => __( 'Social', 'cupid' ),
							   "type" => "heading",
							   "icon" => ADMIN_IMAGES . "icon-header.png"
		);


		$of_options[] = array( "name"    => __( 'Social Sharing Box', 'cupid' ),
							   "desc"    => __( 'Show the social sharing in blog posts.', 'cupid' ),
							   "id"      => "social-sharing",
							   "type"    => "multicheck",
							   "std"     => array( "sharing-facebook", "sharing-twitter", "sharing-google" ),
							   "options" => array( "sharing-facebook" => __( 'Facebook', 'cupid' ), "sharing-twitter" => __( 'Twitter', 'cupid' ), "sharing-google" => __( 'Google', 'cupid' ), "sharing-linkedin" => __( 'LinkedIn', 'cupid' ), "sharing-tumblr" => __( 'Tumblr', 'cupid' ), "sharing-pinterest" => __( 'Pinterest', 'cupid' ) )
		);
		/*Social Link*/
		$of_options[] = array( "name" => __( 'Email Link', 'cupid' ),
							   "id"   => "social-email-link",
							   "std"  => "#",
							   "type" => "text"
		);
		$of_options[] = array( "name" => __( 'LinkedIn Link', 'cupid' ),
							   "id"   => "social-linkedin-link",
							   "std"  => "#",
							   "type" => "text"
		);
		$of_options[] = array( "name" => __( 'Facebook Link', 'cupid' ),
							   "id"   => "social-face-link",
							   "std"  => "#",
							   "type" => "text"
		);

		$of_options[] = array( "name" => __( 'Twitter Link', 'cupid' ),
							   "id"   => "social-twitter-link",
							   "std"  => "#",
							   "type" => "text"
		);
		$of_options[] = array( "name" => __( 'Dribbble Link', 'cupid' ),
							   "id"   => "social-dribbble-link",
							   "std"  => "#",
							   "type" => "text"
		);


		$of_options[] = array( "name" => __( 'Google Link', 'cupid' ),
							   "id"   => "social-google-link",
							   "std"  => "",
							   "type" => "text"
		);

		$of_options[] = array( "name" => __( 'Vimeo Link', 'cupid' ),
							   "id"   => "social-vimeo-link",
							   "std"  => "",
							   "type" => "text"
		);
		$of_options[] = array( "name" => __( 'Pinterest Link', 'cupid' ),
							   "id"   => "social-pinteres-link",
							   "std"  => "",
							   "type" => "text"
		);
		$of_options[] = array( "name" => __( 'Youtube Link', 'cupid' ),
							   "id"   => "social-youtube-link",
							   "std"  => "",
							   "type" => "text"
		);
		$of_options[] = array( "name" => __( 'Instagram Link', 'cupid' ),
							   "id"   => "social-instagram-link",
							   "std"  => "",
							   "type" => "text"
		);


        /*WooCommerce*/
        $of_options[] = array( "name" => __( 'WooCommerce', 'cupid' ),
            "type" => "heading",
            "icon" => ADMIN_IMAGES . "woo_icon.png"
        );

        $of_options[] = array( "name"    => __( 'Archive Product Layout', 'cupid' ),
            "desc"    => __( 'Select layout for Archive Product Page', 'cupid' ),
            "id"      => "product-archive-layout",
            "std"     => "left-sidebar",
            "type"    => "images",
            "options" => array(
                'full-content'  => $url . '1col.png',
                'left-sidebar'  => $url . '2cl.png',
                'right-sidebar' => $url . '2cr.png'
            )
        );



		/*Typography*/
		$of_options[] = array( "name" => __( 'Typography', 'cupid' ),
							   "type" => "heading",
							   "icon" => ADMIN_IMAGES . "icon-typography.gif"

		);
		$of_options[] = array( "name" => __( 'Body Font', 'cupid' ),
							   "desc" => __( 'Specify the body font properties', 'cupid' ),
							   "id"   => "body-font",
							   "std"  => array( 'face' => 'Proxima Nova', 'size' => '15px', 'weight' => 'normal', 'face-type' => '0' ),
							   "type" => "typography"
		);

		$of_options[] = array( "name" => __( 'Heading Options', 'cupid' ),
							   "desc" => "",
							   "id"   => "heading-font",
							   "std"  => array( 'face' => 'Proxima Nova', 'face-type' => '0' ),
							   "type" => "typography"
		);

		$of_options[] = array( "name" => __( 'Font H1', 'cupid' ),
							   "desc" => "",
							   "id"   => "h1-font",
							   "std"  => array( 'face' => '', 'size' => '30px', 'style' => 'normal', 'weight' => '600', 'text-transform' => 'none' ),
							   "type" => "typography"
		);
		$of_options[] = array( "name" => __( 'Font H2', 'cupid' ),
							   "desc" => "",
							   "id"   => "h2-font",
							   "std"  => array( 'face' => '', 'size' => '28px', 'style' => 'normal', 'weight' => '600', 'text-transform' => 'none' ),
							   "type" => "typography"
		);
		$of_options[] = array( "name" => __( 'Font H3', 'cupid' ),
							   "desc" => "",
							   "id"   => "h3-font",
							   "std"  => array( 'face' => '', 'size' => '26px', 'style' => 'normal', 'weight' => '600', 'text-transform' => 'none' ),
							   "type" => "typography"
		);
		$of_options[] = array( "name" => __( 'Font H4', 'cupid' ),
							   "desc" => "",
							   "id"   => "h4-font",
							   "std"  => array( 'face' => '', 'size' => '24px', 'style' => 'normal', 'weight' => '600', 'text-transform' => 'none' ),
							   "type" => "typography"
		);
		$of_options[] = array( "name" => __( 'Font H5', 'cupid' ),
							   "desc" => "",
							   "id"   => "h5-font",
							   "std"  => array( 'face' => '', 'size' => '22px', 'style' => 'normal', 'weight' => '600', 'text-transform' => 'none' ),
							   "type" => "typography"
		);
		$of_options[] = array( "name" => __( 'Font H6', 'cupid' ),
							   "desc" => "",
							   "id"   => "h6-font",
							   "std"  => array( 'face' => '', 'size' => '19px', 'style' => 'normal', 'weight' => '600', 'text-transform' => 'none' ),
							   "type" => "typography"
		);

		/*Resources Options*/
		$of_options[] = array( "name" => __( 'Resources Options', 'cupid' ),
							   "type" => "heading",
							   "icon" => ADMIN_IMAGES . "icon-bootstrap.png"
		);
		$of_options[] = array( "name" => __( 'CDN Bootstrap Script', 'cupid' ),
							   "desc" => "Empty using theme resources",
							   "id"   => "bootstrap-js",
							   "std"  => "",
							   "type" => "text"
		);

		$of_options[] = array( "name" => __( 'CDN Bootstrap StyleSheet', 'cupid' ),
							   "desc" => "Empty using theme resources",
							   "id"   => "bootstrap-css",
							   "std"  => "",
							   "type" => "text"
		);

		$of_options[] = array( "name" => __( 'CDN Font Awesome', 'cupid' ),
							   "desc" => "Empty using theme resources",
							   "id"   => "font-awesome",
							   "std"  => "",
							   "type" => "text",
		);

		/*Custom CSS*/
		$of_options[] = array( "name" => __( 'Custom CSS', 'cupid' ),
							   "type" => "heading",
							   "icon" => ADMIN_IMAGES . "css.png"
		);

		$of_options[] = array( "name" => __( 'Custom CSS', 'cupid' ),
							   "desc" => "",
							   "id"   => "css-custom",
							   "std"  => ".class-custom{}",
							   "type" => "textarea"
		);

		/*Backup Options*/
		$of_options[] = array( "name" => __( 'Backup Options', 'cupid' ),
							   "type" => "heading",
							   "icon" => ADMIN_IMAGES . "icon-slider.png"
		);

		$of_options[] = array( "name" => __( 'Backup and Restore Options', 'cupid' ),
							   "id"   => "of-backup",
							   "std"  => "",
							   "type" => "backup",
							   "desc" => __( 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'cupid' ),
		);

		$of_options[] = array( "name" => __( 'Transfer Theme Options Data', 'cupid' ),
							   "id"   => "of-transfer",
							   "std"  => "",
							   "type" => "transfer",
							   "desc" => __( 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'cupid' ),
		);

	}
	//End function: of_options()
}//End chack if function exists: of_options()
