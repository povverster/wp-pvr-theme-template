<?php
/*
 * File: loader-common.php
 * Project: wp-pvr-theme-template
 * File Created: Friday, 5th June 2020 11:44:45 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Friday, 5th June 2020 11:45:04 am
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}
?>
<div id="loader">
  <img data-loader-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/loader.svg" alt="loading..." />
</div>