<?php
global $cupid_data;
$hide_page_title = get_post_meta(get_the_ID(),'hide-page-title',true);
if ($hide_page_title == 1) return;

$page_title = get_post_meta(get_the_ID(),'custom-page-title',true);
if (empty($page_title)){
    $page_title = get_the_title();
}
$isTitleInner = strpos(get_the_content(), '<h1>') !== false;
?>
<section class="page-title-wrapper el-page-title-wrapper-blog-layout el-blog-full">
    <div class="container clearfix">
        <div class="el-blog-heading" <?=$isTitleInner ? '' : 'style="background-image: url('.get_the_post_thumbnail_url().');"'; ?> >
            <img src="<?php the_post_thumbnail_url(); ?>" width="100%" class="<?=$isTitleInner ? '' : 'hidden-xs'; ?>" />
            <?php if (!$isTitleInner): ?>
                <h2><?php echo esc_html($page_title); ?></h2>
            <?php endif; ?>
        </div>
    </div>
</section>