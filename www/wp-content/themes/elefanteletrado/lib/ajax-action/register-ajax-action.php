<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 2/27/15
 * Time: 3:22 PM
 */
add_action("wp_ajax_nopriv_cupid_gallery_load_more", "cupid_gallery_load_more");
add_action("wp_ajax_cupid_gallery_load_more", "cupid_gallery_load_more");
function cupid_gallery_load_more()
{

    $item = $_REQUEST["item"];
    $column = $_REQUEST["column"];
    $load_more = $_REQUEST["load_more"];
    $load_more_style = $_REQUEST['load_more_style'];
    $current_page = $_REQUEST["current_page"];
    $short_code = sprintf('[cupid_gallery column="%s" item="%s" load_more="%s" current_page="%s" load_more_style="%s"]', $column, $item, $load_more, $current_page,$load_more_style);
    echo do_shortcode($short_code);
    die();
}

add_action("wp_ajax_nopriv_cupid_classes_search", "cupid_classes_search");
add_action("wp_ajax_cupid_classes_search", "cupid_classes_search");
function cupid_classes_search()
{
    function cupid_search_classes_filter($where, &$wp_query)
    {
        global $wpdb;
        if ($keyword = $wp_query->get('search_prod_title')) {
            $where .= ' AND ((' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like($keyword) . '%\'';
            $where .= ' OR ' . $wpdb->posts . '.post_excerpt LIKE \'%' . $wpdb->esc_like($keyword) . '%\'))';
        }
        return $where;
    }

    $keyword = $_REQUEST["keyword"];
    if ($keyword) {
        $search_query = array(
            'search_prod_title' => $keyword,
            'order' => 'DESC',
            'orderby' => 'date',
            'post_status' => 'publish',
            'post_type' => array('cupid_classes'),
            'nopaging' => false,
        );
        add_filter('posts_where', 'cupid_search_classes_filter', 10, 2);
        $search = new WP_Query($search_query);
        remove_filter('posts_where', 'cupid_search_classes_filter', 10, 2);

        $html = '';
        $item_col = 'classes-col-3';
        if (function_exists('dynamic_sidebar') && is_active_sidebar('archive-classes-left-sidebar')) {
            $item_col = 'classes-col-4';
        }
        $html_item = '<div class="classes-item ' . esc_attr($item_col) . '">
                                    <div class="thumbnail-wrap">
                                        %1$s
                                    </div>
                                    <div class="content-wrap">
                                        <h6><a href="%2$s" title="%3$s">%3$s</a></h6>
                                        <div class="excerpt">%4$s</div>
                                    </div>
                                </div>';
        if ($search && $search->post_count > 0) {
            while ($search->have_posts()) : $search->the_post();
                $img = '';
                if (has_post_thumbnail()) {
                    $img = get_the_post_thumbnail(get_the_ID(), 'thumbnail-350x350');
                }
                $html .= sprintf($html_item, $img, get_permalink(), get_the_title(), get_the_excerpt());
            endwhile;
            wp_reset_postdata();

        } else
            $html = '<div class="no-post">' . __("No classes found",'cupid') . '</div>';
        echo wp_kses_post($html);
    }
    die();

}



