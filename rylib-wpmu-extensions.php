<?php
defined( 'ABSPATH' ) OR exit;
/*
 * Plugin Name: TMU Libraries WordPress Multisite Extensions
 * Plugin URI: https://github.com/torontomulibrary/rylib-wpmu-extensions
 * Author: TMU Libraries
 * Author URI: https://github.com/torontomulibrary
 * Description: Extra functionality for WordPress Multisite
 * GitHub Plugin URI: https://github.com/torontomulibrary/rylib-wpmu-extensions
 * Version: 0.0.8-alpha
 */

// include wordpress settings and helpers
include plugin_dir_path(__FILE__) . 'settings.php';
include plugin_dir_path(__FILE__) . 'helpers.php';

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
  $redirect_url = get_site_option('tmu_wpmu_forgot_password_redirect');
  // $redirect_url = "http://localhost:8080";
  // $tmu_wpmu_options = get_option('tmu_wpmu_options');
  // $redirect_url = isset($tmu_wpmu_options['tmu_wpmu_forgot_password_redirect_url']) ? $tmu_wpmu_options['tmu_wpmu_forgot_password_redirect_url'] : '';

  if (isset($redirect_url) && !empty($redirect_url)) {
    // Redirect to custom URL
    if (isset($_GET['action']) && $_GET['action'] === 'lostpassword') {
        wp_redirect($redirect_url);
        exit();
    }
  }
}
add_action( 'login_form_lostpassword', 'rylib_wpmu_lostpassword_url' );

