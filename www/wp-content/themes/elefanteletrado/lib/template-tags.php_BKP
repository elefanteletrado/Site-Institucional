<?php
/**
 * Custom template tags for cupid
 *
 * @package WordPress
 * @subpackage cupid
 * @since cupid 1.0
 */

if (!function_exists('cupid_post_thumbnail')) :
    function cupid_post_thumbnail($size){
        $html = '';
        switch(get_post_format()) {
            case 'image':
                $args = array(
                    'size'     => $size,
                    'format'   => 'src',
                    'meta_key' => 'post-format-image'
                );
                $image = cupid_get_image($args);
                if (!$image) break;
                $html = cupid_get_image_hover($image,get_permalink(),the_title_attribute( 'echo=0' ),$size);
                break;
            case 'gallery':
                $images = get_post_meta(get_the_ID(),'post-format-gallery');
                if (count($images) > 0) {
                    $data_plugin_options = "data-plugin-options='{\"singleItem\" : true, \"pagination\" : false, \"navigation\" : true, \"autoHeight\" : true}'";
                    $html ="<div class='owl-carousel' $data_plugin_options>";
                    foreach ( $images as $image ) {
                        $src = wp_get_attachment_image_src( $image, $size );
                        $image = $src[0];
                        $html .= cupid_get_image_hover($image,get_permalink(),the_title_attribute( 'echo=0' ),$size);
                    }
                    $html .= '</div>';
                } else {
                    $args = array(
                        'size'     => $size,
                        'format'   => 'src',
                        'meta_key' => ''
                    );
                    $image = cupid_get_image($args);
                    if (!$image) break;
                    $html = cupid_get_image_hover($image,get_permalink(),the_title_attribute( 'echo=0' ),$size);
                }
                break;
            case 'video':
                $video = get_post_meta(get_the_ID(),'post-format-video');
                if (count($video) > 0){
                    $html.= '<div class="embed-responsive embed-responsive-16by9 embed-responsive-'.$size.'">';
                    $video = $video[0];
                    // If URL: show oEmbed HTML
                    if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
                        $args = array(
                            'wmode' => 'transparent'
                        );
                        $html .= wp_oembed_get( $video,$args);
                    } // If embed code: just display
                    else {
                        $html .= $video;
                    }
                    $html.= '</div>';
                }
                break;
            case 'audio':
                $audio = get_post_meta( get_the_ID(),'post-format-audio');
                if (count($audio) > 0) {
                    $audio = $audio[0];
                    if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
                        $html .= wp_oembed_get( $audio);
                        $title = esc_attr(get_the_title());
                        $audio = esc_url($audio);
                        if (empty($html)) {
                            $id = uniqid();
                            $html .= "<div data-player='$id' class='jp-jplayer' data-audio='$audio' data-title='$title'></div>";
                            $html .= cupid_jplayer( $id,$audio );
                        }
                    }
                    else{
                        $html .= $audio;
                    }
                    $html.= '<div style="clear:both;"></div>';
                }
                break;
            default:
                $args = array(
                    'size'     => $size,
                    'format'   => 'src',
                    'meta_key' => ''
                );
                $image = cupid_get_image($args);
                if (!$image) break;
                $html = cupid_get_image_hover($image,get_permalink(),the_title_attribute( 'echo=0' ),$size);
                break;
        }

        return $html;
    }
endif;

if (!function_exists('cupid_get_image_hover')) :
    function cupid_get_image_hover($image,$url,$title,$size) {
        global $_wp_additional_image_sizes;

        $width = '';
        $height = '';
        if (isset($size) && isset($_wp_additional_image_sizes[$size])) {
            $width = 'width="'. $_wp_additional_image_sizes[$size]['width'].'"';
            $height = 'height="'. $_wp_additional_image_sizes[$size]['height'] .'"';
        }



        if (is_single()) {
            return sprintf('<div class="entry-thumbnail">
                                <img %3$s %4$s src="%2$s" alt="%1$s" class="img-responsive">
                            </div>',
                $title,
                $image,
                $width,
                $height);
        } else {
            return sprintf('<div class="entry-thumbnail">
                        <a href="%1$s" title="%2$s">
                            <img %4$s %5$s class="img-responsive" src="%3$s" alt="%2$s"/>
                        </a>
                      </div>',
                $url,
                $title,
                $image,
                $width,
                $height
            );
        }



    }
endif;

