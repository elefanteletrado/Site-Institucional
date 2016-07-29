<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<?php
	$arrImages = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
	$image = $arrImages[0];
	?>
	<meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>">
	<meta property="og:url" content="<?php echo esc_url(get_the_permalink())?>" />

	<?php if (is_single()) : ?>
		<?php if (has_post_thumbnail()) : ?>
			<meta property="og:image" content="<?php echo esc_attr($image) ?>">
		<?php endif; ?>
		<meta name="author" content="<?php echo esc_attr(get_the_author()); ?>" />
		<?php
		$tags =  '';
		$post_tags = get_the_tags();
		if ($post_tags) {
			foreach($post_tags as $tag) {
				$tags.=  $tag->name . ', ';
			}
		}
		?>
		<meta name="keywords" content="<?php echo esc_attr($tags); ?>" />
		<meta name="description" content="<?php echo esc_attr(get_the_excerpt()); ?>" />
		<?php if (has_post_thumbnail()) : ?>
			<meta property="og:image" content="<?php echo esc_attr($image) ?>">
			<link rel="image_src" href="<?php echo esc_url($image) ?>" />
		<?php endif; ?>
		<meta property="og:description" content="<?php echo esc_attr(get_the_excerpt()); ?>" />
	<?php endif; ?>
	<meta name="robots" content="index, follow" />


	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href="<?php echo get_template_directory_uri(); ?>/elefante.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php global $cupid_data; ?>

	<?php $favicon = '';
	if (isset($cupid_data['favicon']) && !empty($cupid_data['favicon']) ) {
		$favicon = $cupid_data['favicon'];
	} else {
		$favicon = get_template_directory_uri() . "/assets/images/favicon.ico";
	}
	?>

	<link rel="shortcut icon" href="<?php echo esc_url($favicon);?>" type="image/x-icon">
	<link rel="icon" href="<?php echo esc_url($favicon);?>" type="image/x-icon">

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<?php
	global $cupid_data;

	$body_class = array();

	$layout_style = get_post_meta(get_the_ID(),'layout-style',true);
	if (!isset($layout_style) || empty($layout_style) || $layout_style == 'none'){
		$layout_style = $cupid_data['layout-style'];
	}

	if ($layout_style == 'boxed') {
		$body_class[] = 'boxed';
	}

	$show_loading = isset($cupid_data['show-loading']) ? $cupid_data['show-loading'] : 1;


	$arr_style = array();
	$custom_primary_color = get_post_meta(get_the_ID(),'primary-color',true);
	if (!empty($custom_primary_color)) {
		$arr_style['primary-color'] = $custom_primary_color;
	}

	$custom_secondary_color = get_post_meta(get_the_ID(),'secondary-color',true);
	if (!empty($custom_secondary_color)) {
		$arr_style['secondary-color'] = $custom_secondary_color;
	}

	$custom_button_color = get_post_meta(get_the_ID(),'button-color',true);
	if (!empty($custom_button_color)) {
		$arr_style['button-color'] = $custom_button_color;
	}

	$custom_bullet_color = get_post_meta(get_the_ID(),'bullet-color',true);
	if (!empty($custom_bullet_color)) {
		$arr_style['bullet-color'] = $custom_bullet_color;
	}

	$custom_icon_box_color = get_post_meta(get_the_ID(),'icon-box-color',true);
	if (!empty($custom_icon_box_color)) {
		$arr_style['icon-box-color'] = $custom_icon_box_color;
	}

	$custom_header_layout = get_post_meta(get_the_ID(),'header-layout',true);
	if (!empty($custom_header_layout) && $custom_header_layout != 'none') {
		$arr_style['header-layout'] = $custom_header_layout;
	}

	$custom_site_top_layout = get_post_meta(get_the_ID(),'site-top-layout',true);
	if (!empty($custom_site_top_layout) && $custom_site_top_layout != 'none') {
		$arr_style['site-top-layout'] = $custom_site_top_layout;
	}

	$custom_site_logo = get_post_meta(get_the_ID(),'site-logo',true);
	if (!empty($custom_site_logo)) {
		$arr_style['site-logo'] = $custom_site_logo;
	}

	foreach ($arr_style as $key => $value) {
		$cupid_data[$key] = $value;
	}
	?>

	<?php wp_head(); ?>
	<script>
		var textContactLoading = <?php echo json_encode($cupid_data['el_section_contact_button_sending']); ?>;
	</script>
</head>

<body <?php body_class($body_class); ?>>
<!-- Document Wrapper
   ============================================= -->
<div id="el-layout-main" class="el-layout">
	<?php get_template_part('el-templates/header-content' ); ?>