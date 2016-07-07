<?php
/**
 * Template Name: :: Padrão
 */
?>
<?php get_template_part('el-templates/header'); ?>
<main>
	<?php
	the_post();
	the_content();
	?>
</main>
<?php get_template_part('el-templates/footer'); ?>