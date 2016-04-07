<?php
$primary_color = $_REQUEST['primary-color'];
$secondary_color = $_REQUEST['secondary-color'];
$button_color = $_REQUEST['button-color'];
$bullet_color = $_REQUEST['bullet-color'];
$icon_box_color = $_REQUEST['icon-box-color'];
$theme_url = $_REQUEST['theme_url'];
echo '@primary_color:#'.$primary_color.';';
echo '@secondary_color:#'.$secondary_color.';';
echo '@button_color:#'.$button_color.';';
echo '@bullet_color:#'.$bullet_color.';';
echo '@icon_box_color:#'.$icon_box_color.';';

echo '@theme_url:"'. $theme_url . '";';
echo '@import "assets/css/less/style.less";', PHP_EOL;


