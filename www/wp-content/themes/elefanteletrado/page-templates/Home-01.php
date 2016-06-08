<?php
/**
 * Template Name: Home 01
 *
 * @package g5PlusFrameWork
 */
global $cupid_data;
$arr_style = array(
    'primary-color' => '#D93F63',
    'secondary-color' => '#FFA73C',
    'button-color' => '#D93F63',
    'bullet-color' => '#A273B9',
    'icon-box-color' => '#FFA73C',
    'site-top-layout' => '1',
    'header-layout' => '1',
    'page-layout' => 'full-content',
    'layout-style' => 'wide'
);
foreach ($arr_style as $key => $value) {
    $cupid_data[$key] = $value;
}
get_header();
get_template_part('content','top');
get_template_part('templates/page');
get_footer();