<?php
/*
 * File: options.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:39:38 am
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

add_action('admin_menu', 'create_options_menu');
function create_options_menu()
{
  //create new top-level menu
  add_menu_page('Template options', 'Template options', 'administrator', __FILE__, 'template_settings_page');

  //call register settings function
  add_action('admin_init', 'register_mysettings');
}

function register_mysettings()
{
  //register our settings
  register_setting('cur-tmpl-settings-group', 'email');
  register_setting('cur-tmpl-settings-group', 'email_to');
  register_setting('cur-tmpl-settings-group', 'email_info');
  register_setting('cur-tmpl-settings-group', 'email_debug');

  register_setting('cur-tmpl-settings-group', 'phone');
  register_setting('cur-tmpl-settings-group', 'fax');
  register_setting('cur-tmpl-settings-group', 'address');

  register_setting('cur-tmpl-settings-group', 'footer_descr');
  register_setting('cur-tmpl-settings-group', 'cookie_modal_text');

  register_setting('cur-tmpl-settings-group', 'fb_link');
  register_setting('cur-tmpl-settings-group', 'ig_link');
  register_setting('cur-tmpl-settings-group', 'twitter_link');
  register_setting('cur-tmpl-settings-group', 'linkedin_link');

  register_setting('cur-tmpl-settings-group', 'og_url');
  register_setting('cur-tmpl-settings-group', 'og_type');
  register_setting('cur-tmpl-settings-group', 'og_title');
  register_setting('cur-tmpl-settings-group', 'og_descr');

  register_setting('cur-tmpl-settings-group', 'recaptcha_public');
  register_setting('cur-tmpl-settings-group', 'recaptcha_secret');

  if (!empty($_FILES['main_logo_image'])) {
    if (!function_exists('wp_handle_upload'))
      require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['main_logo_image'];
    $overrides = ['test_form' => false];

    // For uploading SVG. Add to wp-config.php
    // define('ALLOW_UNFILTERED_UPLOADS', true);
    $movefile = wp_handle_upload($file, $overrides);
    if (!empty($movefile['url']) && empty($movefile['error'])) {
      $url = str_replace(get_site_url(), '', $movefile['url']);
      $url = '/' . ltrim($url, '/');

      if (!empty(get_option('main_logo_image'))) {
        $cur_url = rtrim(ABSPATH, '/') . '/' . ltrim(get_option('main_logo_image'), '/');
        unlink($cur_url);
      }

      update_option('main_logo_image', $url);
    }
  }

  if (!empty($_FILES['footer_logo_image'])) {
    if (!function_exists('wp_handle_upload'))
      require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['footer_logo_image'];
    $overrides = ['test_form' => false];

    // For uploading SVG. Add to wp-config.php
    // define('ALLOW_UNFILTERED_UPLOADS', true);
    $movefile = wp_handle_upload($file, $overrides);
    if (!empty($movefile['url']) && empty($movefile['error'])) {
      $url = str_replace(get_site_url(), '', $movefile['url']);
      $url = '/' . ltrim($url, '/');

      if (!empty(get_option('footer_logo_image'))) {
        $cur_url = rtrim(ABSPATH, '/') . '/' . ltrim(get_option('footer_logo_image'), '/');
        unlink($cur_url);
      }

      update_option('footer_logo_image', $url);
    }
  }

  if (!empty($_FILES['og_image'])) {
    if (!function_exists('wp_handle_upload'))
      require_once(ABSPATH . 'wp-admin/includes/file.php');

    $file = &$_FILES['og_image'];
    $overrides = ['test_form' => false];

    // For uploading SVG. Add to wp-config.php
    // define('ALLOW_UNFILTERED_UPLOADS', true);
    $movefile = wp_handle_upload($file, $overrides);
    if (!empty($movefile['url']) && empty($movefile['error'])) {
      $url = str_replace(get_site_url(), '', $movefile['url']);
      $url = '/' . ltrim($url, '/');

      if (!empty(get_option('og_image'))) {
        $cur_url = rtrim(ABSPATH, '/') . '/' . ltrim(get_option('og_image'), '/');
        unlink($cur_url);
      }

      update_option('og_image', $url);
    }
  }
}

function template_settings_page()
{ ?>
  <style type="text/css">
    .pvr-settings-group {
      margin: 0 0 20px;
      padding: 0 30% 0 0;
    }

    .pvr-settings-group input,
    .pvr-settings-group textarea {
      width: 100%;
      box-sizing: border-box;
    }

    @media (max-width: 1439.98px) {
      .pvr-settings-group {
        padding: 0 20% 0 0;
      }
    }

    @media (max-width: 1199.98px) {
      .pvr-settings-group {
        padding: 0 10% 0 0;
      }
    }

    @media (max-width: 991.98px) {
      .pvr-settings-group {
        padding: 0;
      }
    }
  </style>

  <div class="wrap">
    <h2>Template options</h2>

    <form method="post" action="options.php" enctype="multipart/form-data">
      <?php settings_fields('cur-tmpl-settings-group'); ?>
      <?php do_settings_sections('cur-tmpl-settings-group'); ?>

      <div class="pvr-settings-group">
        <div class="postbox">
          <div class="inside">
            <strong>EMAIL SETTINGS</strong>
          </div>

          <div class="inside">
            <div>
              <label for="email"><strong>Email:</strong></label>
            </div>

            <div>
              <input id="email" type="email" name="email" maxlength="128" value="<?php echo get_option('email'); ?>" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="email_to"><strong>Email to:</strong></label>
            </div>

            <div>
              <input id="email_to" type="email" name="email_to" maxlength="128" value="<?php echo get_option('email_to'); ?>" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="email_info"><strong>Email (info):</strong></label>
            </div>

            <div>
              <input id="email_info" type="email" name="email_info" maxlength="128" value="<?php echo get_option('email_info'); ?>" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="email_debug"><strong>Email (for debug):</strong></label>
            </div>

            <div>
              <input id="email_debug" type="email" name="email_debug" maxlength="128" value="<?php echo get_option('email_debug'); ?>" />
            </div>
          </div>
        </div>
      </div>

      <div class="pvr-settings-group">
        <div class="postbox">
          <div class="inside">
            <strong>CONTACT SETTINGS</strong>
          </div>

          <div class="inside">
            <div>
              <label for="phone"><strong>Phone:</strong></label>
            </div>

            <div>
              <input id="phone" type="text" name="phone" maxlength="128" value="<?php echo get_option('phone'); ?>" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="fax"><strong>Fax:</strong></label>
            </div>

            <div>
              <input id="fax" type="text" name="fax" maxlength="128" value="<?php echo get_option('fax'); ?>" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="address"><strong>Address:</strong></label>
            </div>

            <div>
              <textarea id="address" name="address" cols="128" rows="3" maxlength="2048"><?php echo get_option('address'); ?></textarea>
            </div>
          </div>
        </div>
      </div>

      <div class="pvr-settings-group">
        <div class="postbox">
          <div class="inside">
            <strong>MARKUP SETTINGS</strong>
          </div>

          <div class="inside">
            <div>
              <strong>Logo image:</strong>
            </div>

            <div>
              <input name="main_logo_image" type="file" /><br />
              <?php if (!empty(get_option('main_logo_image'))) { ?>
                <img src="<?php echo get_site_url() . get_option('main_logo_image'); ?>" style="height: 80px" /><br />
                <button id="remove_main_logo_image">Remove image</button>
                <script>
                  jQuery(function($) {
                    $('#remove_main_logo_image').on('click', function() {
                      $.ajax({
                        type: 'POST',
                        url: pvrAjax.url,
                        data: {
                          action: 'remove_main_logo_image',
                          nonce_code: pvrAjax.nonce,
                          main_logo_image: '<?php echo get_option('main_logo_image'); ?>'
                        },
                        dataType: 'json',
                        success: function() {
                          document.location.reload(true);
                        }
                      });

                      return false;
                    });
                  });
                </script>
              <?php } ?>
            </div>
          </div>

          <div class="inside">
            <div>
              <strong>Footer logo image:</strong>
            </div>

            <div>
              <input name="footer_logo_image" type="file" /><br />
              <?php if (!empty(get_option('footer_logo_image'))) { ?>
                <img src="<?php echo get_site_url() . get_option('footer_logo_image'); ?>" style="height: 80px" /><br />
                <button id="remove_footer_logo_image">Remove image</button>
                <script>
                  jQuery(function($) {
                    $('#remove_footer_logo_image').on('click', function() {
                      $.ajax({
                        type: 'POST',
                        url: pvrAjax.url,
                        data: {
                          action: 'remove_footer_logo_image',
                          nonce_code: pvrAjax.nonce,
                          footer_logo_image: '<?php echo get_option('footer_logo_image'); ?>'
                        },
                        dataType: 'json',
                        success: function() {
                          document.location.reload(true);
                        }
                      });

                      return false;
                    });
                  });
                </script>
              <?php } ?>
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="footer_descr"><strong>Footer description:</strong></label>
            </div>

            <div>
              <textarea id="footer_descr" name="footer_descr" cols="128" rows="3" maxlength="4096"><?php echo get_option('footer_descr'); ?></textarea>
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="cookie_modal_text"><strong>Cookie policy modal text:</strong></label>
            </div>

            <div>
              <textarea id="cookie_modal_text" name="cookie_modal_text" cols="128" rows="3" maxlength="4096"><?php echo get_option('cookie_modal_text'); ?></textarea>
            </div>
          </div>
        </div>
      </div>

      <div class="pvr-settings-group">
        <div class="postbox">
          <div class="inside">
            <strong>SOCIAL SETTINGS</strong>
          </div>

          <div class="inside">
            <div>
              <label for="fb_link"><strong>Facebook link:</strong></label>
            </div>

            <div>
              <input id="fb_link" type="text" name="fb_link" value="<?php echo get_option('fb_link'); ?>" size="128" maxlength="128" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="ig_link"><strong>Instagram link:</strong></label>
            </div>

            <div>
              <input id="ig_link" type="text" name="ig_link" value="<?php echo get_option('ig_link'); ?>" size="128" maxlength="128" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="twitter_link"><strong>Twitter link:</strong></label>
            </div>

            <div>
              <input id="twitter_link" type="text" name="twitter_link" value="<?php echo get_option('twitter_link'); ?>" size="128" maxlength="128" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="linkedin_link"><strong>LinkedIn link:</strong></label>
            </div>

            <div>
              <input id="linkedin_link" type="text" name="linkedin_link" value="<?php echo get_option('linkedin_link'); ?>" size="128" maxlength="128" />
            </div>
          </div>
        </div>
      </div>

      <div class="pvr-settings-group">
        <div class="postbox">
          <div class="inside">
            <strong>OPEN GRAPH SETTINGS</strong>
          </div>

          <div class="inside">
            <div>
              <label for="og_url"><strong>OG url:</strong></label>
            </div>

            <div>
              <input id="og_url" type="text" name="og_url" value="<?php echo get_option('og_url'); ?>" size="128" maxlength="128" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="og_type"><strong>OG type:</strong></label>
            </div>

            <div>
              <input id="og_type" type="text" name="og_type" value="<?php echo get_option('og_type'); ?>" size="128" maxlength="128" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="og_title"><strong>OG title:</strong></label>
            </div>

            <div>
              <input id="og_title" type="text" name="og_title" value="<?php echo get_option('og_title'); ?>" size="128" maxlength="128" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="og_descr"><strong>OG description:</strong></label>
            </div>

            <div>
              <textarea id="og_descr" name="og_descr" cols="128" rows="3" maxlength="300"><?php echo get_option('og_descr'); ?></textarea>
            </div>
          </div>

          <div class="inside">
            <div>
              <strong>OG image:</strong>
            </div>

            <div>
              <input name="og_image" type="file" /><br />
              <?php if (!empty(get_option('og_image'))) { ?>
                <img src="<?php echo get_site_url() . get_option('og_image'); ?>" style="height: 80px" /><br />
                <button id="remove_og_image">Remove image</button>
                <script>
                  jQuery(function($) {
                    $('#remove_og_image').on('click', function() {
                      $.ajax({
                        type: 'POST',
                        url: pvrAjax.url,
                        data: {
                          action: 'remove_og_image',
                          nonce_code: pvrAjax.nonce,
                          og_image: '<?php echo get_option('og_image'); ?>'
                        },
                        dataType: 'json',
                        success: function() {
                          document.location.reload(true);
                        }
                      });

                      return false;
                    });
                  });
                </script>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <div class="pvr-settings-group">
        <div class="postbox">
          <div class="inside">
            <strong>GOOGLE RECAPTCHA SETTINGS</strong>
          </div>

          <div class="inside">
            <div>
              <label for="recaptcha_public"><strong>Public key:</strong></label>
            </div>
            <div>
              <input id="recaptcha_public" type="text" name="recaptcha_public" maxlength="128" value="<?php echo get_option('recaptcha_public'); ?>" />
            </div>
          </div>

          <div class="inside">
            <div>
              <label for="recaptcha_secret"><strong>Secret key:</strong></label>
            </div>
            <div>
              <input id="recaptcha_secret" type="text" name="recaptcha_secret" maxlength="128" value="<?php echo get_option('recaptcha_secret'); ?>" />
            </div>
          </div>
        </div>
      </div>

      <?php submit_button(); ?>
    </form>
  </div>
<?php
}
