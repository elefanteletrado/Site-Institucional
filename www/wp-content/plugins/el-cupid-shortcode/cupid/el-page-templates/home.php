<?php
/**
 * Template Name: :: Página Inicial
 */
?>
<?php get_template_part('el-templates/header'); ?>
<main>
	<?php
	the_post();
	the_content();
	?>
	<?php /* SECTION MAIN BANNER - OK */ ?>
	<?php /* SECTION INTRODUCTION - OK */ ?>
	<?php /* SECTION QUOTE - OK  */ ?>
	<?php /* SECTION FEATURES - OK  */ ?>
	<?php /* SECTION COLLECTION - OK  */ ?>
	
	<?php /* SECTION AUTHORS */ ?>
	<?php /* SECTION CLIENTS */ ?>
	<?php /* SECTION IMPACT */ ?>
	<?php /* SECTION TEAM */ ?>
	<?php get_template_part('el-templates/section-contact'); ?>
</main>
<?php get_template_part('el-templates/popup-contact'); ?>
<?php get_template_part('el-templates/footer'); ?>