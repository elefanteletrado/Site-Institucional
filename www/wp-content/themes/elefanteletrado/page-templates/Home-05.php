<?php
/**
 * Template Name: Home 05
 *
 * @package g5PlusFrameWork
 */
global $cupid_data;
$logo         = THEME_URL . 'assets/images/logo-5.png';
$arr_style = array(
    'primary-color' => '#d83f63',
    'secondary-color' => '#A273B9',
    'button-color' => '#FFA73C',
    'bullet-color' => '#A273B9',
    'icon-box-color' => '#D93F63',
    'site-top-layout' => '1',
    'header-layout' => '5',
    'page-layout' => 'full-content',
    'layout-style' => 'boxed',
    'site-logo' => $logo
);
foreach ($arr_style as $key => $value) {
    $cupid_data[$key] = $value;
}
get_header();
get_template_part('content','top');
get_template_part('templates/page');
get_footer();