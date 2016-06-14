	<footer class="el-footer">
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
	</footer>
</div>
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