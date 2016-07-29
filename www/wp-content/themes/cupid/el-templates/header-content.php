<?php
global $cupid_data;
?>
<header class="el-header">
	<div class="el-header-auxiliary">
		<div class="el-header-phone">
			<?php if($cupid_data['el_link_portuguese']): ?>
			<a href="<?php echo $cupid_data['el_link_portuguese']; ?>" class="el-icon-round-portuguese">
				Português
			</a>
			<?php endif; ?>
			<?php if($cupid_data['el_link_english']): ?>
			<a href="<?php echo $cupid_data['el_link_english']; ?>" class="el-icon-round-english">
				English
			</a>
			<?php endif; ?>
			<a href="tel:<?php echo preg_replace('@[^\d+]@', '', $cupid_data['el_phone']); ?>"class="el-box-phone">
				<span class="el-icon-round-reverse el-icon-round-phone fa fa-phone"></span>
				<span><?php echo $cupid_data['el_phone']; ?></span>
			</a>
		</div>
		<div class="pull-right">
			<a href="<?php echo $cupid_data['social-youtube-link']; ?>" title="Youtube">
				<span class="el-icon-round el-icon-auxiliary fa fa-youtube"></span>
			</a>
			<a href="<?php echo $cupid_data['social-instagram-link']; ?>" title="Instagram">
				<span class="el-icon-round el-icon-auxiliary fa fa-instagram"></span>
			</a>
			<a href="<?php echo $cupid_data['social-face-link']; ?>" title="Facebook">
				<span class="el-icon-round el-icon-auxiliary fa fa-facebook"></span>
			</a>
			<a href="mailto:<?php echo $cupid_data['social-email-link']; ?>" title="Email: <?php echo $cupid_data['social-email-link']; ?>">
				<span class="el-icon-round el-icon-auxiliary fa fa-envelope-o"></span>
			</a>
		</div>
	</div>
	<div class="el-header-main">
		<a href="<?php echo get_site_url(); ?>" class="el-logo" title="<?php echo $cupid_data['el_text_link_home']; ?>"><?php echo $cupid_data['el_site_title']; ?></a>
		<nav class="el-header-menu">
			<?php if (has_nav_menu('primary')) : ?>
				<?php
				wp_nav_menu( array(
					'menu_id' => 'main-menu',
					'theme_location' => 'primary',
				) );
				?>
			<?php endif; ?>
		</nav>
	</div>
</header>