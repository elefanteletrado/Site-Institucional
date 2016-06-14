<?php
global $cupid_data;
$cupid_data['header-layout'] = 1;
get_header();

$phone = $url_support_forum = '';
if(isset($cupid_data['url-support-forum'])){
    $url_support_forum = $cupid_data['url-support-forum'];
}
if(isset($cupid_data['phone'])){
    $phone = $cupid_data['phone'];
}

?>
<div class="page404 cupid-overlay"  id="page404"  style="background-image: url(<?php echo esc_attr($cupid_data['page-404-background']);?>);background-size: cover;background-repeat: no-repeat;background-position: right">
    <div id="ryl-home-content" class="container ryl-cell-vertical-wrapper ryl-home-content">
        <div class="ryl-cell-middle">
            <div class="row center ryl-404-wrapper ryl-margin-bottom-30">
                <div class="icon center">
                    <i class="fa fa-cog"></i>
                </div>
                <div class="info center">
                    <h1><?php echo __('404 error!','cupid') ?></h1>
                </div>
                <div class="description">
                    <span><?php echo __('Look like something went wrong! The page you were looking for is not here.','cupid') ?></span>
                    <span><a href="<?php echo esc_url(home_url()); ?>"><?php echo __('Go Home','cupid'); ?></a> <?php echo __(' or try search','cupid'); ?></span>
                </div>
                <div class="search-wrapper col-md-12">
                    <div class="col-md-8 col-md-push-2">
                        <input type="text" id="keyword_404" class="keyword" placeholder="<?php echo esc_attr('Search','cupid') ?>" id="keyword_classes" autocomplete=off>
                        <span><i id="bt_search_404" class="fa fa-search"></i></span>
                    </div>
                </div>
                <div class="contact-info">
                    <?php if($phone!='') {?>
                        <span>
                            <i class="fa fa-phone"></i>
                            <?php echo wp_kses_post($phone) ?>
                        </span>
                    <?php } ?>
                    <?php if($url_support_forum!=''){ ?>
                        <span>
                            <a href="<?php echo esc_url($url_support_forum);?>">
                                <i class="fa fa-table"></i>
                                <?php echo __('Access support forum','cupid') ?>
                            </a>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>