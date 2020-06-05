<?php
/*
 * File: common.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:41:39 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Friday, 5th June 2020 11:56:11 am
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

/* Static files versions */
if (!defined('FVER')) {
  define('FVER', '1.0.0');
}

if (!defined('RECAPTCHA_SCORE_LEVEL')) {
  define('RECAPTCHA_SCORE_LEVEL', 0.5);
}
