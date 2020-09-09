<?php

/**
 * Additional SEO & Performance customization for this theme.
 *
 * @package kesha
 */

/**
 * Fixes empty meta descriptions.
 */
function fix_empty_meta_desc($description, $presentation) {
  if (empty($description)) {
    $post = $presentation->source;
    $generic_desc = "Stuff about Kesha";
    $description = $post->post_title . " - " . $generic_desc;
  }
  return $description;
}
add_filter( 'wpseo_metadesc', 'fix_empty_meta_desc', 10, 2 );
add_filter( 'wpseo_opengraph_desc', 'fix_empty_meta_desc', 10, 2 );
add_filter( 'wpseo_twitter_description', 'fix_empty_meta_desc', 10, 2 );

/**
 * Preload JS.
 */
function preload_preconnect_js() {
  global $wp_scripts;

  foreach($wp_scripts->queue as $handle) {
    $script = $wp_scripts->registered[$handle];
    if ($handle === 'jquery') {
      $script->src = get_site_url() . '/wp-includes/js/jquery/jquery.js';
    }

    // If version is set, append to end of source.
    $source = $script->src . ($script->ver ? "?ver={$script->ver}" : "");

    // Our theme js dont need to be fully loaded via preload.
    $type = strpos($script->src, 'kesha') !== FALSE
      ? 'preconnect' : 'preload';

    // Spit out the tag.
    echo "<link rel='" . $type . "' href='{$source}' as='script'/>\n";
  }
}
add_action( 'wp_head', 'preload_preconnect_js', 1 );

/**
 * Defer JS.
 */
function defer_js($url) {
  // Skip JS if logged in and a few other things.
  if (is_user_logged_in()
      || strpos($url, '.js') === FALSE
      || strpos($url, 'jquery.js') !== FALSE
      || strpos($url, 'smush-lazy-load.min.js') !== FALSE) {
    return $url;
  }
  return str_replace(' src', ' defer src', $url);
}
add_filter( 'script_loader_tag', 'defer_js', 100 );

/**
 * Adds resource hints to our theme.
 */
function add_resource_hints($urls, $relation_type) {
  switch ($relation_type) {
    case 'preconnect':
      $preconnects = [
        // @todo add in preconnects as need be.
      ];

      foreach ($preconnects as $preconnect) {
        $urls[] = [
          'href' => $preconnect,
          'crossorigin',
        ];
      }
      break;
    case 'dns-prefetch':
      // Remove site url from dns-prefetch.
      $url = str_replace(['http://', 'https://'], '', get_site_url());
      if (($key = array_search($url, $urls)) !== FALSE) {
        unset($urls[$key]);
      }

      // Constant contact urls that get loaded in the iframe.
      $prefetchs = [
        // @todo add in prefetchs as need be.
      ];
      foreach ($prefetchs as $prefetch) {
        $urls[] = $prefetch;
      }
      break;
  }
  return $urls;
}
add_filter( 'wp_resource_hints', 'add_resource_hints', 10, 2 );
