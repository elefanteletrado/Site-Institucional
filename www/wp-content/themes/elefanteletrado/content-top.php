<?php
global $cupid_data;
$hide_page_title = get_post_meta(get_the_ID(),'hide-page-title',true);
if ($hide_page_title == 1) return;

$page_title = get_post_meta(get_the_ID(),'custom-page-title',true);
if (empty($page_title)){
    $page_title = get_the_title();
}
$page_sub_title = get_post_meta(get_the_ID(),'custom-page-sub-title',true);
?>
<section class="page-title-wrapper">
    <div class="container clearfix">
        <div class="cupid-heading">
            <h2><?php echo esc_html($page_title); ?></h2>
            <?php if (!empty($page_sub_title)) : ?>
            <span><?php echo esc_html($page_sub_title); ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>


