<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;
$index = 0;
$attachment_ids = $product->get_gallery_attachment_ids();
if ($product->product_type == 'variable') {
    $available_variations = $product->get_available_variations();
    $selected_attributes = $product->get_variation_default_attributes();
}

$attachment_count = count($attachment_ids);
if ( $attachment_count > 0 ) {
    $gallery = '[product-gallery]';
} else {
    $gallery = '';
}
?>
<div class="single-product-image-wrapper">
    <div class="single-product-image-container" id="product_slider_container">
        <div class="single-product-images" u="slides">
            <?php if (has_post_thumbnail()) {
                $image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
                $image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
                $image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
                $image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                    'title'	=> $image_title,
                    'alt'	=> $image_title
                ) );
                $image_thumb       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
                    'title'	=> $image_title,
                    'alt'	=> $image_title
                ) );



                echo '<div>';
                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a u="image" href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );
                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a u="thumb" href="javascript:;" itemprop="thumb" title="%s" data-index="%s">%s</a>', $image_caption,$index, $image_thumb ), $post->ID );
                echo '</div>';
                $index++;
            }

            if (isset($available_variations)){
                foreach ($available_variations as $available_variation){
                    $variation_id = $available_variation['variation_id'];
                    if (has_post_thumbnail($variation_id)) {

                        $image_title 	= esc_attr( get_the_title( $variation_id ) );
                        $image_caption 	= get_post(get_post_thumbnail_id($variation_id))->post_excerpt;
                        $image_link  	= wp_get_attachment_url( $variation_id);
                        $image       	= get_the_post_thumbnail( $variation_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                            'title'	=> $image_title,
                            'alt'	=> $image_title
                        ) );
                        $image_thumb       	= get_the_post_thumbnail( $variation_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
                            'title'	=> $image_title,
                            'alt'	=> $image_title
                        ) );

                        echo '<div>';
                        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a u="image" href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption,$image ), $post->ID );
                        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a u="thumb" href="javascript:;" itemprop="thumb" title="%s"  data-variation_id="%s" data-index="%s">%s</a>', $image_caption,$variation_id,$index, $image_thumb ), $post->ID );
                        echo '</div>';
                        $index++;
                    }
                }
            }

            if($attachment_ids) {
                foreach ( $attachment_ids as $attachment_id ) {
                    $image_link = wp_get_attachment_url( $attachment_id );
                    if ( ! $image_link ) {
                        continue;
                    }

                    $image_title 	= esc_attr( get_the_title( $attachment_id ) );
                    $image_caption 	= get_post( $attachment_id )->post_excerpt;

                    $image       	= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                        'title'	=> $image_title,
                        'alt'	=> $image_title
                    ) );
                    $image_thumb       	= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
                        'title'	=> $image_title,
                        'alt'	=> $image_title
                    ) );

                    echo '<div>';
                    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a u="image" href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption,$image ), $post->ID );
                    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a u="thumb" href="javascript:;" itemprop="thumb"  title="%s"   data-index="%s">%s</a>', $image_caption,$index, $image_thumb ), $post->ID );
                    echo '</div>';
                    $index++;

                }
            }


            ?>
        </div>
        <div u="thumbnavigator" class="jssort01" style="position: absolute; width: 550px; height: 270px; left:0px; bottom: 0px;overflow: hidden;">
            <div u="slides" style="cursor: move;">
                <div u="prototype" class="p" style="position: absolute; width: 270px; height: 270px; top: 0; left: 0;">
                    <div class=w><div u="thumbnailtemplate" style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></div></div>
                    <div class=c></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function(){
            var options = {
                $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 1500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 800,                                //Specifies default duration (swipe) for slide in milliseconds


                /*$ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 10,                             //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 360                         //[Optional] The offset position to park thumbnail
                }*/


                $ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 2,                             //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 0,                          //[Optional] The offset position to park thumbnail
                    $AutoCenter : 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("product_slider_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$ScaleWidth(Math.max(Math.min(parentWidth, 570), 290));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);



            $(document).on('change','.variations_form .variations select,.variations_form .variation_form_section select,div.select',function(){
                var variation_form = $(this).closest( '.variations_form' );
                var current_settings = {},
                    reset_variations = variation_form.find( '.reset_variations' );
                variation_form.find('.variations select,.variation_form_section select' ).each( function() {
                    // Encode entities
                    var value = $(this ).val();

                    // Add to settings array
                    current_settings[ $( this ).attr( 'name' ) ] = jQuery(this ).val();
                });

                variation_form.find('.variation_form_section div.select input[type="hidden"]' ).each( function() {
                    // Encode entities
                    var value = $(this ).val();

                    // Add to settings array
                    current_settings[ $( this ).attr( 'name' ) ] = jQuery(this ).val();
                });

                var all_variations = variation_form.data( 'product_variations' );

                var variation_id = 0;
                var match = true;

                for (var i = 0; i < all_variations.length; i++)
                {
                    match = true;
                    var variations_attributes = all_variations[i]['attributes'];
                    for(var attr_name in variations_attributes) {
                        var val1 = variations_attributes[attr_name];
                        var val2 = current_settings[attr_name];
                        if (val1 == undefined || val2 == undefined ) {
                            match = false;
                            break;
                        }
                        if (val1.length == 0) {
                            continue;
                        }

                        if (val1 != val2) {
                            match = false;
                            break;
                        }
                    }
                    if (match) {
                        variation_id = all_variations[i]['variation_id'];
                        break;
                    }
                }

                if (variation_id > 0) {
                    var index = parseInt($('a[data-variation_id="'+variation_id+'"]','.single-product-image-wrapper').data('index'),10);
	                if (!isNaN(index) ) {
		                jssor_slider1.$GoTo(index);
	                }
                }
            });
        });
    })(jQuery);
</script>
