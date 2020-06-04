<?php
/*
 * File: index.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 10:28:13 am
 * Author: povverster (povverster@gmail.com)
 * -----
 * Last Modified: Thursday, 4th June 2020 12:47:53 pm
 * Modified By: povverster (povverster@gmail.com>)
 * -----
 * Copyright 2020 - povverster
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

get_header();
the_content();
get_footer();
