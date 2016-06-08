<footer class="el-footer el-footer-page">
	<div>
		<div class="el-footer-logo">
			<a href="" title="Ir para a Página Inicial">Elefante Letrado</a>
		</div>
		<nav class="row">
			<div class="col-sm-3">
				<?php
				wp_nav_menu( array(
					'menu_id' => 'main-menu',
					'theme_location' => 'el-footer-menu-main'
				) );
				?>
			</div>
			<div class="col-sm-3">
				<?php
				wp_nav_menu( array(
					'menu_id' => 'main-menu',
					'theme_location' => 'el-footer-menu-auxiliary'
				) );
				?>
			</div>
			<div class="col-sm-3">
				<p>
					Contato<br />
					+55 51 3407-8090<br />
					<span class="el-email">contato@elefanteletrado.com.br</span><br />
					Av. Carlos Gomes, 1.492/709<br />
					Porto Alegre/ RS
				</p>
			</div>
			<div class="col-sm-3">
				<h3>Redes Sociais</h3>
				<?php
				wp_nav_menu( array(
					'menu_id' => 'main-menu',
					'theme_location' => 'el-footer-menu-social-networks'
				) );
				?>
			</div>
		</nav>
	</div>
</footer>