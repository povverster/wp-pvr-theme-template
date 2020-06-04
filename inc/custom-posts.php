<?php
/*
 * File: custom-posts.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 12:11:09 pm
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Thursday, 4th June 2020 6:14:14 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

add_action('init', function () {
  // ------------ PAGES GALLERIES --------------
  // -------------- post type ------------------
  register_post_type(
    'cp_page_gallery',
    [
      'labels' => [
        'name' => __('Pages galleries'),
        'singular_name' => __('page gallery'),
        'add_new' => __('Add page gallery'),
        'add_new_item' => __('Add new page gallery'),
        'edit' => __('Edit'),
        'edit_item' => __('Edit page gallery'),
        'new_item' => __('New page gallery'),
        'view' => __('View page gallery'),
        'view_item' => __('View one page gallery'),
        'search_items' => __('Search page gallery'),
        'not_found' => __('Pages galleries are not found'),
        'not_found_in_trash' => __('There is no page gallery in the trash')
      ],
      'public' => true,
      'publicly_queryable' => false,
      'supports' => ['title', 'editor', 'page-attributes']
    ]
  );
  // -------------------------------------------
});
