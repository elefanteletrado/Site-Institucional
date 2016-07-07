<?php
/**
 * Template Name: :: Funcionalidades
 */
?>
<?php get_template_part('el-templates/header'); ?>
<main>
	<?php
	the_post();
	the_content();
	?>
	<?php get_template_part('el-templates/section-contact'); ?>
</main>
<?php get_template_part('el-templates/footer'); ?>