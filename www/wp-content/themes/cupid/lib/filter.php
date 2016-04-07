<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 2/26/15
 * Time: 4:00 PM
 */

add_filter('post_thumbnail_html','cupid_post_thumbnail_html',99,5);
function cupid_post_thumbnail_html($html,$post_id,$post_thumbnail_id,$size,$attr) {
    global $cupid_archive_loop;
    $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, $size );
    $image = $arrImages[0];

    global $_wp_additional_image_sizes;
    $width = '';
    $height = '';
    if (isset($size) && isset($_wp_additional_image_sizes[$size])) {
        $width = 'width="'. $_wp_additional_image_sizes[$size]['width'].'"';
        $height = 'height="'. $_wp_additional_image_sizes[$size]['height'] .'"';
    }

    if (isset($cupid_archive_loop['image-style']) && $cupid_archive_loop['image-style'] = 'small') {
        return cupid_get_image_hover($image,get_permalink($post_id),get_the_title($post_id),$size);
    }
    $post_type = get_post_type($post_id);

    switch($post_type){
        case 'cupid_gallery':{
            $arrImagesOrigin = wp_get_attachment_image_src( $post_thumbnail_id,'full');
            $image_origin = $arrImagesOrigin[0];
            $meta_class_values = get_post_meta( get_the_ID(), 'gallery-class', false );
            $class = '<h5 class="class-name">'.get_the_title($post_id).'</h5>';
            if(count($meta_class_values)>0 && $meta_class_values[0]!=''){
                $class_name = $meta_class_values[0];
                $class_title = $meta_class_values[0];
                $posts = get_posts(array('name' => $class_name, 'post_type' => 'cupid_classes'));
                if(isset($posts) && count($posts) >0){
                    $class_title = $posts[0]->post_title;
                }
                $class = '<h5 class="class-name"><span class="class-title">'.__('Class:','cupid').'</span>'.$class_title.'</h5>';
            }
            $html = sprintf(' <div class="entry-thumbnail title">
                                        <img %7$s %8$s src="'.$image_origin.'" alt="%2$s"/>
                                            <div class="entry-thumbnail-hover">
                                                <div class="entry-hover-wrapper">
                                                    <div class="entry-hover-inner">
                                                    <a href="http://promo.elefanteletrado.com.br/pagina-de-amostras" title="%2$s" target="_blank">
                                                        %5$s
                                                        <span class="excerpt">%6$s</span>
                                                    </a>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>',
                                    $image,
                                    get_the_title($post_id),
                                    $image_origin,
                                    $post_id,
                                    $class,
                                    get_the_excerpt(),
                                    '320',
                                    '240'
            );
            break;
        }
        case 'cupid_classes':{
            $month_old = get_post_meta( get_the_ID(), 'month-olds', false );
            $class_size = get_post_meta( get_the_ID(), 'class-size', false );
            $html_month_old = $html_class_size = '';
            if(count($month_old)>0)
                $html_month_old = '<div class="month-olds round"><span>'.$month_old[0].'</span><span>'.__(' month old','cupid').'</span></div>';
            if(count($class_size))
                $html_class_size = '<div class="class-size round"><span>'.$class_size[0].'</span><span>'.__(' class size','cupid').'</span></div>';
            $html = sprintf('<div class="entry-thumbnail">
                                <a href="%1$s" title="%3$s" ><img %6$s %7$s src="%2$s" alt="%3$s" class="img-responsive"></a>
                                <div class="meta-info">
                                    <div class="meta-info-inner">%4$s %5$s</div>
                                </div>
                            </div>',get_permalink(), $image, get_the_title($post_id), $html_month_old, $html_class_size,$width,$height);
            $html;
            break;
        }
        case "post":{
            $html = cupid_get_image_hover($image,get_permalink($post_id),get_the_title($post_id),$size);
        }
        default :
            return $html;
            break;
    }

    return $html;
}

if (!function_exists('cupid_search_form')) {
    function cupid_search_form( $form ) {
        $form =  '<form role="search" class="cupid-search-form" method="get" id="searchform" action="' . home_url( '/' ) . '">
                <input type="text" value="' . get_search_query() . '" name="s" id="s"  placeholder="'.__("Busca",'cupid').'">
                <button type="submit"><i class="fa fa-search"></i></button>
     		</form>';
        return $form;
    }
    add_filter( 'get_search_form', 'cupid_search_form' );
}

if (!function_exists('cupid_search_posts_filter')) {
    function cupid_search_posts_filter( $query ){
        if (!is_admin() && $query->is_search && !is_post_type_archive( 'product' )){
            $query->set('post_type',array('post','cupid_classes'));
        }
        return $query;
    }
    add_filter('pre_get_posts','cupid_search_posts_filter');
}

/* -----------------------------------------------------------------------------
 * Add Site Title
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'cupid_wp_title' )) {
    function cupid_wp_title( $title, $sep ) {
        global $paged, $page,$wp_version;

        if (version_compare($wp_version,'4.1','>=')){
            return $title;
        }

        if ( is_feed() ) {
            return $title;
        }

        // Add the site name.
        $title .= get_bloginfo( 'name' );

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title = "$title $sep $site_description";
        }

        // Add a page number if necessary.
        if ( $paged >= 2 || $page >= 2 ) {
            $title = "$title $sep " . sprintf( __( 'Page %s', 'cupid' ), max( $paged, $page ) );
        }

        return $title;
    }
    add_filter( 'wp_title', 'cupid_wp_title',10,2 );
}


add_filter('wp_generate_tag_cloud', 'cupid_tag_cloud',10,3);

function cupid_tag_cloud($tag_string){
    return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
}


add_filter( 'script_loader_src', 'cupid_remove_src_version' );
add_filter( 'style_loader_src', 'cupid_remove_src_version' );

function cupid_remove_src_version ( $src ) {
	if ((strpos($src, '.js?') === false) && (strpos($src, '.css?') === false)) {
		return $src;
	}
    $pos_ver = strpos($src,'?');
    if ($pos_ver === false) {
        return $src;
    }
    return substr($src, 0, $pos_ver);
}

add_filter( 'script_loader_tag', 'cupid_scrip_loader_tag', 10, 2 );
function cupid_scrip_loader_tag( $tag, $handle ) {
	if ($handle == 'jquery-core') {
		return $tag;
	}
	return str_replace( ' src', ' defer="defer" src', $tag );
}