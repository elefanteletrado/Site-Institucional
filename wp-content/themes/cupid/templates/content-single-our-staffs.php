<?php
/**
 * @package cupid
 */
$job   = get_post_meta(get_the_ID(), 'job', true);
$face_url = get_post_meta( get_the_ID(), 'face_url', true );
$twitter_url = get_post_meta( get_the_ID(), 'twitter_url', true );
$google_url = get_post_meta( get_the_ID(), 'google_url', true );
$linkedin_url = get_post_meta( get_the_ID(), 'linkedin_url', true );
$phone   = get_post_meta(get_the_ID(), 'phone', true);
$email   = get_post_meta(get_the_ID(), 'email', true);
$image_id  = get_post_thumbnail_id();
$image_url = wp_get_attachment_image( $image_id, 'thumbnail-200x200', false, array( 'alt' => get_the_title(), 'title' => get_the_title()));
?>
<article id="post-<?php get_the_ID(); ?>">
        <div class="page-single-our-staffs">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12 our-staffs-image">
                    <?php echo wp_kses_post($image_url); ?>
                </div>
                <div class="col-md-9 col-sm-6 col-xs-12 our-staffs-contact">
                    <h3 class="our-staffs-name" ><?php the_title(); ?></h3>
                    <p class="our-staffs-job"><?php echo esc_html($job); ?></p>
                    <?php if (!empty($phone)): ?>
                        <div class="our-staffs-phone">
                            <p><?php echo __('Phone:  ','cupid')?></p><?php echo esc_html($phone); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($email)):?>
                        <div class="our-staffs-email">
                            <p><?php echo __('Email:  ','cupid')?></p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="our-staffs-social">
                        <?php if (!empty($face_url) || !empty($twitter_url) || !empty($google_url) || !empty($dribbble_url) || !empty($linkedin_url)): ?>
                            <ul>
                                <?php if (!empty($face_url)): ?>
                                    <li><a href="<?php echo esc_url($face_url); ?>" class="facebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <?php endif; ?>
                                <?php if (!empty($twitter_url)): ?>
                                    <li><a href="<?php echo esc_url($twitter_url); ?>" class="twitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                <?php endif; ?>
                                <?php if (!empty($google_url)):?>
                                    <li><a href="<?php echo esc_url($google_url); ?>" class="google" title="Google"><i class="fa fa-google-plus"></i></a></li>
                                <?php endif; ?>
                                <?php if (!empty($linkedin_url)):?>
                                    <li><a href="<?php echo esc_url($linkedin_url); ?>" class="linkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="our-staffs-content">
                <?php echo get_the_content(); ?>
            </div>
            <?php
                $args = array(
                    'post_type'  => 'cupid_classes',
                    'meta_query' => array(
                        array(
                            'key'     => 'teacher-class',
                            'value'   => get_query_var('name'),
                            'compare' => '=',
                        ),
                    ),
                );
                $query = new  WP_Query( $args );
                $posts = $query->get_posts();
                if(count($posts)>0)
                {
                    echo  do_shortcode('[cupid_call_action text="'. sprintf(__('Go to  %s&rsquo;s class','cupid'),get_the_title()). '" button_label="'. __('View Now','cupid'). '" link="'.get_permalink($posts[0]->ID).'"]');
                }
            ?>
        </div>
</article>