if (!function_exists('cupid_get_image')) :
    function cupid_get_image($args = array()) {
        $default = apply_filters(
            'cupid_get_image_default_args',
            array(
                'post_id'  => get_the_ID(),
                'size'     => 'thumbnail',
                'format'   => 'html', // html or src
                'attr'     => '',
                'meta_key' => '',
                'scan'     => true,
                'default'  => ''
            )
        );

        $args = wp_parse_args( $args, $default );
        if ( ! $args['post_id'] ) {
            $args['post_id'] = get_the_ID();
        }

        // Get image from cache
        $key         = md5( serialize( $args ) );
        $image_cache = wp_cache_get( $args['post_id'], 'cupid_get_image' );



        if ( ! is_array( $image_cache ) ) {
            $image_cache = array();
        }

        if ( empty( $image_cache[$key] ) ) {
            // Get post thumbnail
            if (has_post_thumbnail($args['post_id'])) {
                $id   = get_post_thumbnail_id();
                $html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
                list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
            }

            // Get the first image in the custom field
            if (!isset($html,$src) && $args['meta_key']) {
                $id = get_post_meta( $args['post_id'], $args['meta_key'], true );
                if ( $id ) {
                    $html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
                    list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
                }
            }

            // Get the first attached image
            /*if (!isset($html,$src)) {
                $image_ids = array_keys( get_children( array(
                    'post_parent'    => $args['post_id'],
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ) ) );
                if (!empty($image_ids)) {
                    $id   = $image_ids[0];
                    $html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
                    list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
                }
            }*/

            // Get the first image in the post content
            if (!isset($html,$src) && ($args['scan'])) {
                preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );
                if ( ! empty( $matches ) ){
                    $html = $matches[0];
                    $src  = $matches[1];
                }
            }

            // Use default when nothing found
            if ( ! isset( $html, $src ) && ! empty( $args['default'] ) ){
                if ( is_array( $args['default'] ) ){
                    $html = @$args['html'];
                    $src  = @$args['src'];
                } else {
                    $html = $src = $args['default'];
                }
            }

            if ( ! isset( $html, $src ) ) {
                return false;
            }

            $output = 'html' === strtolower( $args['format'] ) ? $html : $src;
            $image_cache[$key] = $output;
            wp_cache_set( $args['post_id'], $image_cache, 'cupid_get_image' );
        }
        else {
            $output = $image_cache[$key];
        }
        $output = apply_filters( 'cupid_get_image', $output, $args );
        return $output;
    }
endif;


