<?php
/*
 * File: metaboxes.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:34:13 am
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

add_action('admin_menu', function () {
  $post_id = !empty($_GET['post']) && is_numeric($_GET['post']) ? $_GET['post'] : NULL;

  $post = get_post($post_id);
  $post_type = !empty($post->post_type) ? $post->post_type : false;
  $post_name = !empty($post->post_name) ? $post->post_name : false;

  add_meta_box('page_options', 'Page options', 'page_options', ['page'], 'normal', 'high');
});

function page_options($post)
{
  wp_nonce_field(basename(__FILE__), 'options_metabox_nonce');
}

add_action('save_post', function ($post_id) {
  if (
    !isset($_POST['options_metabox_nonce'])
    || !wp_verify_nonce($_POST['options_metabox_nonce'], basename(__FILE__))
  ) {
    return $post_id;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  if (!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }

  $post = get_post($post_id);
  $post_type = !empty($post->post_type) ? $post->post_type : false;
  $post_name = !empty($post->post_name) ? $post->post_name : false;

  return $post_id;
});
