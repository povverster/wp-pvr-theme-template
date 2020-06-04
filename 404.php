<?php
/*
 * File: 404.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:18:33 am
 * Author: povverster (povverster@gmail.com)
 * -----
 * Last Modified: Thursday, 4th June 2020 2:00:53 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

get_header();

if (have_posts()) {
  the_post();

  the_title();
  the_content();

  wp_reset_postdata();
}

get_footer();
