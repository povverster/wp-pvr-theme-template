<?php
/*
 * File: header.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 10:29:37 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Friday, 10th July 2020 11:04:25 am
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

$main_logo_image = null;
if (!empty(get_option('main_logo_image'))) {
  $main_logo_image = get_site_url() . get_option('main_logo_image');
}

$og_url = get_option('og_url');
$og_type = get_option('og_type');
$og_title = get_option('og_title');
$og_descr = get_option('og_descr');
$og_image = get_option('og_image');

$recaptcha_public = get_option('recaptcha_public');

if (defined('WP_DEBUG') && WP_DEBUG) {
  header('X-Robots-Tag: noindex, nofollow', true);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <?php
  if (defined('WP_DEBUG') && WP_DEBUG) {
  ?>

    <meta name="robots" content="noindex, nofollow">

  <?php
  }
  ?>

  <title>
    <?php
    bloginfo('name');
    if (!empty($post->post_title)) {
      echo ' - ' . $post->post_title;
    }
    ?>
  </title>

  <link rel="icon" type="image/x-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon.ico" />

  <?php if ($og_url) { ?>
    <meta property="og:url" content="<?php echo $og_url; ?>" />
  <?php } ?>

  <?php if ($og_type) { ?>
    <meta property="og:type" content="<?php echo $og_type; ?>" />
  <?php } ?>

  <meta property="og:title" content="<?php echo $og_title ? $og_title : ''; ?>" />

  <meta property="og:description" content="<?php echo $og_descr ? $og_descr : ' '; ?>" />

  <?php if ($og_image) { ?>
    <meta property="og:image" content="<?php echo get_site_url() . $og_image; ?>" />
  <?php } ?>

  <?php wp_head(); ?>

  <?php if ($recaptcha_public) { ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptcha_public; ?>"></script>
  <?php } ?>
</head>

<body>