if (!function_exists('cupid_jplayer')) :
    function cupid_jplayer( $id = 'jp_container_1' ) {
        ob_start();
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="jp-audio">
            <div class="jp-type-playlist">
                <div class="jp-gui jp-interface">
                    <ul class="jp-controls jp-play-pause">
                        <li><a href="javascript:;" class="jp-play" tabindex="1"><i class="fa fa-play"></i> <?php _e( 'play', 'cupid' ); ?></a></li>
                        <li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="fa fa-pause"></i> <?php _e( 'pause', 'cupid' ); ?></a></li>
                    </ul>

                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>

                    <ul class="jp-controls jp-volume">
                        <li>
                            <a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><i class="fa  fa-volume-up"></i> <?php _e( 'mute', 'cupid' ); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><i class="fa fa-volume-off"></i><?php _e( 'unmute', 'cupid' ); ?></a>
                        </li>
                        <li>
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                        </li>

                    </ul>

                    <div class="jp-time-holder">
                        <div class="jp-current-time"></div>
                        <div class="jp-duration"></div>
                    </div>
                    <ul class="jp-toggles">
                        <li>
                            <a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><?php _e( 'shuffle', 'cupid' ); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><?php _e( 'shuffle off', 'cupid' ); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php _e( 'repeat', 'cupid' ); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php _e( 'repeat off', 'cupid' ); ?></a>
                        </li>
                    </ul>
                </div>


                <div class="jp-no-solution">
                    <?php printf( __( '<span>Update Required</span> To play the media you will need to either update your browser to a recent version or update your <a href="%s" target="_blank">Flash plugin</a>.', 'cupid' ), 'http://get.adobe.com/flashplayer/' ); ?>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
endif;


if ( ! function_exists( 'cupid_render_comments' ) ) {
    function cupid_render_comments( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment; ?>

        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">

            <?php echo get_avatar($comment, $args['avatar_size']); ?>

            <div class="comment-text">

                <div class="author">
                    <div class="author-name"><?php printf( __( '%s', 'cupid'), get_comment_author_link() ) ?></div>
                    <div class="date">
                        <?php printf(__('%1$s at %2$s', 'cupid'), get_comment_date(),  get_comment_time() ) ?>
                        <?php edit_comment_link( __( '(Edit)', 'cupid'),'  ',' — ' ) ?>
                        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                    </div>
                </div>

                <div class="text"><?php comment_text() ?></div>

                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em><?php _e( 'Your comment is awaiting moderation.', 'cupid' ) ?></em>
                    <br>
                <?php endif; ?>
            </div>

        </div>
    <?php
    }
}




if (!function_exists('cupid_comment_form')) :
    function cupid_comment_form() {
        $commenter = wp_get_current_commenter();
        $req      = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';;

        $fields   =  array(

            'author' => '<div>'.
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  placeholder="'.__('Name','cupid').'" '. $aria_req.'>' .
                '</div>',

            'email' => '<div>'.
                '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '"  placeholder="'.__('Email','cupid') . '" '. $aria_req .'>' .
                '</div>',
            'url' => '<div>'.
                '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '"  placeholder="'.__('Website','cupid') .'" '. $aria_req.'>' .
                '</div>'
        );

        $comment_form_args = array(
            'fields'               => $fields,
            'comment_field' => '<div>'.
                '<textarea rows="6" id="comment" name="comment"  value="' . esc_attr( $commenter['comment_author_url'] ) . '"  placeholder="'.__('Message','cupid') .'"  aria-required="true"></textarea>' .
                '</div>',


            'comment_notes_before' => '<p class="comment-notes">' .
                __('Your email address will not be published.', 'cupid') /* . ( $req ? $required_text : '' ) */ .
                '</p>',
            'comment_notes_after'  => '',
            'id_submit'            => 'btnComment',
            'class_submit'          => 'cupid-button button-sm',
            'title_reply'          => __( 'Leave a Comment','cupid' ),
            'title_reply_to'       => __( 'Leave a Comment to %s','cupid' ),
            'cancel_reply_link'    => __('Cancel reply','cupid'),
            'label_submit'         => __('Send','cupid')
        );
        comment_form($comment_form_args);
    }
endif;


if (!function_exists('cupid_ajaxComment')) :
    // Method to handle comment submission
    function cupid_ajaxComment($comment_ID, $comment_status) {
        // If it's an AJAX-submitted comment
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            // Get the comment data
            $comment = get_comment($comment_ID);
            // Allow the email to the author to be sent
            wp_notify_postauthor($comment_ID);
            // Get the comment HTML from my custom comment HTML function
            $comments = get_comments(array ( 'post_id' =>  $comment->comment_post_ID ));
            ob_start();
            $number = get_comments_number($comment->comment_post_ID);
            ?>
            <h4 class="comments-title"><?php _e("Comments",'cupid'); ?> (<?php echo esc_html($number); ?>)</h4>
            <ul class="comment-list">
            <?php wp_list_comments(array(
                'style' => 'li',
                'type' => 'comment',
                'callback' => 'cupid_get_list_comments',
                'avatar_size' => 82
            ),$comments); ?>
            </ul>
            <?php cupid_comment_form($comment->comment_post_ID); ?>
            <?php
            $commentContent = ob_get_clean();
           // Kill the script, returning the comment HTML
            die($commentContent);
        }
    }
endif;
// Send all comment submissions through my "ajaxComment" method
add_action('comment_post', 'cupid_ajaxComment', 20, 2);


if (!function_exists('cupid_paging_load_more')) :
    function cupid_paging_load_more() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($wp_query->max_num_pages);
        if (!empty($link)) :
            ?>
            <div class="blog-load-more-wrapper">
                <button data-href="<?php echo esc_url($link); ?>" type="button"  data-loading-text="<i class='fa fa-refresh fa-spin'></i> <?php _e("Loading...",'cupid'); ?>" class="blog-load-more cupid-btn-2" autocomplete="off">
                    <?php _e("Load More",'cupid'); ?>
                </button>
            </div>
        <?php
        endif;
    }
endif;


if (!function_exists('cupid_post_date')) :
    function cupid_post_date(){
        ?>
        <div class="entry-date">
            <div class="day">
                <?php echo get_the_time('d'); ?>
            </div>
            <div class="month">
                <?php echo get_the_date('M'); ?>
            </div>
        </div>
    <?php
    }
