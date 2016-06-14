<header class="el-header">
	<div class="el-header-auxiliary">
		<div class="el-header-phone">
			<a href="tel:+555134078090">
				<span class="el-icon-round-reverse el-icon-round-phone fa fa-phone"></span>
				<span>+55 51 3407-8090</span>
			</a>
		</div>
		<div class="pull-right">
			<a href="https://www.youtube.com/channel/UC1E5WzU4ZURIjgSpSDT3H-w" title="Youtube">
				<span class="el-icon-round el-icon-auxiliary fa fa-youtube"></span>
			</a>
			<a href="http://www.instagram.com/elefanteletrado" title="Instagram">
				<span class="el-icon-round el-icon-auxiliary fa fa-instagram"></span>
			</a>
			<a href="http://www.facebook.com/elefanteletrado" title="Facebook">
				<span class="el-icon-round el-icon-auxiliary fa fa-facebook"></span>
			</a>
			<a href="mailto:suporte@elefanteletrado.com.br" title="Email">
				<span class="el-icon-round el-icon-auxiliary fa fa-envelope-o"></span>
			</a>
		</div>
	</div>
	<div class="el-header-main">
		<a href="/" class="el-logo" title="Ir para Página Inicial">Elefante Letrado</a>
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