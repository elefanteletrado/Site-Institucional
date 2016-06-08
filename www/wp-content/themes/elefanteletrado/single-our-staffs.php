<?php get_header(); ?>
<section class="page-title-wrapper">
    <div class="container clearfix">
        <div class="cupid-heading">
            <h2><?php echo sprintf(__('Our Teachers: %s','cupid'),get_the_title()); ?></h2>
        </div>
    </div>
</section>
<main role="main" class="site-content-archive">
    <div class="container clearfix">
        <div class="blog-wrapper">
            <div  class="blog-inner blog-single clearfix">
                <?php
                // Start the Loop.
                while ( have_posts() ) : the_post();
                    // Include the page content template.
                    get_template_part('templates/content-single','our-staffs');
                endwhile;
                ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>