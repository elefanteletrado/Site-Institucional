<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/5/15
 * Time: 5:46 PM
 */

?>
<div class="entry-wrapper classes-wrapper clearfix">
    <?php
    $thumbnail = '';
    if( has_post_thumbnail()){
        if (function_exists('dynamic_sidebar')&& is_active_sidebar('archive-classes-left-sidebar'))
            $thumbnail = get_the_post_thumbnail(get_the_ID(),'thumbnail-870x430');
        else
            $thumbnail = get_the_post_thumbnail(get_the_ID(),'full');
    }
    if (!empty($thumbnail)) : ?>
        <div class="entry-image-wrapper">
            <div class="classes-item">
                <div class="thumbnail-wrap">
                    <?php echo wp_kses_post($thumbnail); ?>
                </div>
            </div>

        </div>
    <?php endif; ?>
    <div class="entry-content-wrapper classes-single-wrapper clearfix">
        <div class="entry-content-container clearfix">

            <div >
                <div class="entry-content clearfix">
                    <?php the_content(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
