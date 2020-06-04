<?php
/*
 * File: page.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 10:33:42 am
 * Author: povverster (povverster@gmail.com)
 * -----
 * Last Modified: Thursday, 4th June 2020 12:47:19 pm
 * Modified By: povverster (povverster@gmail.com>)
 * -----
 * Copyright 2020 - povverster
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
