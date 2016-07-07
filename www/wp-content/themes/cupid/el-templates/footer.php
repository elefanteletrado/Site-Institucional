	<footer class="el-footer el-footer-page">
		<div>
			<div class="el-footer-logo">
				<a href="" title="Ir para a Página Inicial">Elefante Letrado</a>
			</div>
			<nav class="row">
				<div class="col-sm-3 hidden-xs">
					<?php
					wp_nav_menu( array(
						'menu_id' => 'main-menu',
						'theme_location' => 'el-footer-menu-main'
					) );
					?>
				</div>
				<div class="col-sm-3 hidden-xs">
					<?php
					wp_nav_menu( array(
						'menu_id' => 'main-menu',
						'theme_location' => 'el-footer-menu-auxiliary'
					) );
					?>
				</div>
				<?php
				/*
				<div class="col-sm-3">
					<p>
						Contato<br />
						+55 51 3407-8090<br />
						<span class="el-email">contato@elefanteletrado.com.br</span><br />
						Av. Carlos Gomes, 1.492/709<br />
						Porto Alegre/ RS
					</p>
				</div>
				*/
				?>
				<div class="col-sm-3 hidden-xs">
					<h3>Redes Sociais</h3>
					<?php
					wp_nav_menu( array(
						'menu_id' => 'main-menu',
						'theme_location' => 'el-footer-menu-social-networks'
					) );
					?>
				</div>
				<div class="col-sm-3">
					<p>
						Realização
					</p>
					<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/layout/realizacao.jpg" width="228" height="48">
					<p style="font-size: 9px; white-space: nowrap; margin-top: 10px;">
						100 livros da plataforma foram apoiados pela Lei Rouanet.<br />
						Em contrapartida, doamos acesso para 50 escolas públicas.
					</p>
				</div>
			</nav>
		</div>
	</footer>
</div>
<?php get_template_part('el-templates/popup-contact'); ?>
<?php wp_footer(); ?>
<script type="text/javascript" async="true" src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/7cb53d67-e1e5-499d-82ec-539141b6842b-loader.js"></script>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-45568225-1', 'auto');
	ga('send', 'pageview');
</script>

<!-- Facebook Pixel Code -->
<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','//connect.facebook.net/en_US/fbevents.js');

	fbq('init', '523749501121316');
	fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
			   src="https://www.facebook.com/tr?id=523749501121316&ev=PageView&noscript=1"
	/></noscript>
<!-- End Facebook Pixel Code -->

</body>
</html>