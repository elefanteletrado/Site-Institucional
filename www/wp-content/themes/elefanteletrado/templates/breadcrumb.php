<?php
$on_front = get_option('show_on_front');
if (is_home() && !($on_front = 'show_on_front' && get_queried_object_id() == get_page(get_option('page_for_posts'))->ID)) return;
cupid_get_breadcrumb();

