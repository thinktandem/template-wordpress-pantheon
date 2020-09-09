<?php

/**
 * Additional helper functions used with ACF.
 *
 * @package kesha
 */


/**
 * Renders all fields for a group via the current post.
 *
 * @param int $group_id
 *   The ACF group id / name.
 * @param null|/WP_Post $post
*    The current post if used outside of the loop
 *
 * @return array
 *    The rendered field with label and value.
 */
function render_fields_by_group($group_id, $post = NULL) {
  if ($post === NULL) {
    global $post;
  }

  $final_fields = [];

  // Loop through and render all the fields for this group.
  $fields = acf_get_fields( $group_id );
  foreach ($fields as $field) {
    $field_value = get_field( $field['name'], $post->ID );
    if ($field_value && !empty($field_value)) {
      $final_fields[$field['name']] = [
        'label' => $field['label'],
        'value' => $field_value,
      ];
    }
  }

  return $final_fields;
}
