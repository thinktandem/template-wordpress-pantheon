<?php
/**
 * Plugin Name: Pantheon Extra
 * Plugin URI: https://pantheon.io/
 * Description: Extra MU Plugins to use with Pantheon.
 * Version: 0.1
 * Author: Pantheon
 * Author URI: https://pantheon.io/
 *
 * @package pantheon-extra
 */

if ( isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) {
	require_once( 'pantheon-advanced-page-cache/pantheon-advanced-page-cache.php' );
	require_once( 'wp-native-php-sessions/pantheon-sessions.php' );
} 
