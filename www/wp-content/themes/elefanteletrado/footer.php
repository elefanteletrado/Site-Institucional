<?php
global $cupid_data;
?>
		</div><!-- end #wapper-content-->
		<?php get_template_part('templates/footer/footer', 'template'); ?>
	</div><!-- end #wapper-->
	<?php if($cupid_data['show-back-to-top']==1): ?>
		<a id="go-top" class="gotop" href="javascript:;" title="<?php _e('Go top','cupid') ?>">
			<i class="fa fa-arrow-up"></i>
		</a>
	<?php endif ?>
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
</html> <!-- end of site. what a ride! -->