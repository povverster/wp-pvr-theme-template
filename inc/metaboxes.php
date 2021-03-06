<?php
/*
 * File: metaboxes.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:34:13 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Friday, 5th June 2020 11:04:06 am
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
  exit;
}

add_action('admin_menu', function () {
  $post_id = !empty($_GET['post']) && is_index($_GET['post']) ? $_GET['post'] : null;

  if (empty($post_id)) {
    return false;
  }

  $post = get_post($post_id);
  $post_type = $post->post_type ?? '';
  $post_name = $post->post_name ?? '';

  add_meta_box('page_options', 'Page options', 'page_options', ['page'], 'normal', 'high');
  add_meta_box('page_gallery_options', 'Page gallery options', 'page_gallery_options', ['cp_page_gallery'], 'normal', 'high');
});

function page_options($post)
{
  wp_nonce_field(basename(__FILE__), 'options_metabox_nonce');
}

function page_gallery_options($post)
{
  wp_nonce_field(basename(__FILE__), 'options_metabox_nonce');

  $cp_page_gallery_slug = get_post_meta($post->ID, 'cp_page_gallery_slug', true);
?>

  <div class="inside">
    <div>
      <label for="cp_page_gallery_slug"><strong>Gallery slug:</strong></label>
    </div>

    <div>
      <input id="cp_page_gallery_slug" type="text" name="cp_page_gallery_slug" style="width: 100%;" maxlength="128" value="<?php echo $cp_page_gallery_slug; ?>" />
    </div>
  </div>

<?php
}

add_action('save_post', function ($post_id) {
  if (
    !isset($_POST['options_metabox_nonce'])
    || !wp_verify_nonce($_POST['options_metabox_nonce'], basename(__FILE__))
  ) {
    return $post_id;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  if (!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }

  $post = get_post($post_id);
  $post_type = $post->post_type ?? '';
  $post_name = $post->post_name ?? '';

  if ($post_type === 'cp_page_gallery') {
    $cp_page_gallery_slug = $_POST['cp_page_gallery_slug'] ?? '';
    update_post_meta($post_id, 'cp_page_gallery_slug', sanitize_text_field($cp_page_gallery_slug));
  }

  return $post_id;
});
