<?php
/*
 * File: common.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:41:39 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Thursday, 4th June 2020 4:30:31 pm
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
