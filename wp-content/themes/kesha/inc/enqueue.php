<?php

/**
 * Styles and Scripts for this theme.
 *
 * @package kesha
 */

/**
 * Load CSS / JS into theme.
 */
function kesha_theme_scripts() {

  // Register Custom CSS
  wp_register_style( 'theme', get_template_directory_uri() . '/dist/css/built.min.css', array(), rand(111,9999), 'all' );

  // Enqueue Styles
  wp_enqueue_style( 'theme' );

  // Register JS.
  wp_register_script( 'scripts', get_template_directory_uri() . '/dist/js/built.min.js', array( 'jquery' ), rand(111,9999), TRUE );

  // Enqueue JS
  wp_enqueue_script( 'scripts' );
}
add_action( 'wp_enqueue_scripts', 'kesha_theme_scripts');