function cupid_popup_icon()
{
    $icons = array('glass','music','search','envelope-o','heart','star','star-o','user','film','th-large','th','th-list','check','remove','close','times','search-plus','search-minus','power-off','signal','gear','cog','trash-o','home','file-o','clock-o','road','download','arrow-circle-o-down','arrow-circle-o-up','inbox','play-circle-o','rotate-right','repeat','refresh','list-alt','lock','flag','headphones','volume-off','volume-down','volume-up','qrcode','barcode','tag','tags','book','bookmark','print','camera','font','bold','italic','text-height','text-width','align-left','align-center','align-right','align-justify','list','dedent','outdent','indent','video-camera','photo','image','picture-o','pencil','map-marker','adjust','tint','edit','pencil-square-o','share-square-o','check-square-o','arrows','step-backward','fast-backward','backward','play','pause','stop','forward','fast-forward','step-forward','eject','chevron-left','chevron-right','plus-circle','minus-circle','times-circle','check-circle','question-circle','info-circle','crosshairs','times-circle-o','check-circle-o','ban','arrow-left','arrow-right','arrow-up','arrow-down','mail-forward','share','expand','compress','plus','minus','asterisk','exclamation-circle','gift','leaf','fire','eye','eye-slash','warning','exclamation-triangle','plane','calendar','random','comment','magnet','chevron-up','chevron-down','retweet','shopping-cart','folder','folder-open','arrows-v','arrows-h','bar-chart-o','bar-chart','twitter-square','facebook-square','camera-retro','key','gears','cogs','comments','thumbs-o-up','thumbs-o-down','star-half','heart-o','sign-out','linkedin-square','thumb-tack','external-link','sign-in','trophy','github-square','upload','lemon-o','phone','square-o','bookmark-o','phone-square','twitter','facebook-f','facebook','github','unlock','credit-card','rss','hdd-o','bullhorn','bell','certificate','hand-o-right','hand-o-left','hand-o-up','hand-o-down','arrow-circle-left','arrow-circle-right','arrow-circle-up','arrow-circle-down','globe','wrench','tasks','filter','briefcase','arrows-alt','group','users','chain','link','cloud','flask','cut','scissors','copy','files-o','paperclip','save','floppy-o','square','navicon','reorder','bars','list-ul','list-ol','strikethrough','underline','table','magic','truck','pinterest','pinterest-square','google-plus-square','google-plus','money','caret-down','caret-up','caret-left','caret-right','columns','unsorted','sort','sort-down','sort-desc','sort-up','sort-asc','envelope','linkedin','rotate-left','undo','legal','gavel','dashboard','tachometer','comment-o','comments-o','flash','bolt','sitemap','umbrella','paste','clipboard','lightbulb-o','exchange','cloud-download','cloud-upload','user-md','stethoscope','suitcase','bell-o','coffee','cutlery','file-text-o','building-o','hospital-o','ambulance','medkit','fighter-jet','beer','h-square','plus-square','angle-double-left','angle-double-right','angle-double-up','angle-double-down','angle-left','angle-right','angle-up','angle-down','desktop','laptop','tablet','mobile-phone','mobile','circle-o','quote-left','quote-right','spinner','circle','mail-reply','reply','github-alt','folder-o','folder-open-o','smile-o','frown-o','meh-o','gamepad','keyboard-o','flag-o','flag-checkered','terminal','code','mail-reply-all','reply-all','star-half-empty','star-half-full','star-half-o','location-arrow','crop','code-fork','unlink','chain-broken','question','info','exclamation','superscript','subscript','eraser','puzzle-piece','microphone','microphone-slash','shield','calendar-o','fire-extinguisher','rocket','maxcdn','chevron-circle-left','chevron-circle-right','chevron-circle-up','chevron-circle-down','html5','css3','anchor','unlock-alt','bullseye','ellipsis-h','ellipsis-v','rss-square','play-circle','ticket','minus-square','minus-square-o','level-up','level-down','check-square','pencil-square','external-link-square','share-square','compass','toggle-down','caret-square-o-down','toggle-up','caret-square-o-up','toggle-right','caret-square-o-right','euro','eur','gbp','dollar','usd','rupee','inr','cny','rmb','yen','jpy','ruble','rouble','rub','won','krw','bitcoin','btc','file','file-text','sort-alpha-asc','sort-alpha-desc','sort-amount-asc','sort-amount-desc','sort-numeric-asc','sort-numeric-desc','thumbs-up','thumbs-down','youtube-square','youtube','xing','xing-square','youtube-play','dropbox','stack-overflow','instagram','flickr','adn','bitbucket','bitbucket-square','tumblr','tumblr-square','long-arrow-down','long-arrow-up','long-arrow-left','long-arrow-right','apple','windows','android','linux','dribbble','skype','foursquare','trello','female','male','gittip','gratipay','sun-o','moon-o','archive','bug','vk','weibo','renren','pagelines','stack-exchange','arrow-circle-o-right','arrow-circle-o-left','toggle-left','caret-square-o-left','dot-circle-o','wheelchair','vimeo-square','turkish-lira','try','plus-square-o','space-shuttle','slack','envelope-square','wordpress','openid','institution','bank','university','mortar-board','graduation-cap','yahoo','google','reddit','reddit-square','stumbleupon-circle','stumbleupon','delicious','digg','pied-piper','pied-piper-alt','drupal','joomla','language','fax','building','child','paw','spoon','cube','cubes','behance','behance-square','steam','steam-square','recycle','automobile','car','cab','taxi','tree','spotify','deviantart','soundcloud','database','file-pdf-o','file-word-o','file-excel-o','file-powerpoint-o','file-photo-o','file-picture-o','file-image-o','file-zip-o','file-archive-o','file-sound-o','file-audio-o','file-movie-o','file-video-o','file-code-o','vine','codepen','jsfiddle','life-bouy','life-buoy','life-saver','support','life-ring','circle-o-notch','ra','rebel','ge','empire','git-square','git','hacker-news','tencent-weibo','qq','wechat','weixin','send','paper-plane','send-o','paper-plane-o','history','genderless','circle-thin','header','paragraph','sliders','share-alt','share-alt-square','bomb','soccer-ball-o','futbol-o','tty','binoculars','plug','slideshare','twitch','yelp','newspaper-o','wifi','calculator','paypal','google-wallet','cc-visa','cc-mastercard','cc-discover','cc-amex','cc-paypal','cc-stripe','bell-slash','bell-slash-o','trash','copyright','at','eyedropper','paint-brush','birthday-cake','area-chart','pie-chart','line-chart','lastfm','lastfm-square','toggle-off','toggle-on','bicycle','bus','ioxhost','angellist','cc','shekel','sheqel','ils','meanpath','buysellads','connectdevelop','dashcube','forumbee','leanpub','sellsy','shirtsinbulk','simplybuilt','skyatlas','cart-plus','cart-arrow-down','diamond','ship','user-secret','motorcycle','street-view','heartbeat','venus','mars','mercury','transgender','transgender-alt','venus-double','mars-double','venus-mars','mars-stroke','mars-stroke-v','mars-stroke-h','neuter','facebook-official','pinterest-p','whatsapp','server','user-plus','user-times','hotel','bed','viacoin','train','subway','medium');
    ob_start();
    ?>
    <div id="cupid-popup-icon-wrapper">
        <div id="TB_overlay" class="TB_overlayBG"></div>
        <div id="TB_window">
            <div id="TB_title">
                <div id="TB_ajaxWindowTitle">Icons</div>
                <div id="TB_closeAjaxWindow"><a href="#" id="TB_closeWindowButton">
                        <div class="tb-close-icon"></div>
                    </a></div>
            </div>
            <div id="TB_ajaxContent">
                <div class="popup-icon-wrapper">
                    <div class="popup-content">
                        <div class="icon-search">
                            <input placeholder="Search" type="text" id="txtSearch">

                            <div class="preview">
                                <span></span> <a id="iconPreview" href="javascript:;"><i class="fa fa-home"></i></a>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div class="list-icon">
                            <h3>Font Awesome</h3>
                            <ul id="group-1">
                                <?php foreach ($icons as $icon) {
                                    ?>
                                    <li><a title="fa-<?php echo esc_attr($icon); ?>" href="javascript:;"><i class="fa fa-<?php echo esc_attr($icon); ?>"></i></a></li>
                                <?php

                                } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="popup-bottom">
                        <a id="btnSave" href="javascript:;" class="button button-primary">Insert Icon</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    die(); // this is required to return a proper result
}

add_action('wp_ajax_popup_icon', 'cupid_popup_icon');