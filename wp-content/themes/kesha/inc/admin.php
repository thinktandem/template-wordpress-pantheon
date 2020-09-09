<?php

/**
 * Customization to the admin experience.
 *
 * @package kesha
 */

/**
 * Alters our admin menu to allow custom grouping.
 */
function admin_menu_alters() {
  global $submenu;

  // Our content parent menu item.
  add_menu_page(
    'Content',
    'Content',
    'read',
    'content',
    '',
    'dashicons-admin-page',
    4
  );

  // Taxonomy parent menu and children.
  add_menu_page(
    'Taxonomy',
    'Taxonomy',
    'read',
    'taxonomy',
    '',
    'dashicons-tag',
    5
  );
  add_submenu_page('taxonomy', 'Categories', 'Categories', 'edit_posts', 'edit-tags.php?taxonomy=category' );
  add_submenu_page('taxonomy', 'Tags', 'Tags', 'edit_posts', 'edit-tags.php?taxonomy=post_tag' );

  // Removes the first Taxonomy menu item in the sub menu.
  unset($submenu["taxonomy"][0][1]);
}
add_action( 'admin_menu', 'admin_menu_alters' );

/**
 * Filters the types to move them into the content menu.
 *
 * @param $args array
 *   The original CPT args.
 * @param $post_type string
 *   The CPT slug.
 *
 * @return array
 */
function alter_types_menu_location($args, $post_type) {
  $skip = [
    'acf-field',
    'acf-field-group',
    'attachment',
    'custom_css',
    'customize_changeset',
    'elementor_library',
    'media',
    'nav_menu_item',
    'oembed_cache',
    'product',
    'product_variation',
    'revision',
    'scheduled-action',
    'shop_coupon',
    'shop_order',
    'shop_order_refund',
    'user_request',
    'wp_block',
  ];

  // Skip this as we don't want them in our menu.
  if (in_array($post_type, $skip)) {
    return $args;
  }

  // Changes the titles as it will render the secondary all items.
  if (isset($args["labels"]) && is_array($args["labels"])) {
    $name = isset($args["labels"]["name"]) ? $args["labels"]["name"] : $args["labels"]["name_admin_bar"];
    $menu["labels"]["name"] = $name;
  }

  // Change which menu.
  $menu['show_in_menu'] = 'content';

  // Slap it together.
  return array_merge($args, $menu);

}
add_filter( 'register_post_type_args', 'alter_types_menu_location', 10, 2 );

/**
 * Changes the edit/view label on the admin bar per post type.
 */
function admin_bar_change_type_label() {
  global $wp_admin_bar;
  global $post;

  // Removes Options that aren't needed anymore
  $wp_admin_bar->remove_menu('customize');
  $wp_admin_bar->remove_menu('updates');
  $wp_admin_bar->remove_menu('comments');

  // Remove WordPress Menu Items.
  $wp_admin_bar->remove_menu('wp-logo');
  $wp_admin_bar->remove_menu('wp-logo-external');
  $wp_admin_bar->remove_menu('about');
  $wp_admin_bar->remove_menu('wporg');
  $wp_admin_bar->remove_menu('documentation');
  $wp_admin_bar->remove_menu('support-forums');
  $wp_admin_bar->remove_menu('feedback');

  if (!isset($post->post_type)) {
    return;
  }

  $type = str_replace('-', ' ', $post->post_type);
  $change_edit = $wp_admin_bar->get_node('edit');
  $change_view = $wp_admin_bar->get_node('view');
  if ($change_edit !== NULL) {
    $change_edit->title = __('Edit ' . ucwords($type), 'bramble');
    $wp_admin_bar->add_node($change_edit);
  }
  elseif ($change_view !== NULL) {
    $change_view->title = __('View ' . ucwords($type), 'bramble');
    $wp_admin_bar->add_node($change_view);
  }

}
add_action( 'wp_before_admin_bar_render', 'admin_bar_change_type_label' );

/**
 * Moves the Yoast meta to the bottom of the post edit screen.
 */
function yoast_to_bottom() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoast_to_bottom' );

/**
 * Forces the admin bar to show if cache is an issue.
 */
function force_admin_bar_show() {
  add_filter( 'show_admin_bar', '__return_true' );
}
add_action( 'wp_login', 'force_admin_bar_show' );

/**
 * Remove the color option.
 */
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

/**
 * Adds the favicon to the admin side
 */
function favicon_admin() {
  echo '<link rel="shortcut icon" type="image/x-icon" href="/wp-content/themes/kesha/favicon.ico" />';
}
add_action( 'admin_head', 'favicon_admin' );

