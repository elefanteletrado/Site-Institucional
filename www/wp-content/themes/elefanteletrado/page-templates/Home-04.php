<?php
/**
 * Template Name: Home 04
 *
 * @package g5PlusFrameWork
 */
global $cupid_data;
$logo         = THEME_URL . 'assets/images/logo-4.png';
$arr_style = array(
    'primary-color' => '#d83f63',
    'secondary-color' => '#91DCD8',
    'button-color' => '#A273B9',
    'bullet-color' => '#A273B9',
    'icon-box-color' => '#91DCD8',
    'site-top-layout' => '4',
    'header-layout' => '4',
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