endif;


if (!function_exists('cupid_post_meta')) :
    function cupid_post_meta() {
        ?>
        <span class="entry-meta-author">
                <?php _e("By",'cupid'); ?> <?php printf('<a href="%1$s">%2$s</a>',esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),esc_html( get_the_author() )); ?>
        </span>
        <span class="entry-meta-date">
            <?php _e("Posted at",'cupid'); ?> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"> <?php echo  get_the_date(get_option('date_format'));?> </a>
        </span>
        <?php edit_post_link( __( '<i class="fa fa-edit"></i> Edit', 'cupid' ), '<span class="edit-link">', '</span>' ); ?>
    <?php
    }
endif;


if ( ! function_exists( 'cupid_paging_nav' ) ) :
    function cupid_paging_nav() {
        global $wp_query, $wp_rewrite;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $page_links = paginate_links( array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $wp_query->max_num_pages,
            'current'  => $paged,
            'mid_size' => 1,
            'add_args' => array_map( 'urlencode', $query_args ),
            'prev_text' => '<i class="fa fa-angle-double-left"></i>',
            'next_text' => '<i class="fa fa-angle-double-right"></i>',
            'type' => 'array'
        ) );

        if (count($page_links) == 0) return;





        $links = "<ul class='pagination'>\n\t<li>";
        $links .= join("</li>\n\t<li>", $page_links);
        $links .= "</li>\n</ul>\n";
        return $links;
    }
endif;

if (!function_exists('cupid_paging_infinitescroll')):
    function cupid_paging_infinitescroll(){
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($wp_query->max_num_pages);
        if (!empty($link)) :
            ?>
            <nav id="infinite_scroll_button">
                <a href="<?php echo esc_url($link); ?>"></a>
            </nav>
            <div id="infinite_scroll_loading" class="text-center infinite-scroll-loading"></div>
        <?php
        endif;
    }
endif;


if (!function_exists('cupid_archive_loop_reset')) :
    function cupid_archive_loop_reset() {
        global $cupid_archive_loop;
        // Reset loop/columns globals when starting a new loop
        $cupid_archive_loop['style'] = $cupid_archive_loop['layout'] = $cupid_archive_loop['image-size'] = $cupid_archive_loop['image-style'] = '';
        $cupid_archive_loop['rows'] = 0;
        $cupid_archive_loop['column'] = 0;
        $cupid_archive_loop['post_count'] = 0;
    }
endif;

if (!function_exists('cupid_the_breadcrumb')) :
    function cupid_the_breadcrumb(){
        get_template_part( 'templates/breadcrumb' );
    }
endif;

if (!function_exists('cupid_get_category_parents')) {
    // Copied and adapted from WP source
    function cupid_get_category_parents($id, $link = FALSE, $separator = '/', $nicename = FALSE){
        $chain = '';
        $parent = get_category($id);
        if ( is_wp_error( $parent ) )
            return $parent;

        if ( $nicename )
            $name = $parent->slug;
        else
            $name = $parent->cat_name;

        if ( $parent->parent && ($parent->parent != $parent->term_id) )
            $chain .='<li>'. get_category_parents($parent->parent, true, $separator, $nicename) .'<li>';

        $chain .= '<li><span>' .$name . '</span></li>';
        return $chain;
    }
}


