<?php
global $is404;

$is404 = true;

$frontpage_id = get_option('page_on_front');
$post = get_post($frontpage_id);

get_template_part('el-templates/header');
?>
    <main>
        <?php
        echo apply_filters('the_content', $post->post_content);
        ?>
        <?php get_template_part('el-templates/section-contact'); ?>
    </main>
<?php get_template_part('el-templates/footer'); ?>