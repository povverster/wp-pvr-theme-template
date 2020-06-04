<?php
/*
 * File: verify-google-recaptcha.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:46:35 am
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

function verify_google_recaptcha(string $secret, string $response, string $remoteip = null)
{
  $curl = curl_init();

  if (!empty($curl)) {
    curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);

    $post_data = [
      'secret' => $secret,
      'response' => $response
    ];

    if (!empty($remoteip)) {
      $post_data['remoteip'] = $remoteip;
    }

    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

    $out = curl_exec($curl);

    curl_close($curl);

    return json_decode($out, true);
  }

  return false;
}

function check_google_recaptcha_response(
  array $recaptcha_resp,
  string $action,
  float $score_level = 0.5
): bool {
  return
    !empty($recaptcha_resp) && is_array($recaptcha_resp) &&
    !empty($action) && is_string($action) &&
    !empty($score_level) && is_float($score_level) &&
    !empty($recaptcha_resp['action']) && $recaptcha_resp['action'] === $action &&
    !empty($recaptcha_resp['success']) && $recaptcha_resp['success'] === true &&
    !empty($recaptcha_resp['score']) && $recaptcha_resp['score'] >= $score_level;
}
