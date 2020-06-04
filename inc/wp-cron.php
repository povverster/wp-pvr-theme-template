<?php
/*
 * File: wp-cron.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:42:50 am
 * Author: povverster (povverster@gmail.com)
 * -----
 * Last Modified: Thursday, 4th June 2020 2:00:53 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

add_action('wp', function () {
  // if (!wp_next_scheduled('remove_empty_dirs_hook')) {
  //   wp_schedule_event(time(), 'daily', 'remove_empty_dirs_hook');
  // }
});

// add_action('remove_empty_dirs_hook', function () {
//   $dir = WP_CONTENT_DIR . '/uploads/any-dir/';

//   $is_removed = false;
//   do {
//     $is_removed = remove_empty_subdirs($dir);
//   } while ($is_removed);
// });
