<?php
/*
 * File: sidebar-loader.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 1:58:41 pm
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
?>
<div id="loader">
  <img data-loader-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/loader.svg" alt="loading..." />
</div>