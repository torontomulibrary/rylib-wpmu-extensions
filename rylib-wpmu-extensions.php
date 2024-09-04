<?php
defined( 'ABSPATH' ) OR exit;
/*
 * Plugin Name: Ryerson University Library WordPress Multisite Extensions
 * Plugin URI: https://github.com/ryersonlibrary/rylib-wpmu-extensions
 * Author: Ryerson University Library
 * Author URI: https://github.com/ryersonlibrary
 * Description: Extra functionality for WordPress Multisite for the Ryerson University Library WordPress site.
 * GitHub Plugin URI: https://github.com/ryersonlibrary/rylib-wpmu-extensions
 * Version: 0.0.6-alpha
 */

// Adds custom columns to Sites list in Network Options
function rylib_wpmu_blogs_columns($sites_columns)
{
  $sites_columns = $sites_columns + array( 
    'blog_id' => 'Site ID',
    'stylesheet' => 'Active Theme',
    'blog_title' => 'Blog Title'
  );
  return $sites_columns;
}
add_filter( 'wpmu_blogs_columns', 'rylib_wpmu_blogs_columns' );

// Hook to manage column data on network sites listing
function rylib_wpmu_manage_sites_custom_column( $column_name, $blog_id )
{
  if ( $column_name == 'blog_id' ) {
    echo "{$blog_id}";
  }

  if ( $column_name == 'stylesheet' ) {
    $stylesheet_directory = get_blog_option( $blog_id, 'stylesheet' );
    $theme = wp_get_theme( $stylesheet_directory );
    echo "{$theme->Name} ({$stylesheet_directory})";
  }

  if ( $column_name == 'blog_title' ) {
    echo get_blog_option( $blog_id, 'blogname' );
  }
}
add_action( 'manage_sites_custom_column', 'rylib_wpmu_manage_sites_custom_column', 10, 2 );

// Suppress Freemius Notifications for non Super-Admin users
add_action('admin_footer', 'rylib_wpmu_admin_theme_style');
function rylib_wpmu_admin_theme_style() {
	if (!current_user_can( 'manage_network' )) {
		echo '<style>div.fs-notice.updated, div.fs-notice.success, div.fs-notice.promotion { display: none!important; }</style>';
	}
}

// Redirect Lost Password page to custom URL
  function rylib_wpmu_lostpassword_url() {
  // Define your custom URL
  $custom_url = 'https://yourwebsite.com/custom-forgot-password/';

  // Redirect to custom URL
  if (isset($_GET['action']) && $_GET['action'] === 'lostpassword') {
      wp_redirect($custom_url);
      exit();
  }
}
add_action( 'login_form_lostpassword', 'rylib_wpmu_lostpassword_url' );
