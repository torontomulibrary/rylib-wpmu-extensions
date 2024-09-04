<?php
// Add the menu item to the network admin menu
function tmu_wpmu_custom_menu() {
    add_menu_page(
        'TMU WPMU Settings', // Page title
        'TMU WPMU',    // Menu title
        'manage_network',         // Capability required to access this menu
        'tmu-wpmu-menu', // Menu slug
        'tmu_wpmu_menu_page', // Function to display the menu page content
        'dashicons-admin-generic' // Icon URL (optional)
    );
}
add_action('network_admin_menu', 'tmu_wpmu_custom_menu');

// Display the menu page content
function tmu_wpmu_menu_page() {
    // Check if the user is allowed to update options
    if (!current_user_can('manage_network')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Handle form submission
    if (isset($_POST['tmu_wpmu_menu_submit'])) {
        check_admin_referer('tmu_wpmu_menu_nonce');
        
        // Get the submitted value and sanitize it
        $tmu_wpmu_forgot_password_redirect = sanitize_text_field($_POST['tmu_wpmu_forgot_password_redirect']);
        
        // Save the value to the network settings
        update_site_option('tmu_wpmu_forgot_password_redirect', $tmu_wpmu_forgot_password_redirect);
        
        // Display success message
        echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>';
    }

    // Retrieve the current setting value
    $current_value = get_site_option('tmu_wpmu_forgot_password_redirect', '');

    // Display the settings form
    ?>
    <div class="wrap">
        <h1>TMU WPMU Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('tmu_wpmu_menu_nonce'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="tmu_wpmu_forgot_password_redirect">Forgot Password Redirect</label></th>
                    <td><input type="text" id="tmu_wpmu_forgot_password_redirect" name="tmu_wpmu_forgot_password_redirect" value="<?php echo esc_attr($current_value); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button('Save Changes', 'primary', 'tmu_wpmu_menu_submit'); ?>
        </form>
    </div>
    <?php
}
?>
