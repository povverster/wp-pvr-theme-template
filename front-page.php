<?php
/*
 * File: front-page.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:17:24 am
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

get_header();

if (have_posts()) {
  the_post();

  the_title();
  the_content();

  wp_reset_postdata();
}

get_footer();
