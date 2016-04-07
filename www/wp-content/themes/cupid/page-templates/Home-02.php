<?php
/**
 * Template Name: Home 02
 *
 * @package g5PlusFrameWork
 */
global $cupid_data;
$logo         = THEME_URL . 'assets/images/logo-2.png';

$arr_style = array(
    //'primary-color' => '#D93F63',
    'primary-color' => '#FFA73C',
    'secondary-color' => '#D93F63',
    'button-color' => '#D93F63',
    'bullet-color' => '#FFA73C',
    'icon-box-color' => '#ffa73c',
    'site-top-layout' => '2',
    'header-layout' => '2',
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