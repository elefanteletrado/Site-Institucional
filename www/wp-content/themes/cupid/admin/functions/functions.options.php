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
		$of_options[] = array(
			"name" => 'Configurações Gerais',
			"type" => "heading",
			"icon" => ADMIN_IMAGES . "icon-settings.png"
		);
		$logo = THEME_URL . 'assets/images/logo.png';

		$of_options[] = array(
			'name' => 'Título Site',
			'id'   => 'el_site_title',
			'std'  => 'Elefante Letrado',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Telefone',
			'id'   => 'el_phone',
			'std'  => '+55 51 3407-8090',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Texto Link Página Inicial',
			'id'   => 'el_text_link_home',
			'std'  => 'Ir para Página Inicial',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título Realização',
			'id'   => 'el_title_realization',
			'std'  => 'Realização',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Texto Realização',
			'id'   => 'el_text_realization',
			'std'  => '100 livros da plataforma foram apoiados pela Lei Rouanet.<br />Em contrapartida, doamos acesso para 50 escolas públicas.',
			'type' => 'text',
			'desc' => 'Permite tags HTML. Use "'.htmlentities('<br />').'" para quebrar linhas.',
		);

		$of_options[] = array(
			'name' => 'Url site português',
			'id'   => 'el_link_portuguese',
			'std'  => 'http://www.elefanteletrado.com.br',
			'type' => 'text',
		);

		$of_options[] = array(
			'name' => 'Url site inglês',
			'id'   => 'el_link_english',
			'std'  => 'http://www.elefanteletrado.com.br/en',
			'type' => 'text',
		);

		/*
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
								  // 'full-content'  => $url . '1col.png',
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
		*/

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
		/*
		$of_options[] = array( "name" => __( 'LinkedIn Link', 'cupid' ),
							   "id"   => "social-linkedin-link",
							   "std"  => "#",
							   "type" => "text"
		);
		*/
		$of_options[] = array( "name" => __( 'Facebook Link', 'cupid' ),
							   "id"   => "social-face-link",
							   "std"  => "#",
							   "type" => "text"
		);
		/*
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
		*/
		$of_options[] = array( "name" => __( 'Instagram Link', 'cupid' ),
			"id"   => "social-instagram-link",
			"std"  => "",
			"type" => "text"
		);
		$of_options[] = array( "name" => __( 'Youtube Link', 'cupid' ),
							   "id"   => "social-youtube-link",
							   "std"  => "",
							   "type" => "text"
		);

		$of_options[] = array(
			'name' => 'Fale Conosco',
			'type' => 'heading',
			'icon' => ADMIN_IMAGES . 'icon-settings.png'
		);

		$of_options[] = array(
			'name' => 'Título',
			'id'   => 'el_section_contact_title',
			'std'  => 'Fale Conosco',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "Nome"',
			'id'   => 'el_section_contact_input_name',
			'std'  => 'Nome',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "E-mail"',
			'id'   => 'el_section_contact_input_email',
			'std'  => 'E-mail',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "Telefone"',
			'id'   => 'el_section_contact_input_phone',
			'std'  => 'Telefone',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "Escola"',
			'id'   => 'el_section_contact_input_school',
			'std'  => 'Escola',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "Mensagem"',
			'id'   => 'el_section_contact_input_message',
			'std'  => 'Mensagem',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título botão "Enviar"',
			'id'   => 'el_section_contact_button_send',
			'std'  => 'Enviar',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título botão em carregamento "Enviando..."',
			'id'   => 'el_section_contact_button_sending',
			'std'  => 'Enviando..."',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Demonstração',
			'type' => 'heading',
			'icon' => ADMIN_IMAGES . 'icon-settings.png'
		);

		$of_options[] = array(
			'name' => 'Título botão "Fechar"',
			'id'   => 'el_section_demo_button_close',
			'std'  => 'Fechar',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título',
			'id'   => 'el_section_demo_title',
			'std'  => 'Por favor preencha o formulário abaixo:',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "Nome completo"',
			'id'   => 'el_section_demo_input_name',
			'std'  => 'Nome completo',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "E-mail"',
			'id'   => 'el_section_demo_input_email',
			'std'  => 'E-mail',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "Telefone"',
			'id'   => 'el_section_demo_input_phone',
			'std'  => 'Telefone',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "Nome da Instituição"',
			'id'   => 'el_section_demo_input_school',
			'std'  => 'Nome da Instituição',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título campo "Mensagem"',
			'id'   => 'el_section_demo_input_message',
			'std'  => 'Mensagem',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título botão "Enviar"',
			'id'   => 'el_section_demo_button_send',
			'std'  => 'Enviar',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Título Mensagem Sucesso',
			'id'   => 'el_section_demo_msg_success_title',
			'std'  => 'Obrigado!',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Texto Mensagem Sucesso',
			'id'   => 'el_section_demo_msg_success_text',
			'std'  => 'Entraremos em contato o mais rápido possível.',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Página 404',
			'type' => 'heading',
			'icon' => ADMIN_IMAGES . 'icon-settings.png'
		);

		$of_options[] = array(
			'name' => 'Título',
			'id'   => 'page_404_title',
			'std'  => 'Página não encontrada',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Mensagem',
			'id'   => 'page_404_message',
			'std'  => 'O link que você acessou não está disponível. Em caso de dúvidas entre em contato!',
			'type' => 'text'
		);

		$of_options[] = array(
			'name' => 'Texto botão Voltar',
			'id'   => 'page_404_text_button',
			'std'  => 'Voltar para o site',
			'type' => 'text'
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
