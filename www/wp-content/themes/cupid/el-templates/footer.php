<?php
global $is404, $cupid_data;

?>
	<footer class="el-footer el-footer-page">
		<div>
			<div class="el-footer-logo">
				<a href="" title="<?php echo $cupid_data['el_text_link_home']; ?>" class="el-footer-logo-link">
					<?php echo $cupid_data['el_site_title']; ?>
				</a>
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
						<?php echo $cupid_data['el_title_realization']; ?>
					</p>
					<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/layout/realizacao.jpg" width="228" height="48">
					<p class="el-text-st-footer">
						<?php echo $cupid_data['el_text_realization']; ?>
					</p>
					<div style="margin-top: 10px; padding-top: 10px; margin-bottom: 30px; border-top: 1px solid #999;">
						<a href="http://www.kidsafeseal.com/certifiedproducts/elefanteletrado.html" target="_blank">
							<img border="0" alt="ElefanteLetrado.com.br is certified by the kidSAFE Seal Program." src="http://www.kidsafeseal.com/sealimage/125654952451330744/elefanteletrado_small_darktm.png">
						</a>
					</div>
				</div>
			</nav>
		</div>
	</footer>
</div>
<?php get_template_part('el-templates/popup-contact'); ?>
<?php if(!empty($is404)): ?>
	<div id="message-404" class="el-modal el-modal-confirm">
		<div>
			<div class="el-modal-dialog">
				<section class="el-modal-content el-modal-content-msg">
					<div class="el-modal-header">
						<h4 class="el-modal-title"><?php echo $cupid_data['page_404_title']; ?></h4>
					</div>
					<div class="el-modal-body">
						<p class="el-modal-message">
							<?php echo $cupid_data['page_404_message']; ?>
						</p>
						<button class="submit-ok message-404-ok"><?php echo $cupid_data['page_404_text_button']; ?></button>
					</div>
				</section>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php wp_footer(); ?>
<script type="text/javascript" async="true" src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/7cb53d67-e1e5-499d-82ec-539141b6842b-loader.js"></script>
<?php
$option_id = 1;
$option = get_option( 'ext_contact_type_item_' . $option_id );
?>
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