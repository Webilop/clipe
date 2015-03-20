<?php
/**
 * Plugin Name: Pedidos Online
 * Description: This plugin allows you to connect to the service of  Pedidos Online.
 * Version: 1
 * Author: Webilop
 * Author URI: http://www.webilop.com/
 * License: GPL2
 */
include_once("InterfacePedidos.php");

class pedidosOnline {

  private $interface = null;
  private $publish_pages;
  private $pages = array();
  private $suffixPages = "clipe=";
  private $themeDir = "pedidosonline/";
  private $pluginDir = "templates/pedidosonline/";
  private $cookieName = "wp_clipe";

  public function pedidosOnline() {
    //pages of plugin with respective template.
    $this->pages['1'] = 'index.php'; //index
    $this->pages['2'] = 'recovery_password.php';
    $this->pages['3'] = 'list_clients.php';
    $this->pages['4'] = 'create_client.php';
    add_action('admin_menu', array($this, 'add_plugin_page'));
    add_action('admin_init', array($this, 'page_init'));
    add_filter('template_include', array($this, 'template_function'));
    $this->interface = new InterfacePedidos();
  }

  /*
   * return the lin to a page, page is the name of the template if no exist return false
   */

  public function get_link_page($page) {
    $key = array_search($page, $this->pages);
    if ($key) {
      return site_url() . '?' . $this->suffixPages . $key;
    }
    return false;
  }

  /*
   * search template in the theme, if not exist  get the templates in plugin.
   */

  function search_template($page) {
    if ($theme_file = locate_template(array($this->themeDir . $page))) {
      $template_path = $theme_file;
    } else {
      $template_path = plugin_dir_path(__FILE__) . $this->pluginDir . $page;
    }
    return $template_path;
  }

  /*
   * load the template
   */

  function template_function($template_path) {
    if (isset($_SERVER['QUERY_STRING'])) {
      $page = $_SERVER['QUERY_STRING'];
      foreach ($this->pages as $key => $value) {
        if ($page == $this->suffixPages . $key) {
          $template_path = $this->search_template($this->pages[$key]);
          return $template_path;
        }
      }
    }

    $options = get_option('pediodosonline_option_name');
    if (isset($options['login_page']) && !empty($options['login_page'])) {
      $id = $options['login_page'];
      if (is_page($id)) {
        wp_enqueue_script('login_js', plugins_url('templates/pedidosonline/js/login.js', __FILE__), array('jquery'));
        wp_enqueue_style('login_css', plugins_url('templates/pedidosonline/css/login.css', __FILE__));
        $template_path = $this->search_template('login.php');
      }
    }
    return $template_path;
  }

  // Add options page
  public function add_plugin_page() {
    add_menu_page(__('pedidos online Users', 'pedidos-online'), __('Pedidos Online', 'pedidos-online'), 'manage_options', 'pedidosonline-settings', array($this, 'create_admin_page'), '', 6);
    /* add_submenu_page(
      'pedidosonline-crud-users',__('Settings Admin','pedidos-online'),  __('Settings','pedidos-online'), 'manage_options', 'pedidosonline-my-setting-admin', array($this, 'create_admin_page')
      ); */
    add_submenu_page(
            'pedidosonline-settings', __('Create Client', 'pedidos-online'), __('Create Client', 'pedidos-online'), 'manage_options', 'pedidosonline-create-users', array($this, 'create_user')
    );
    // This page will be under "Settings"
    /* add_options_page(
      __('Settings Admin','pedidos-online'),  __('Pedidos Online','pedidos-online'), 'manage_options', 'pedidosonline-my-setting-admin', array($this, 'create_admin_page')
      ); */
  }

  // Options page callback
  public function create_admin_page() {
    $this->options = get_option('pediodosonline_option_name');
    ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h2><?php echo __('Settings', 'pedidos-online'); ?></h2>
      <form method="post" action="options.php">
        <?php
        settings_fields('pediodosonline_option_group');
        do_settings_sections('pedidosonline-my-setting-admin');
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
            'pediodosonline_option_group', // Option group
            'pediodosonline_option_name', // Option name
            array($this, 'sanitize') // Sanitize
    );

    add_settings_section(
            'pediodosonline_admin', // ID
            '', // Title
            array(), // Callback
            'pedidosonline-my-setting-admin' // Page
    );

    $args = array(
        'sort_order' => 'ASC',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $this->publish_pages = get_pages($args);
    add_settings_field(
            'login_page', // ID
            'Login Page', // Title
            array($this, 'login_page_callback'), // Callback
            'pedidosonline-my-setting-admin', // Page
            'pediodosonline_admin' // Section
    );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function sanitize($input) {

    $new_input = array();

    if (!empty($input['login_page']))
      $new_input['login_page'] = sanitize_text_field($input['login_page']);

    return $new_input;
  }

  public function login_page_callback() {
    ?>
    <select id="app_edition_page" name="pediodosonline_option_name[login_page]" required>
      <option value="">-------------------</option>
      <?php
      $value = isset($this->options['login_page']) ? esc_attr($this->options['login_page']) : '';
      if (isset($this->publish_pages)) {
        foreach ($this->publish_pages as $page) {
          if ($page->ID == $value) {
            echo '<option value="' . $page->ID . '" selected>' . $page->post_title . '</option>';
          } else {
            echo '<option value="' . $page->ID . '" >' . $page->post_title . '</option>';
          }
        }
      }
      ?>
    </select>
    <?php
  }

  public function login($email, $password) {
    $result = $this->interface->login($email, $password);
    if ($result->status == "success") {
      wp_redirect($this->get_link_page('index.php'));
    }
    return false;
  }

  public function recoveryPassword($email) {
    $data = array('email' => $email);
    $result = $this->interface->request('api/users/password_recovery.json', 'post', $data);
    return $result;
  }

  public function redirectLogin() {
    $options = get_option('pediodosonline_option_name');
    if (isset($options['login_page']) && !empty($options['login_page'])) {
      $id = $options['login_page'];
      $login = get_permalink($id);
      wp_redirect($login);
      exit;
    }
  }

  /*
   * verify if client is login and redirect to login.
   */

  public function is_login($redirect = false) {
    $b_login = false;
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $result = $this->interface->request('api/users/checkAccessToken/' . $_COOKIE[$this->cookieName] . '.json');
      if ($result->status == "success") {
        $b_login = true;
      } else {
        setcookie("wp_pedidosonline", "", time() - 3600);
      }
    }
    if (!$b_login && $redirect) {
      $this->redirectLogin();
    }
    return $b_login;
  }

  /*
   *
   */

  public function get_clients_list($options = array()) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $_COOKIE[$this->cookieName]);
      $data = array_merge($data, $options);
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/clients/index.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data->clients;
      } else {
        return array();
      }
    }
  }

  /*
   *
   */

  public function create_client() {
    if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['code'])) {
      $data = array('email' => $_POST['email']);
      $data['access_token'] = $_COOKIE[$this->cookieName];
      $data['name'] = $_POST['name'];
      $data['address'] = $_POST['address'];
      $data['phone'] = $_POST['phone'];
      $data['code'] = $_POST['code'];
      $result = $this->interface->request('api/clients/add.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

}

global $pedidosOnline;
$pedidosOnline = new pedidosOnline();


