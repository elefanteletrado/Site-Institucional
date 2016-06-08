<?php
/**
 * Template Name: Home 06
 *
 * @package g5PlusFrameWork
 */
global $cupid_data;
$logo         = THEME_URL . 'assets/images/logo-6.png';
$arr_style = array(
    'primary-color' => '#d83f63',
    'secondary-color' => '#FFA73C',
    'button-color' => '#A273B9',
    'bullet-color' => '#A273B9',
    'icon-box-color' => '#A273B9',
    'site-top-layout' => '1',
    'header-layout' => '6',
    'page-layout' => 'full-content',
    'layout-style' => 'wide',
    'site-logo' => $logo
);
foreach ($arr_style as $key => $value) {
    $cupid_data[$key] = $value;
}
get_header();
get_template_part('content','top');
get_template_part('templates/page');
get_footer();