<?php

/**
 * Plugin Name: Pedidos Online
 * Description: This plugin allows you to connect to the service of  Pedidos Online.
 * Version: 1
 * Author: Webilop
 * Author URI: http://www.webilop.com/
 * License: GPL2
 */
class pedidosOnline {

  public function pedidosOnline() {
    add_action('admin_menu', array($this, 'add_plugin_page'));
    add_action('admin_init', array($this, 'page_init'));
  }

  // Add options page
  public function add_plugin_page() {
    // This page will be under "Settings"
    add_options_page(
            'Settings Admin', 'Pedidos Online', 'manage_options', 'pedidosOnline-my-setting-admin', array($this, 'create_admin_page')
    );
  }

  // Options page callback
  public function create_admin_page() {
    $this->options = get_option('pediodosOnline_option_name');
    ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h2>Pedidos Online</h2>
      <form method="post" action="options.php">
        <?php
        settings_fields('pediodosOnline_option_group');
        do_settings_sections('pedidosOnline-my-setting-admin');
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  /**
   * Register and add settings
   */
  public function page_init() {
    register_setting(
            'pediodosOnline_option_group', // Option group
            'pediodosOnline_option_name', // Option name
            array($this, 'sanitize') // Sanitize
    );

    add_settings_section(
            'pediodosOnline_admin', // ID
            '', // Title
            array(), // Callback
            'pedidosOnline-my-setting-admin' // Page
    );

    add_settings_field(
            'username', // ID
            'Username', // Title
            array($this, 'username_callback'), // Callback
            'pedidosOnline-my-setting-admin', // Page
            'pediodosOnline_admin' // Section
    );

    add_settings_field(
            'password', 'Password', array($this, 'password_callback'), 'pedidosOnline-my-setting-admin', 'pediodosOnline_admin'
    );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function sanitize($input) {

    $new_input = array();
    if (!empty($input['username']))
      $new_input['username'] = sanitize_text_field($input['username']);

    if (!empty($input['password']))
      $new_input['password'] = sanitize_text_field($input['password']);

    return $new_input;
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function username_callback() {
    printf(
            '<input type="text" id="username" name="pediodosOnline_option_name[username]" value="%s" required/>', isset($this->options['username']) ? esc_attr($this->options['username']) : ''
    );
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function password_callback() {
    printf(
            '<input type="password" id="password" name="pediodosOnline_option_name[password]" value="%s" required/>', isset($this->options['password']) ? $this->options['password'] : ''
    );
  }

}

$obj = new pedidosOnline();