if (!function_exists('cupid_post_social')):
    function cupid_post_social(){
        global $cupid_data;
        $sharing_facebook = isset($cupid_data['social-sharing']['sharing-facebook']) ? $cupid_data['social-sharing']['sharing-facebook'] : 0;
        $sharing_twitter = isset($cupid_data['social-sharing']['sharing-twitter']) ? $cupid_data['social-sharing']['sharing-twitter'] : 0;
        $sharing_google = isset($cupid_data['social-sharing']['sharing-google']) ? $cupid_data['social-sharing']['sharing-google'] : 0;
        $sharing_linkedin = isset($cupid_data['social-sharing']['sharing-linkedin']) ? $cupid_data['social-sharing']['sharing-linkedin'] : 0;
        $sharing_tumblr = isset($cupid_data['social-sharing']['sharing-tumblr']) ? $cupid_data['social-sharing']['sharing-tumblr'] : 0;
        $sharing_pinterest = isset($cupid_data['social-sharing']['sharing-pinterest']) ? $cupid_data['social-sharing']['sharing-pinterest'] : 0;
        if (($sharing_facebook == 1) ||
            ($sharing_twitter == 1) ||
            ($sharing_linkedin == 1) ||
            ($sharing_tumblr == 1) ||
            ($sharing_google == 1) ||
            ($sharing_pinterest == 1)
        ) :
            ?>
            <div class="entry-share-wrapper">
            <div class="entry-share">
                <div class="entry-share-inner">
                    <span><?php _e("Share","cupid"); ?></span>
         <ul>
                <?php if ($sharing_facebook == 1) : ?>
                    <li><a onclick="window.open('https://www.facebook.com/sharer.php?s=100&p[title]=<?php echo esc_attr(urlencode(get_the_title())); ?>&p[url]=<?php echo esc_attr(urlencode(get_permalink()));?>&p[summary]=<?php echo esc_attr(urlencode(get_the_excerpt())); ?>&p[images][0]=<?php $arrImages =  wp_get_attachment_image_src(get_post_thumbnail_id(),'full'); echo  has_post_thumbnail() ? esc_attr($arrImages[0]) : '' ;?>','sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript:;" title="<?php _e('Share on Facebook','cupid');?>"><i class="fa fa-facebook"></i></a></li>
                <?php endif; ?>
                <?php if ($sharing_twitter == 1) :  ?>
                    <li><a onclick="popUp=window.open('http://twitter.com/home?status=<?php echo esc_attr(urlencode(get_the_title())); ?> <?php echo esc_attr(urlencode(get_permalink())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;" title="<?php _e('Share on Twitter','cupid');?>"><i class="fa fa-twitter"></i></a></li>
                <?php endif; ?>
                <?php if ($sharing_google == 1) :  ?>
                    <li><a onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo esc_attr(urlencode(get_permalink())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;" title="<?php _e('Share on Google +1','cupid');?>"><i class="fa fa-google-plus"></i></a></li>
                <?php endif; ?>
                <?php if ($sharing_linkedin == 1):?>
                    <li><a onclick="popUp=window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;title=<?php echo esc_attr(urlencode(get_the_title())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;" title="<?php _e('Share on Linkedin','cupid');?>"><i class="fa fa-linkedin"></i></a></li>
                <?php endif; ?>
                <?php if ($sharing_tumblr == 1) :  ?>
                    <li><a onclick="popUp=window.open('http://www.tumblr.com/share/link?url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;name=<?php echo esc_attr(urlencode(get_the_title())); ?>&amp;description=<?php echo esc_attr(urlencode(get_the_excerpt())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;" title="<?php _e('Share on Tumblr','cupid');?>"><i class="fa fa-tumblr"></i></a></li>
                <?php endif; ?>
                <?php if ($sharing_pinterest == 1) :  ?>
                    <li><a onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;description=<?php echo esc_attr(urlencode(get_the_title())); ?>&amp;media=<?php $arrImages = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); echo has_post_thumbnail() ? esc_attr($arrImages[0])  : "" ; ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;" title="<?php _e('Share on Pinterest','cupid');?>"><i class="fa fa-pinterest"></i></a></li>
                <?php endif; ?>
            </ul>
                </div>
            </div>
            </div>
        <?php endif;
    }
endif;


if (!function_exists('cupid_post_nav')) {
    function cupid_post_nav() {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous ) {
            return;
        }
        ?>
        <nav class="post-navigation" role="navigation">
            <div class="nav-links">
                <?php
                previous_post_link( '<div class="nav-previous">%link</div>', _x( '<i class="post-navigation-icon fa fa-angle-left"></i> <span class="post-navigation-content"><span class="post-navigation-label">Previous Post</span> <h4 class="post-navigation-title">%title </h4> </span> ', 'Previous post link', 'cupid' ) );
                next_post_link( '<div class="nav-next">%link</div>', _x( '<i class="post-navigation-icon fa fa-angle-right"></i> <span class="post-navigation-content"><span class="post-navigation-label">Next Post</span> <h4 class="post-navigation-title">%title</h4></span> ', 'Next post link', 'cupid' ) );
                ?>
            </div>
            <!-- .nav-links -->
        </nav><!-- .navigation -->
    <?php
    }
}

if (!function_exists('cupid_get_link_url')) {
    function cupid_get_link_url() {
        $content = get_the_content();
        $has_url = get_url_in_content( $content );

        return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
    }
}





