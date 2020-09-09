<?php
/**
 * Kesha functions and definitions
 *
 * @package kesha
 */

/**
 * Instatiate Timber.
 */
$timber = new \Timber\Timber();

/**
 * Sets twig directory to templates.
 * With a fallback to the default views.
 */
Timber::$dirname = array('templates', 'views');

/**
 * Our theme setup options.
 */
if (!function_exists('theme_setup')) {
  function theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-formats' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption'] );
    add_theme_support( 'customize-selective-refresh-widgets' );

    // @todo add any image sizes with add_image_size() in this function.
  }
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Adds additional items to the Timber Context.
 */
function add_to_context( $context ) {
  $context['left_menu'] = new Timber\Menu(16);
  $context['right_menu'] = new Timber\Menu(17);
  $context['site'] = new Timber\Site("Kesha");
  return $context;
}
add_filter( 'timber_context', 'add_to_context' );

// All our inc files in this directory.
foreach (glob(get_template_directory() . '/inc/*.php') as $filename) {
  include_once $filename;
}
