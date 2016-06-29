<?php
global $cupid_data;
$is_show_footer = is_active_sidebar('footer-1-sidebar' ) || is_active_sidebar('footer-2-sidebar' ) || is_active_sidebar('footer-3-sidebar' );
$footer_sidebar_count = 0;
if (is_active_sidebar('footer-1-sidebar' )) {
	$footer_sidebar_count++;
}
if (is_active_sidebar('footer-2-sidebar' )) {
	$footer_sidebar_count++;
}
if (is_active_sidebar('footer-3-sidebar' )) {
	$footer_sidebar_count++;
}
$footer_class= '';
if ($footer_sidebar_count > 0) {
	$footer_class = 'footer-col-' . $footer_sidebar_count;
}
?>
<footer>
	<?php if ($is_show_footer): ?>
		<div class="footer-top-widget-area container-fluid clearfix">
			<?php for ($i_sidebar = 1; $i_sidebar <=3; $i_sidebar++): ?>
				<?php if (is_active_sidebar("footer-$i_sidebar-sidebar" ) ): ?>
					<div class="<?php echo esc_attr($footer_class) ?>">
						<?php dynamic_sidebar( "footer-$i_sidebar-sidebar" ); ?>
					</div>
				<?php endif; ?>
			<?php endfor; ?>
		</div>
	<?php endif; ?>
	<div class="footer-bottom">
		<div class="container">
			<div class="footer-bottom-inner">
				<div class="footer-logo">
					<a href="<?php echo esc_attr(get_home_url()) ?>" title="<?php echo esc_attr(__('Home Page','cupid')) ?>">
						<img src="<?php echo esc_url($cupid_data['site-logo-white']) ; ?>" alt="<?php echo esc_attr(__('Home Page','cupid')) ?>" />
					</a>
				</div>
				<?php if (has_nav_menu('footer-menu')) : ?>
					<?php
					wp_nav_menu( array(
						'menu_id' => 'footer-menu',
						'container' => 'div',
						'container_class' => 'footer-menu-container',
						'theme_location' => 'footer-menu',
						'menu_class' => 'footer-menu',
					) );
					?>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<?php if (isset($cupid_data['copyright-text']) && !empty($cupid_data['copyright-text'])): ?>
		<!-- <div class="footer-copyright">
			<div class="footer-copyright-inner">
				<?php echo wp_kses_post($cupid_data['copyright-text'] ); ?>
			</div>
		</div> -->
	<?php endif; ?>
</footer>