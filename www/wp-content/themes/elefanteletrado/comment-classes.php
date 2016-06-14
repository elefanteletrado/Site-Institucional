<?php
/*
The comments page for Bones
*/

// don't load it if you can't comment
if ( post_password_required() ) {
    return;
}
$class_list_col = 'col-md-12';
?>
<?php if ( comments_open() || get_comments_number() ) : ?>

    <div class="row entry-comments" id="comments">
        <div class="<?php echo esc_attr($class_list_col); ?>">
            <div class="entry-comments-list">
                <h3 class="comments-title">
                    <?php comments_number( __('No Course Review(s)','cupid'), __('One Course Review','cupid'), __( 'Course Reviews (%)', 'cupid' ) );?>
                </h3>
                <?php if (have_comments()) : ?>
                    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                        <nav class="comment-navigation clearfix pull-right" role="navigation">
                            <?php $paginate_comments_args = array(
                                'prev_text' => '<i class="fa fa-angle-double-left"></i>',
                                'next_text' => '<i class="fa fa-angle-double-right"></i>'
                            );
                            paginate_comments_links($paginate_comments_args);
                            ?>
                        </nav>
                        <div class="clearfix"></div>
                    <?php endif; ?>


                    <ol class="commentlist clearfix">
                        <?php wp_list_comments(array(
                            'style' => 'li',
                            'callback' => 'cupid_render_comments',
                            'avatar_size' => 50,
                            'short_ping'  => true,
                        )); ?>
                    </ol>

                    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                        <nav class="comment-navigation clearfix pull-right" role="navigation">
                            <?php
                            paginate_comments_links($paginate_comments_args);
                            ?>
                        </nav>
                        <div class="clearfix"></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if (comments_open()) : ?>
            <div class="col-md-12">
                <div class="entry-comments-form">
                    <?php cupid_comment_form(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php endif; ?>