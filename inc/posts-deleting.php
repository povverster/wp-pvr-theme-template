<?php
/*
 * File: posts-deleting.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 4:05:03 pm
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Thursday, 4th June 2020 4:05:42 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

// ------------------- posts deleting -----------------------
add_action('before_delete_post', 'delete_post', 10, 1);
add_action('wp_trash_post', 'trash_post', 10, 1);

function delete_post($post_id)
{
  restrict_page_deletion($post_id);
}

function trash_post($post_id)
{
  restrict_page_deletion($post_id);
}
// --------------------

// disable pages deleting
function restrict_page_deletion(int $post_id)
{
  global $static_slugs;

  if (empty($static_slugs) || !is_index($post_id)) {
    echo 'Wrong pahe deleting.';
    die();
  }

  foreach ($static_slugs as $slug) {
    $cur_page = get_page_by_path($slug);
    if (!empty($cur_page->ID)) {
      if ($post_id === $cur_page->ID) {
        echo 'You are not authorized to delete this page.';
        die();
      }
    }
  }
}
