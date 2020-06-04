<?php
/*
 * File: custom-posts.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 12:11:09 pm
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Thursday, 4th June 2020 2:48:25 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

add_action('init', function () {
  // // ---------------- CPOST --------------------
  // // -------------- post type ------------------
  // register_post_type(
  //   'cp_post',
  //   [
  //     'labels' => [
  //       'name' => __('CPosts'),
  //       'singular_name' => __('cpost'),
  //       'add_new' => __('Add cpost'),
  //       'add_new_item' => __('Add new cpost'),
  //       'edit' => __('Edit'),
  //       'edit_item' => __('Edit cpost'),
  //       'new_item' => __('New cpost'),
  //       'view' => __('View cpost'),
  //       'view_item' => __('View one cpost'),
  //       'search_items' => __('Search cpost'),
  //       'not_found' => __('CPosts are not found'),
  //       'not_found_in_trash' => __('There is no cpost in the trash')
  //     ],
  //     'public' => true,
  //     'publicly_queryable' => false,
  //     'supports' => ['title', 'editor']
  //   ]
  // );
  // // -------------------------------------------
});
