<?php
add_action('admin_menu', 'tmu_wpmu_menu');

function tmu_wpmu_menu() {
  if (tmu_wpmu_is_admin()) {
    add_options_page(
      'TMU WPMU Settings', // Page title
      'TMU WPMU',          // Menu title
      'manage_options',     // Capability
      'tmu-wpmu-settings', // Menu slug
      'tmu_wpmu_settings_page' // Callback function
    );
  }
}

function tmu_wpmu_settings_page() {
  ?>
  <div class="wrap">
      <h1>TMU WPMU Settings</h1>
      <form method="post" action="options.php">
          <?php
          settings_fields('tmu_wpmu_options_group');
          do_settings_sections('tmu-wpmu-settings');
          submit_button();
          ?>
      </form>
  </div>
  <?php
}

add_action('admin_init', 'tmu_wpmu_settings_init');

function tmu_wpmu_settings_init() {
  if (tmu_wpmu_is_admin()) {
    // Register a new setting for "tmu_wpmu_options_group"
    register_setting('tmu_wpmu_options_group', 'tmu_wpmu_options');

    // Add a new section to "tmu_wpmu_settings"
    add_settings_section(
        'tmu_wpmu_login_page_settings_section',
        'Login Page Customizations',
        'tmu_wpmu_login_page_settings_section_callback',
        'tmu-wpmu-settings'
    );

    // Add a new field to the "tmu_wpmu_login_page_settings_section"
    add_settings_field(
        'tmu_wpmu_forgot_password_redirect_url',
        'Forgot Password Redirect URL',
        'tmu_wpmu_forgot_password_redirect_url_callback',
        'tmu-wpmu-settings',
        'tmu_wpmu_login_page_settings_section'
    );
  }
}

function tmu_wpmu_login_page_settings_section_callback() {
    // echo '<p>Settings for My Plugin.</p>';
}

function tmu_wpmu_forgot_password_redirect_url_callback() {
    $options = get_option('tmu_wpmu_options');
    ?>
    <input type="text" name="tmu_wpmu_options[tmu_wpmu_forgot_password_redirect_url]" value="<?php echo isset($options['tmu_wpmu_forgot_password_redirect_url']) ? esc_attr($options['tmu_wpmu_forgot_password_redirect_url']) : ''; ?>">
    <?php
}
