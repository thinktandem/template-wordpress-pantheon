<?php

/**
 * Use the file to alter items in a plugin like annoying notices, etc.
 */

/**
 * Removes popups not covered in our mu plugin.
 */
function remove_popups() {
  /**
   * Some popups are namepsaced classes, so it makes it hard to remove_action properly.
   * This way we can just add the meta data to stop it for good.
   */
  $user_id = get_current_user_id();

  // Remove Content Control Messages.
  if (class_exists('JP\CC\Admin\Reviews')) {
    update_user_meta( $user_id, '_jp_cc_reviews_dismissed_triggers', ['time_installed' => 10] );
    update_user_meta( $user_id, '_jp_cc_reviews_already_did', true );
  }

  // Remove User Menu Messages.
  if (class_exists('JP\UM\Admin\Reviews')) {
    update_user_meta( $user_id, '_jpum_reviews_dismissed_triggers', ['time_installed' => 10] );
    update_user_meta( $user_id, '_jpum_reviews_already_did', true );
  }

  // Removes the member filter popup.
  remove_filter( 'members_admin_pointers', 'members_3_helper_pointer' );
}
add_action( 'init', 'remove_popups' );

/**
 * Disables plugin updates for specific plugins.
 */
function disable_specific_plugin_updates($value) {
  /**
   * if you want to stop a check, then unset the response:
   * ie: unset($value->response['gravityformsstripe/stripe.php']);
   */
  return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_specific_plugin_updates', 15 );
