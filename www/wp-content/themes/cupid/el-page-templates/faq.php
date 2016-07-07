<?php
/**
 * Template Name: :: Dúvidas
 */
?>
<?php get_template_part('el-templates/header'); ?>
<main>
	<article class="el-page-content el-page-faq">
		<?php
		the_post();
		the_content();
		?>
	</article>
	<?php get_template_part('el-templates/section-contact'); ?>
</main>
<?php get_template_part('el-templates/footer'); ?>