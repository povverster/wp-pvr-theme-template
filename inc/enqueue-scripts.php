<?php
/*
 * File: enqueue-scripts.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:42:50 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Friday, 5th June 2020 1:18:15 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

add_action('wp_enqueue_scripts', function () {
  $page_id = get_the_ID();
  $page = get_post($page_id);

  $recaptcha_public = get_option('recaptcha_public');

  wp_deregister_style('flui');
  wp_deregister_style('customForm');
  wp_deregister_style('formError');
  wp_deregister_style('reset');
  wp_deregister_style('all');
  wp_deregister_style('media');
  wp_deregister_style('correctors');

  wp_enqueue_style('flui', get_stylesheet_directory_uri() . '/assets/libs/flui/flui.css', [], FVER);
  wp_enqueue_style('customForm', get_stylesheet_directory_uri() . '/assets/libs/customForm/customForm.css', [], FVER);
  wp_enqueue_style('formError', get_stylesheet_directory_uri() . '/assets/libs/formError/form-error.css', [], FVER);
  wp_enqueue_style('reset', get_stylesheet_directory_uri() . '/assets/css/reset.css', [], FVER);
  wp_enqueue_style('all', get_stylesheet_directory_uri() . '/assets/css/all.css', [], FVER);
  wp_enqueue_style('media', get_stylesheet_directory_uri() . '/assets/css/media.css', [], FVER);
  wp_enqueue_style('correctors', get_stylesheet_directory_uri() . '/assets/css/correctors.css', [], FVER);

  wp_deregister_script('jquery');
  wp_deregister_script('flui');
  wp_deregister_script('customForm');
  wp_deregister_script('formError');
  wp_deregister_script('common');
  wp_deregister_script('loader');

  wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/assets/libs/jquery.min.js', [], FVER, false);
  wp_enqueue_script('flui', get_stylesheet_directory_uri() . '/assets/libs/flui/flui.js', ['jquery'], FVER, true);
  wp_enqueue_script('formError', get_stylesheet_directory_uri() . '/assets/libs/formError/form-error.js', ['jquery', 'flui'], FVER, true);
  wp_enqueue_script('customForm', get_stylesheet_directory_uri() . '/assets/libs/customForm/customForm.js', ['jquery', 'flui'], FVER, true);
  wp_enqueue_script('common', get_stylesheet_directory_uri() . '/assets/js/common.js', ['jquery', 'flui'], FVER, true);
  wp_enqueue_script('loader', get_stylesheet_directory_uri() . '/assets/js/loader.js', ['jquery'], FVER, true);


  wp_localize_script(
    'common',
    'pvrAjax',
    [
      'url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('pvr_nonce')
    ]
  );

  wp_localize_script(
    'common',
    'fe_root',
    get_stylesheet_directory_uri() . '/assets/libs/formError/'
  );

  wp_localize_script(
    'common',
    'homeUrl',
    get_site_url()
  );

  wp_localize_script(
    'common',
    'stylesheetUrl',
    get_stylesheet_directory_uri()
  );

  if ($recaptcha_public) {
    wp_localize_script(
      'common',
      'recaptchaPublic',
      "$recaptcha_public"
    );
  }

  wp_localize_script(
    'common',
    'webpSupport',
    (int) WEBP_SUPPORT . ''
  );
});
