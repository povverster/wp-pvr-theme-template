<?php
/*
 * File: breadcrumbs.php
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 11:25:43 am
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

if (!function_exists('get_breadcrumbs')) {
  function get_breadcrumbs()
  {
    /* === Options === */
    $text['home']     = 'Home'; // Home page text
    $text['category'] = '%s'; // Category page text
    $text['search']   = 'Request results "%s"'; // Search result page text
    $text['tag']      = 'Posts with tag "%s"'; // Tag page text
    $text['author']   = 'Articles author %s'; // Author's page text
    $text['404']      = 'Error 404'; // Page 404 text
    $text['page']     = 'Page %s'; // text 'Page N'
    $text['cpage']    = 'Comments page %s'; // text 'Page comments N'

    $wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // wrap open tag
    $wrap_after     = '</div><!-- .breadcrumbs -->'; // wrap closed tag
    $sep            = '<span class="breadcrumbs__separator"> / </span>'; // seoarator between "crumbs"
    $before         = '<span class="breadcrumbs__current color_dark">'; // tag before current "crumb"
    $after          = '</span>'; // tag after current "crumb"

    $show_on_home   = 0; // 1 - show breadcrumbs on home page , 0 - do not show
    $show_home_link = 1; // 1 - show link "Hoe", 0 - do not show
    $show_current   = 1; // 1 - show a name of the current page, 0 - do not show
    $show_last_sep  = 1; // 1 - show last separator, when a name of the current page has not shown, 0 - do not show
    /* === The end of options === */

    global $post;
    $home_url       = home_url('/');
    $link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
    $link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
    $link          .= '<meta itemprop="position" content="%3$s" />';
    $link          .= '</span>';
    $parent_id      = ($post) ? $post->post_parent : '';
    $home_link      = sprintf($link, $home_url, $text['home'], 1);

    if (is_home() || is_front_page()) {

      if ($show_on_home) echo $wrap_before . $home_link . $wrap_after;
    } else {

      $position = 0;

      echo $wrap_before;

      if ($show_home_link) {
        $position += 1;
        echo $home_link;
      }

      if (is_category()) {
        $parents = get_ancestors(get_query_var('cat'), 'category');
        foreach (array_reverse($parents) as $cat) {
          $position += 1;
          if ($position > 1) echo $sep;
          echo sprintf($link, get_category_link($cat), get_cat_name($cat), $position);
        }
        if (get_query_var('paged')) {
          $position += 1;
          $cat = get_query_var('cat');
          echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat), $position);
          echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
        } else {
          if ($show_current) {
            if ($position >= 1) echo $sep;
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
          } elseif ($show_last_sep) echo $sep;
        }
      } elseif (is_search()) {
        if (get_query_var('paged')) {
          $position += 1;
          if ($show_home_link) echo $sep;
          echo sprintf($link, $home_url . '?s=' . get_search_query(), sprintf($text['search'], get_search_query()), $position);
          echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
        } else {
          if ($show_current) {
            if ($position >= 1) echo $sep;
            echo $before . sprintf($text['search'], get_search_query()) . $after;
          } elseif ($show_last_sep) echo $sep;
        }
      } elseif (is_year()) {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . get_the_time('Y') . $after;
        elseif ($show_home_link && $show_last_sep) echo $sep;
      } elseif (is_month()) {
        if ($show_home_link) echo $sep;
        $position += 1;
        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'), $position);
        if ($show_current) echo $sep . $before . get_the_time('F') . $after;
        elseif ($show_last_sep) echo $sep;
      } elseif (is_day()) {
        if ($show_home_link) echo $sep;
        $position += 1;
        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'), $position) . $sep;
        $position += 1;
        echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'), $position);
        if ($show_current) echo $sep . $before . get_the_time('d') . $after;
        elseif ($show_last_sep) echo $sep;
      } elseif (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
          $position += 1;
          $post_type = get_post_type_object(get_post_type());
          if ($position > 1) echo $sep;
          echo sprintf($link, get_post_type_archive_link($post_type->name), $post_type->labels->name, $position);
          if ($show_current) echo $sep . $before . shrink_text(get_the_title(), 64) . $after;
          elseif ($show_last_sep) echo $sep;
        } else {
          $cat = get_the_category();
          $catID = $cat[0]->cat_ID;
          $parents = get_ancestors($catID, 'category');
          $parents = array_reverse($parents);
          $parents[] = $catID;
          foreach ($parents as $cat) {
            $position += 1;
            if ($position > 1) echo $sep;
            echo sprintf($link, get_category_link($cat), get_cat_name($cat), $position);
          }
          if (get_query_var('cpage')) {
            $position += 1;
            echo $sep . sprintf($link, get_permalink(), get_the_title(), $position);
            echo $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
          } else {
            if ($show_current) echo $sep . $before . get_the_title() . $after;
            elseif ($show_last_sep) echo $sep;
          }
        }
      } elseif (is_post_type_archive()) {
        $cur_post = get_queried_object();
        if (get_query_var('paged')) {
          $position += 1;
          if ($position > 1) echo $sep;
          echo sprintf($link, get_post_type_archive_link($cur_post->name), $cur_post->label, $position);
          echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
        } else {
          if ($show_home_link && $show_current) echo $sep;
          if ($show_current) echo $before . $cur_post->label . $after;
          elseif ($show_home_link && $show_last_sep) echo $sep;
        }
      } elseif (is_attachment()) {
        $parent = get_post($parent_id);
        $cat = get_the_category($parent->ID);
        $catID = $cat[0]->cat_ID;
        $parents = get_ancestors($catID, 'category');
        $parents = array_reverse($parents);
        $parents[] = $catID;
        foreach ($parents as $cat) {
          $position += 1;
          if ($position > 1) echo $sep;
          echo sprintf($link, get_category_link($cat), get_cat_name($cat), $position);
        }
        $position += 1;
        echo $sep . sprintf($link, get_permalink($parent), $parent->post_title, $position);
        if ($show_current) echo $sep . $before . get_the_title() . $after;
        elseif ($show_last_sep) echo $sep;
      } elseif (is_page() && !$parent_id) {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . get_the_title() . $after;
        elseif ($show_home_link && $show_last_sep) echo $sep;
      } elseif (is_page() && $parent_id) {
        $parents = get_post_ancestors(get_the_ID());
        foreach (array_reverse($parents) as $pageID) {
          $position += 1;
          if ($position > 1) echo $sep;
          echo sprintf($link, get_page_link($pageID), get_the_title($pageID), $position);
        }
        if ($show_current) echo $sep . $before . get_the_title() . $after;
        elseif ($show_last_sep) echo $sep;
      } elseif (is_tag()) {
        if (get_query_var('paged')) {
          $position += 1;
          $tagID = get_query_var('tag_id');
          echo $sep . sprintf($link, get_tag_link($tagID), single_tag_title('', false), $position);
          echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
        } else {
          if ($show_home_link && $show_current) echo $sep;
          if ($show_current) echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
          elseif ($show_home_link && $show_last_sep) echo $sep;
        }
      } elseif (is_author()) {
        $author = get_userdata(get_query_var('author'));
        if (get_query_var('paged')) {
          $position += 1;
          echo $sep . sprintf($link, get_author_posts_url($author->ID), sprintf($text['author'], $author->display_name), $position);
          echo $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
        } else {
          if ($show_home_link && $show_current) echo $sep;
          if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
          elseif ($show_home_link && $show_last_sep) echo $sep;
        }
      } elseif (is_404()) {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . $text['404'] . $after;
        elseif ($show_last_sep) echo $sep;
      } elseif (has_post_format() && !is_singular()) {
        if ($show_home_link && $show_current) echo $sep;
        echo get_post_format_string(get_post_format());
      }

      echo $wrap_after;
    }
  }
}
