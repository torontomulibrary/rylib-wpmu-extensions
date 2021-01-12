<?php
defined( 'ABSPATH' ) OR exit;
/*
 * Plugin Name: Ryerson University Library WordPress Multisite Extensions
 * Plugin URI: https://github.com/ryersonlibrary/rylib-wpmu-extensions
 * Author: Ryerson University Library
 * Author URI: https://github.com/ryersonlibrary
 * Description: Extra functionality for WordPress Multisite for the Ryerson University Library WordPress site.
 * GitHub Plugin URI: https://github.com/ryersonlibrary/rylib-wpmu-extensions
 * Version: 0.0.1-alpha
 */

// Adds "Active Theme" column to sites listing
function rylib_wpmu_blogs_columns_active_theme($sites_columns)
{
  $sites_columns = $sites_columns + array( 'template' => 'Active Theme' );
  return $sites_columns;
}
add_filter( 'wpmu_blogs_columns', 'rylib_wpmu_blogs_columns_active_theme' );

// Hook to manage column data on network sites listing
function rylib_wpmu_manage_sites_custom_column_active_theme( $column_name, $blog_id )
{
  if ( $column_name == 'template' ) {
    $template_directory = get_blog_option( $blog_id, 'template' );
    $theme = wp_get_theme( $template_directory );
    echo $theme->Name;
  }
}
add_action( 'manage_sites_custom_column', 'rylib_wpmu_manage_sites_custom_column_active_theme', 10, 2 );
