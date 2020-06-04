<?php
/*
 * File: options.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:46:05 am
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

if (wp_doing_ajax()) {
  // Remove OG image
  add_action('wp_ajax_remove_og_image', 'remove_og_image_callback');
  function remove_og_image_callback()
  {
    check_ajax_referer('pvr_nonce', 'nonce_code');

    if (empty($_POST['og_image'])) {
      header400();
      echo json_encode(['code' => 'wrong_removing', 'message' => 'Wrong post']);
      die();
    }

    $filepath = rtrim(ABSPATH, '/') . '/' . ltrim($_POST['og_image'], '/');
    if (!file_exists($filepath)) {
      header400();
      echo json_encode(['code' => 'wrong_removing', 'message' => 'File not found']);
      die();
    }

    unlink($filepath);
    delete_option('og_image');

    header200();
    echo json_encode(['status' => 'success']);
    die();
  }

  // Remove main logo
  add_action('wp_ajax_remove_main_logo_image', 'remove_main_logo_image_callback');
  function remove_main_logo_image_callback()
  {
    check_ajax_referer('pvr_nonce', 'nonce_code');

    if (empty($_POST['main_logo_image'])) {
      header400();
      echo json_encode(['code' => 'wrong_removing', 'message' => 'Wrong post']);
      die();
    }

    $filepath = rtrim(ABSPATH, '/') . '/' . ltrim($_POST['main_logo_image'], '/');
    if (!file_exists($filepath)) {
      header400();
      echo json_encode(['code' => 'wrong_removing', 'message' => 'File not found']);
      die();
    }

    unlink($filepath);
    delete_option('main_logo_image');

    header200();
    echo json_encode(['status' => 'success']);
    die();
  }

  // Remove footer logo
  add_action('wp_ajax_remove_footer_logo_image', 'remove_footer_logo_image_callback');
  function remove_footer_logo_image_callback()
  {
    check_ajax_referer('pvr_nonce', 'nonce_code');

    if (empty($_POST['footer_logo_image'])) {
      header400();
      echo json_encode(['code' => 'wrong_removing', 'message' => 'Wrong post']);
      die();
    }

    $filepath = rtrim(ABSPATH, '/') . '/' . ltrim($_POST['footer_logo_image'], '/');
    if (!file_exists($filepath)) {
      header400();
      echo json_encode(['code' => 'wrong_removing', 'message' => 'File not found']);
      die();
    }

    unlink($filepath);
    delete_option('footer_logo_image');

    header200();
    echo json_encode(['status' => 'success']);
    die();
  }
}
