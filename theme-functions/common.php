<?php
/*
 * File: common.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:41:39 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Thursday, 4th June 2020 6:25:00 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

function theme_template(string $category, string $name)
{
  locate_template("theme-templates/$category/$name.php", true, false);
}

function get_page_gallery_images(string $gallery_slug): array
{
  $posts = get_posts([
    'post_type' => 'cp_page_gallery',
    'numberposts' => 1,
    'meta_query' => [
      'key' => 'cp_page_gallery_slug',
      'value' => $gallery_slug
    ]
  ]);
  wp_reset_postdata();

  $gallery_post_id = $posts[0]->ID ?? null;
  $gallery = get_post_gallery($gallery_post_id, false);
  $str_attachments_ids = $gallery['ids'] ?? null;

  if (empty($str_attachments_ids)) {
    return [];
  }

  $result = [];

  $attachments_ids = explode(',', $str_attachments_ids);
  foreach ($attachments_ids as $attachment_id) {
    $attachment = get_responsive_attachment((int) $attachment_id);

    if (!empty($attachment)) {
      $result[] = $attachment;
    }
  }

  return $result;
}
