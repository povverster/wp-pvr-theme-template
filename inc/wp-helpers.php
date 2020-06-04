<?php
/*
 * File: wp-helpers.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:42:50 am
 * Author: povverster (povverster@gmail.com)
 * -----
 * Last Modified: Thursday, 4th June 2020 2:00:53 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

function get_responsive_thumbnails(int $post_id, string $default_image = null): array
{
  if (empty($post_id) || !is_numeric(($post_id))) {
    return [];
  }

  $thumb_title = '';
  $thumb_id = get_post_thumbnail_id($post_id);
  if (!empty($thumb_id) && is_numeric($thumb_id)) {
    $thumb = get_post($thumb_id);
    if (!empty($thumb->post_title)) {
      $thumb_title = $thumb->post_title;
    }
  }

  $retina = get_the_post_thumbnail_url($post_id, 'retina');
  $desktop = get_the_post_thumbnail_url($post_id, 'desktop');
  $laptop = get_the_post_thumbnail_url($post_id, 'laptop');
  $smartphone = get_the_post_thumbnail_url($post_id, 'smartphone');
  $mobile = get_the_post_thumbnail_url($post_id, 'mobile');
  $mobile_m = get_the_post_thumbnail_url($post_id, 'mobile_m');
  $mobile_s = get_the_post_thumbnail_url($post_id, 'mobile_s');
  $mobile_xs = get_the_post_thumbnail_url($post_id, 'mobile_xs');

  if (empty($retina) && !empty($default_image)) {
    $retina = $default_image;
  }
  if (empty($desktop) && !empty($default_image)) {
    $desktop = $default_image;
  }
  if (empty($laptop) && !empty($default_image)) {
    $laptop = $default_image;
  }
  if (empty($smartphone) && !empty($default_image)) {
    $smartphone = $default_image;
  }
  if (empty($mobile) && !empty($default_image)) {
    $mobile = $default_image;
  }
  if (empty($mobile_m) && !empty($default_image)) {
    $mobile_m = $default_image;
  }
  if (empty($mobile_s) && !empty($default_image)) {
    $mobile_s = $default_image;
  }
  if (empty($mobile_xs) && !empty($default_image)) {
    $mobile_xs = $default_image;
  }

  if (
    empty($retina) ||
    empty($desktop) ||
    empty($laptop) ||
    empty($smartphone) ||
    empty($mobile) ||
    empty($mobile_m) ||
    empty($mobile_s) ||
    empty($mobile_xs)
  ) {
    return [];
  }

  return [
    'retina' => $retina,
    'desktop' => $desktop,
    'laptop' => $laptop,
    'smartphone' => $smartphone,
    'mobile' => $mobile,
    'mobile_m' => $mobile_m,
    'mobile_s' => $mobile_s,
    'mobile_xs' => $mobile_xs,
    'sizes' => "$retina, $desktop 1980, $laptop 1200, $smartphone 900, $mobile 700, $mobile_m 576, $mobile_s 480, $mobile_xs 380",
    'src' => $mobile_xs,
    'thumb_title' => $thumb_title
  ];
}

function get_responsive_attachment(int $attachment_id): array
{
  if (empty($attachment_id) || !is_numeric(($attachment_id))) {
    return [];
  }

  $retina = wp_get_attachment_image_url($attachment_id, 'retina');
  $desktop = wp_get_attachment_image_url($attachment_id, 'desktop');
  $laptop = wp_get_attachment_image_url($attachment_id, 'laptop');
  $smartphone = wp_get_attachment_image_url($attachment_id, 'smartphone');
  $mobile = wp_get_attachment_image_url($attachment_id, 'mobile');
  $mobile_m = wp_get_attachment_image_url($attachment_id, 'mobile_m');
  $mobile_s = wp_get_attachment_image_url($attachment_id, 'mobile_s');
  $mobile_xs = wp_get_attachment_image_url($attachment_id, 'mobile_xs');

  if (
    empty($retina) ||
    empty($desktop) ||
    empty($laptop) ||
    empty($smartphone) ||
    empty($mobile) ||
    empty($mobile_m) ||
    empty($mobile_s) ||
    empty($mobile_xs)
  ) {
    return [];
  }

  return [
    'retina' => $retina,
    'desktop' => $desktop,
    'laptop' => $laptop,
    'smartphone' => $smartphone,
    'mobile' => $mobile,
    'mobile_m' => $mobile_m,
    'mobile_s' => $mobile_s,
    'mobile_xs' => $mobile_xs,
    'sizes' => "$retina, $desktop 1980, $laptop 1200, $smartphone 900, $mobile 700, $mobile_m 576, $mobile_s 480, $mobile_xs 380",
    'src' => $mobile_xs
  ];
}

function get_permalink_by_slug(string $slug)
{
  $page = get_page_by_path($slug);

  $page_url = false;
  if (!empty($page)) {
    $page_url = get_permalink($page);
  }

  if (filter_var($page_url, FILTER_VALIDATE_URL) === false) {
    return false;
  }

  return $page_url;
}

function clean_post_values(array $data)
{
  if (is_array($data)) {
    foreach ($data as $key => $value) {
      $data[$key] = clean_post_values($value);
    }

    return $data;
  }

  return sanitize_text_field($data);
}

function get_current_role_name()
{
  $current_user = wp_get_current_user();

  $role_name = null;
  if (!empty($current_user->roles[0])) {
    $role_name = $current_user->roles[0];
  }

  return $role_name;
}

function send_html_email(
  array $to,
  string $from,
  string $subject,
  string $message,
  array $attachments = []
): bool {
  $headers = [
    'From: Me Myself <' . $from . '>',
    'content-type: text/html'
  ];

  return wp_mail($to, $subject, $message, $headers, $attachments);
}

function send_test_email(string $email)
{
  $headers = [
    'From: Me Myself <me@example.net>',
    'content-type: text/html'
  ];

  return wp_mail($email, 'test', 'Lorem ipsum...', $headers);
}
