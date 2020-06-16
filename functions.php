<?php
/*
 * File: functions.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 10:28:38 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Tuesday, 16th June 2020 10:50:50 am
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
  session_start();
}

require_once get_stylesheet_directory() . '/theme-constants/common.php';

require_once get_stylesheet_directory() . '/inc/helpers.php';
require_once get_stylesheet_directory() . '/inc/wp-helpers.php';
require_once get_stylesheet_directory() . '/inc/redirects.php';

add_theme_support('menus');
add_theme_support('post-thumbnails');

$webp_support = false;
if (!empty($_SERVER['HTTP_ACCEPT'])) {
  $webp_support = (bool) preg_match('/image\/{1}webp/', $_SERVER['HTTP_ACCEPT']);
}

if (!defined('WEBP_SUPPORT')) {
  define('WEBP_SUPPORT', $webp_support);
}

// Disable adminbar for all
add_filter('show_admin_bar', '__return_false');

// Media configuring
if (current_user_can('manage_options')) {
  if (is_admin()) {
    update_option('thumbnail_size_w', 150);
    update_option('thumbnail_size_h', 150);
    update_option('thumbnail_crop', 1);

    update_option('medium_size_w', 300);
    update_option('medium_size_h', 300);

    update_option('large_size_w', 1024);
    update_option('large_size_h', 1024);

    if (function_exists('add_image_size')) {
      add_image_size('mobile_xs', 380, 380);
      add_image_size('mobile_s', 480, 480);
      add_image_size('mobile_m', 576, 576);
      add_image_size('mobile', 770, 770);
      add_image_size('smartphone', 1000, 1000);
      add_image_size('laptop', 1300, 1300);
      add_image_size('desktop', 1920, 1920);
      add_image_size('double', 2880, 2880);
      add_image_size('retina', 5120, 5120);
    }
  }
}

add_action('admin_init', 'action_admin_init');
function action_admin_init()
{
  wp_localize_script(
    'jquery',
    'pvrAjax',
    [
      'url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('pvr_nonce')
    ]
  );

  wp_localize_script(
    'jquery',
    'homeUrl',
    get_site_url()
  );

  // Hide Posts in admin menu
  // remove_menu_page('edit.php');
}

add_action('admin_head', 'hide_slug_options');
function hide_slug_options()
{
  global $post;
  global $pagenow;

  $hide_slugs = "<style type=\"text/css\">.editor-post-link, .edit-post-post-status { display: none !important; }</style>\n";

  if (is_admin() && !empty($post->post_name) && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
    foreach (STATIC_SLUGS as $slug) {
      $slug_parts = explode('/', $slug);
      if ($post->post_name === end($slug_parts)) {
        print($hide_slugs);
      }
    }
  }
}

require_once get_stylesheet_directory() . '/inc/cache-control.php';
require_once get_stylesheet_directory() . '/inc/posts-deleting.php';
require_once get_stylesheet_directory() . '/inc/enqueue-scripts.php';
require_once get_stylesheet_directory() . '/inc/custom-posts.php';
require_once get_stylesheet_directory() . '/inc/verify-google-recaptcha.php';

require_once get_stylesheet_directory() . '/theme-menus/common.php';
require_once get_stylesheet_directory() . '/theme-functions/common.php';

require_once get_stylesheet_directory() . '/inc/wp-cron.php';

require_once get_stylesheet_directory() . '/inc/metaboxes.php';
require_once get_stylesheet_directory() . '/inc/options.php';

require_once get_stylesheet_directory() . '/inc/ajax/common.php';
require_once get_stylesheet_directory() . '/inc/ajax/options.php';
