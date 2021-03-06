<?php
/*
 * File: index.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 10:28:13 am
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
the_content();
get_footer();
