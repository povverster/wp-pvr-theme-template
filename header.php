<?php
/*
 * File: header.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 10:29:37 am
 * Author: povverster (povverster@gmail.com)
 * -----
 * Last Modified: Thursday, 4th June 2020 12:48:04 pm
 * Modified By: povverster (povverster@gmail.com>)
 * -----
 * Copyright 2020 - povverster
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

$main_logo_image = null;
if (!empty(get_option('main_logo_image'))) {
  $main_logo_image = get_site_url() . get_option('main_logo_image');
}

$recaptcha_public = get_option('recaptcha_public');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <title>
    <?php
    bloginfo('name');
    if (!empty($post->post_title)) {
      echo ' - ' . $post->post_title;
    }
    ?>
  </title>

  <link rel="icon" type="image/x-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon.ico" />

  <?php if (get_option('og_url')) { ?>
    <meta property="og:url" content="<?php echo get_option('og_url'); ?>" />
  <?php } ?>

  <?php if (get_option('og_type')) { ?>
    <meta property="og:type" content="<?php echo get_option('og_type'); ?>" />
  <?php } ?>

  <meta property="og:title" content="<?php echo empty(get_option('og_title')) ? '' : get_option('og_title'); ?>" />
  <meta property="og:description" content="<?php echo empty(get_option('og_descr')) ? ' ' : get_option('og_descr'); ?>" />

  <?php if (get_option('og_image')) { ?>
    <meta property="og:image" content="<?php echo get_site_url() . get_option('og_image'); ?>" />
  <?php } ?>

  <?php wp_head(); ?>

  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptcha_public; ?>"></script>
</head>

<body>