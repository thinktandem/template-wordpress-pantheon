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
  // Register and Enqueue our styles.
  wp_register_style( 'kesha-styles', get_template_directory_uri() . '/dist/style.css', array(), rand(111,9999), 'all' );
  wp_enqueue_style( 'kesha-styles' );

  // Register and Enqueue JS.
  wp_register_script( 'kesha-scripts', get_template_directory_uri() . '/dist/app.js', array( 'jquery' ), rand(111,9999), TRUE );
  wp_enqueue_script( 'kesha-scripts' );
}
add_action( 'wp_enqueue_scripts', 'kesha_theme_scripts' );
