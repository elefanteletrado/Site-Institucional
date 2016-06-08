<?php
global $cupid_data;
$header_layout = get_post_meta(get_the_ID(),'header-style',true);
if (!isset($header_layout) || $header_layout == 'none' || $header_layout == '') {
	$header_layout =  $cupid_data['header-layout'];
}

$show_site_top = isset($cupid_data['show-site-top']) ? $cupid_data['show-site-top'] : 0;
$show_language_selector =  isset($cupid_data['show-language-selector']) ? $cupid_data['show-language-selector'] : 0;
$site_top_content = isset($cupid_data['site-top-content']) ? $cupid_data['site-top-content'] : '';
$site_top_layout = 'site-top-1';
if (isset($cupid_data['site-top-layout'])) {
	$site_top_layout = 'site-top-' . $cupid_data['site-top-layout'];
}
$header_class = 'header-' . $header_layout;
?>
<?php if ($show_site_top): ?>
	<div class="site-top <?php echo esc_attr($site_top_layout); ?> <?php echo esc_attr($header_class) ?>">
		<div class="container">
			<?php if ($show_language_selector || !empty($site_top_content)): ?>
				<div class="site-top-left">
					<?php if (function_exists('icl_get_setting') && ($show_language_selector)):?>
						<div class="language-selector">
							<h4 class="title"><?php _e('Language','cupid'); ?></h4>
							<?php do_action('icl_language_selector'); ?>
						</div>
					<?php endif;?>
					<?php if (!empty($site_top_content)):?>
						<div class="site-top-content">
							<?php echo wp_kses_post($site_top_content); ?>
						</div>
					<?php endif;?>
				</div>
			<?php endif; ?>
			<div class="site-top-right">
				<?php get_template_part('templates/header/social','link' ); ?>
				<?php get_template_part('templates/header/login','link' ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php get_template_part('templates/header/header',$header_layout ); ?>
<?php get_template_part('templates/header/search'); ?>