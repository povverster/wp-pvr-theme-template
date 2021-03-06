<?php
/*
 * File: helpers.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:42:50 am
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Monday, 22nd June 2020 10:54:16 am
 * Modified By: povverster (povverster@gmail.com>)
 */

declare(strict_types=1);

if (!function_exists('xmp')) {
  function xmp(...$data)
  {
    echo '<xmp>';
    var_dump(...$data);
    echo '</xmp>';
  }
}

if (!function_exists('rm_rec')) {
  function rm_rec(string $path)
  {
    if (is_file($path)) {
      return unlink($path);
    }

    if (is_dir($path)) {
      foreach (scandir($path) as $p) {
        if (($p != '.') && ($p != '..')) {
          rm_rec($path . '/' . $p);
        }
      }
      return rmdir($path);
    }

    return false;
  }
}

if (!function_exists('get_dir_files')) {
  function get_dir_files(string $path)
  {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

    $files = array();
    foreach ($rii as $file) {
      if (!$file->isDir()) {
        $files[] = $file->getPathname();
      }
    }

    return $files;
  }
}

if (!function_exists('array_key_first')) {
  function array_key_first(array $arr)
  {
    foreach ($arr as $key => $unused) {
      return $key;
    }
    return NULL;
  }
}

if (!function_exists('remove_empty_subdirs')) {
  function remove_empty_subdirs(string $path, string $root = null)
  {
    $is_removed = false;

    $root = empty($root) ? $path : $root;

    if (is_dir($path)) {
      $counter = 0;
      foreach (scandir($path) as $p) {
        if (($p !== '.') && ($p !== '..')) {
          $counter++;
          if (remove_empty_subdirs(rtrim($path, '/') . '/' . $p, $root)) {
            $is_removed = true;
          }
        }
      }

      if ($counter === 0 && $path !== $root) {
        return rmdir($path);
      }
    }

    return $is_removed;
  }
}

if (!function_exists('shrink_text')) {
  function shrink_text(string $text, int $limit): string
  {
    if (!is_string($text)) {
      return '';
    }

    $text = trim($text);
    if (empty($text) || mb_strlen($text) < 1) {
      return '';
    }

    if (empty($limit) || !is_numeric($limit) || $limit < 1) {
      return '';
    }

    if ($limit >= mb_strlen($text)) {
      return $text;
    }

    $res = '';
    $counter = 0;
    $words = explode(' ', $text);
    $word_counter = count($words);

    if ($limit < mb_strlen($text) && $word_counter === 1) {
      return (mb_substr($text, 0, $limit - 3) . '...');
    }

    foreach ($words as $word) {

      $counter += mb_strlen($word) + 1;
      if ($counter > $limit) {
        break;
      }
      $res .= $word . ' ';
    }

    $res .= '...';

    return $res;
  }
}

if (!function_exists('get_all_cookies')) {
  function get_all_cookies(bool $xss = false)
  {
    if (empty($_COOKIE) || !is_array($_COOKIE)) {
      return [];
    }

    global $SEC;
    $security = &$SEC;

    $res = [];
    $cookies = $_COOKIE;

    foreach ($cookies as $key => $value) {
      $res[$key] = ($xss) ? $security->xss_clean($value) : $value;
    }

    return $res;
  }
}

if (!function_exists('download_file')) {
  function download_file(string $url, string $path)
  {
    $newfname = $path;
    $newf = null;

    $file = fopen($url, 'rb');

    if ($file) {
      $newf = fopen($newfname, 'wb');
      if ($newf) {
        while (!feof($file)) {
          fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
        }

        fclose($newf);
        fclose($file);

        return true;
      }

      fclose($file);
    }

    return false;
  }
}

if (!function_exists('clean_value_for_csv')) {
  function clean_value_for_csv(string $value): string
  {
    if (preg_match('/^[\/]{1}wp-content[\/]{1}uploads[\/]{1}form_data[\/]{1}/i', $value)) {
      $value = SITE_URL . $value;
    }

    return preg_replace('/[,;\n\t\r]+/', ' ', $value);
  }
}

if (!function_exists('show_error')) {
  function show_error($str)
  {
    echo $str;
    die();
  }
}

if (!function_exists('is_index')) {
  function is_index($val): bool
  {
    return !empty($val) && is_numeric($val) && preg_match('/^[\d]+$/', "$val");
  }
}

if (!function_exists('random_str')) {
  function random_str(
    int $length,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
  ): string {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;

    if ($max < 1) {
      throw new Exception('$keyspace must be at least two characters long');
    }

    for ($i = 0; $i < $length; ++$i) {
      $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
  }
}

if (!function_exists('mb_string_to_array')) {
  function mb_string_to_array(string $string, string $charset = 'UTF-8'): array
  {
    $strlen = mb_strlen($string);

    $array = [];

    while ($strlen) {
      $array[] = mb_substr($string, 0, 1, $charset);
      $string = mb_substr($string, 1, $strlen, $charset);
      $strlen = mb_strlen($string);
    }

    return $array;
  }
}

if (!function_exists('get_current_page_url')) {
  function get_current_page_url(): string
  {
    $is_ssl = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    return ($is_ssl ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  }
}

if (!function_exists('header200')) {
  function header200()
  {
    header('HTTP/1.1 200 OK');
  }
}

if (!function_exists('header400')) {
  function header400()
  {
    header('HTTP/1.1 400 Bad Request');
  }
}

if (!function_exists('header403')) {
  function header403()
  {
    header('HTTP/1.1 403 Forbidden');
  }
}

if (!function_exists('header404')) {
  function header404()
  {
    header('HTTP/1.1 404 Not Found');
  }
}

if (!function_exists('header_json')) {
  function header_json()
  {
    header('Content-Type: application/json');
  }
}
