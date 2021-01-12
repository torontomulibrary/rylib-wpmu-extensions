<?php
defined( 'ABSPATH' ) OR exit;
/*
 * Plugin Name: Ryerson University Library WordPress Multisite Extensions
 * Plugin URI: https://github.com/ryersonlibrary/rylib-wpmu-extensions
 * Author: Ryerson University Library
 * Author URI: https://github.com/ryersonlibrary
 * Description: Extra functionality for WordPress Multisite for the Ryerson University Library WordPress site.
 * GitHub Plugin URI: https://github.com/ryersonlibrary/rylib-wpmu-extensions
 * Version: 0.0.3-alpha
 */

// Adds custom columns to Sites list in Network Options
function rylib_wpmu_blogs_columns($sites_columns)
{
  $sites_columns = $sites_columns + array( 
    'blog_id' => 'Site ID',
    'template' => 'Active Theme' 
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

  if ( $column_name == 'template' ) {
    $template_directory = get_blog_option( $blog_id, 'template' );
    $theme = wp_get_theme( $template_directory );
    echo "{$theme->Name} ({$template_directory})";
  }
}
add_action( 'manage_sites_custom_column', 'rylib_wpmu_manage_sites_custom_column', 10, 2 );
