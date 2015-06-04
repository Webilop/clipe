<?php
/**
 * Plugin Name: Clipe
 * Description: Clipe plugin add features to manage your clients and their supply orders in your WordPress website.
 * Version: 0.5
 * Text Domain: clipe
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
  private $gaTrackingCode = 'UA-63078862-3'; //-2 is production, -3 is dev
  private $flashMessageSession = "clipeFlashMessages";
  public $days; //array of delivery days with traduction.

  public function pedidosOnline() {
    //pages of plugin with respective template.
    $this->pages['1'] = 'index.php'; //index
    $this->pages['2'] = 'recovery_password.php';
    $this->pages['3'] = 'client_list.php';
    $this->pages['4'] = 'client_create.php';
    $this->pages['5'] = 'client_view.php';
    $this->pages['6'] = 'provider_list.php';
    $this->pages['7'] = 'product_list.php';
    $this->pages['8'] = 'product_edit.php';
    $this->pages['9'] = 'product_view.php';
    $this->pages['10'] = 'product_delete.php';
    $this->pages['11'] = 'product_create.php';
    $this->pages['12'] = 'reports.php';
    $this->pages['13'] = 'provider_edit.php';
    $this->pages['14'] = 'category_create.php';
    $this->pages['15'] = 'category_edit.php';
    $this->pages['16'] = 'category_list.php';
    $this->pages['17'] = 'category_view.php';
    $this->pages['18'] = 'category_delete.php';
    $this->pages['19'] = 'client_edit.php';
    $this->pages['20'] = 'office_edit.php';
    $this->pages['21'] = 'office_list.php';
    $this->pages['22'] = 'office_view.php';
    $this->pages['23'] = 'office_delete.php';
    $this->pages['24'] = 'office_create.php';
    $this->pages['25'] = 'order_edit.php';
    $this->pages['26'] = 'order_list.php';
    $this->pages['27'] = 'order_view.php';
    $this->pages['28'] = 'order_delete.php';
    $this->pages['29'] = 'order_create.php';
    $this->pages['30'] = 'config_error.php';
    $this->pages['31'] = 'order_cancel.php';
    $this->pages['32'] = 'batch_client_addition.php';
    $this->pages['33'] = 'validate_user.php';
    $this->pages['34'] = 'delivery_days_edit.php';
    $this->pages['35'] = 'batch_product_addition.php';
    $this->pages['36'] = 'report_orders.php';
    $this->days = array('Lunes' => __('Monday', 'clipe'), 'Martes' => __('Tuesday', 'clipe'), 'Miercoles' => __('Wednesday', 'clipe'), 'Jueves' => __('Thursday', 'clipe'), 'Viernes' => __('Friday', 'clipe'), 'Sabado' => __('Saturday', 'clipe'), 'Domingo' => __('Sunday', 'clipe'));
    add_action('admin_menu', array($this, 'add_plugin_page'));
    add_action('admin_init', array($this, 'page_init'));
    add_action('widgets_init', array($this, 'create_clipe_sidebar'));
    add_action('clipe-flash-messages', array($this, 'display_flash_messages'), 1);
    add_action('wp_head', array($this, 'clipe_head_section'));
    add_action('plugins_loaded', array($this, 'load_translations'));

    add_filter('template_include', array($this, 'template_function'));
    add_action('template_redirect', array($this, 'validAdminAccess'));
    $this->interface = new InterfacePedidos();

    //init session
    if (!session_id()) {
      session_start();
    }
  }

  /*
   * return the link to a page, page is the name of the template if no exist return false
   */

  public function get_link_page($page) {
    $key = array_search($page, $this->pages);
    if ($key) {
      return site_url() . '?' . $this->suffixPages . $key;
    }
    return false;
  }

  /*
   * Check if credentials in backend are correct
   */

  function validAdminAccess() {
    $validAccess = true;
    $options = get_option('pediodosonline_option_name');
    if (!isset($options['email']) || !isset($options['password'])) {
      $validAccess = false;
    } elseif (!$this->login($options['email'], $options['password'], false, true)) {
      $validAccess = false;
    }

    if (isset($_SERVER['QUERY_STRING'])) {
      $array = explode("&", $_SERVER['QUERY_STRING']);
      $page = $array[0]; //page always firts.
      $pos = strpos($page, $this->suffixPages);
      $pageNumber = substr($page, $pos);
      if ($pos && isset($this->pages[$pageNumber]) && $pageNumber != 30) {
        if (!$validAccess) {
          wp_redirect(site_url() . '?' . $this->suffixPages . 30);
          die();
        }
      }
    }

    if (isset($options['login_page']) && !empty($options['login_page'])) {
      $id = $options['login_page'];
      if (is_page($id)) {
        if (!$validAccess) {
          wp_redirect(site_url() . '?' . $this->suffixPages . 30);
          die();
        }
      }
    }
    return;
  }

  public function get_logout_url() {
    return site_url() . '?' . $this->suffixPages . "logout";
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
      $array = explode("&", $_SERVER['QUERY_STRING']);
      $page = $array[0]; //page always firts.
      if ($page == $this->suffixPages . "logout") {
        //delete cockie.
        $this->interface->logout();
        $this->redirectLogin();
      }
      //echo "QUERY_STRING:".$page;
      foreach ($this->pages as $key => $value) {
        if ($page == $this->suffixPages . $key) {
          wp_enqueue_script('clipe-functions', plugins_url('inc/js/functions.js', __FILE__), array('jquery'));
          wp_enqueue_style('font-awesome', plugins_url('lib/font-awesome/font-awesome.min.css', __FILE__));
          wp_enqueue_style('clipe_css', plugins_url('templates/pedidosonline/css/styles.css', __FILE__));
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
        wp_enqueue_style('clipe_css', plugins_url('templates/pedidosonline/css/styles.css', __FILE__));
        $template_path = $this->search_template('login.php');
      }
    }
    return $template_path;
  }

  /**
   * Load translations for the plugin
   */
  public function load_translations() {
    load_plugin_textdomain('clipe', false, dirname(plugin_basename(__FILE__)) . '/languages');
  }

  // Add options page
  public function add_plugin_page() {
    add_options_page(
            __('Clipe Access', 'clipe'), __('Clipe', 'clipe'), 'manage_options', 'pedidosonline-settings', array($this, 'create_admin_page')
    );
  }

  // Options page callback
  public function create_admin_page() {
    $this->options = get_option('pediodosonline_option_name');
    ?>
    <div class="wrap">
      <h2><?php echo __('Settings', 'clipe'); ?></h2>
      <form method="post" action="options.php">
        <?php
        settings_fields('pediodosonline_option_group');
        do_settings_sections('pedidosonline-settings');
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
            'pedidosonline-settings' // Page
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
            __('Login Page', 'clipe'), // Title
            array($this, 'login_page_callback'), // Callback
            'pedidosonline-settings', // Page
            'pediodosonline_admin' // Section
    );
    add_settings_field(
            'email', // ID
            __('Email', 'clipe'), // Title
            array($this, 'email_callback'), // Callback
            'pedidosonline-settings', // Page
            'pediodosonline_admin' // Section
    );
    add_settings_field(
            'password', // ID
            __('Password', 'clipe'), // Title
            array($this, 'password_callback'), // Callback
            'pedidosonline-settings', // Page
            'pediodosonline_admin' // Section
    );
    add_settings_field(
            'collect-stats-data', // ID
            __('Allow collection of statistic data in Clipe', 'clipe'), // Title
            array($this, 'checkbox_field_callback'), // Callback
            'pedidosonline-settings', // Page
            'pediodosonline_admin', // Section
            array(
        'optionName' => 'collect-stats-data'
            )
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

    if (!empty($input['email']))
      $new_input['email'] = sanitize_text_field($input['email']);

    if (!empty($input['password']))
      $new_input['password'] = sanitize_text_field($input['password']);

    $response = $this->interface->request('api/users/login.json', 'post', array(
        'email' => $new_input['email'],
        'password' => $new_input['password']
    ));
    if (isset($response->data->access_token)) {
      $access_token = $response->data->access_token;
      //Update provider URL
      $data['access_token'] = $access_token;
      $data['url'] = get_bloginfo('url');
      $result = $this->interface->request('api/providers/setURL.json', 'post', $data);
    } else {
      add_settings_error('email', 'invalid_credentials', 'Email or password
          incorrects. If you don\'t have an account, create a new free account
          <a href="http://clipe.co/register" target="_blank"> here.</a>', 'error');
    }
    delete_option('pediodosonline_provider');

    return $new_input;
  }

  /*
   * get the provider id of the admin of site.
   */

  public function get_admin_provider_id() {
    $provider_id = get_option('pediodosonline_provider');
    if ($provider_id) {
      return $provider_id;
    }
    $options = get_option('pediodosonline_option_name');
    $result = $this->interface->request('api/users/login.json', 'post', array('email' => $options['email'], 'password' => $options['password']));
    if ($result->status == "success") {
      $token = $result->data->access_token;
      $data = array('access_token' => $token);
      $parameters = http_build_query($data);
      $user = $this->interface->request('api/users/getId.json?' . $parameters);
      if ($user->status == "success") {
        $id = $user->data->id;
        $result = $this->interface->request('api/users/get/' . $id . '.json?' . $parameters);
        if ($result->status == "success") {
          if (isset($result->data->Provider->id)) {
            update_option('pediodosonline_provider', $result->data->Provider->id);
            return $result->data->Provider->id;
          }
        } else {
          return 0;
        }
      }
    } else {
      echo '<h1>' . __('There is an error in the server of clipe or is not configured at administrator account on the backend of Worpress', 'clipe') . '</h1>';
      exit;
    }
  }

  public function email_callback() {
    ?>
    <input value="<?php echo isset($this->options['email']) ? esc_attr($this->options['email']) : ''; ?>" name="pediodosonline_option_name[email]" type="email"/>
    <?php
  }

  public function password_callback() {
    ?>
    <input type="password" value="<?php echo isset($this->options['password']) ? esc_attr($this->options['password']) : ''; ?>" name="pediodosonline_option_name[password]" /><br>
    <?php
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

  /**
   * Output the input for checkbox fields
   *
   * @param $args array associative array with arguments to create the field.
   */
  public function checkbox_field_callback($args) {
    $selected = !isset($this->options[$args['optionName']]) or 0 != $this->options[$args['optionName']];
    ?>
    <input value="0" name="pediodosonline_option_name[<?= $args['optionName']; ?>]" type="hidden"/>
    <input value="1" <?php checked(1, $selected); ?> name="pediodosonline_option_name[<?= $args['optionName']; ?>]" type="checkbox"/>
    <?php
  }

  // Register Clipe Sidebar
  function create_clipe_sidebar() {
    $args = array(
        'name' => __('Clipe Sidebar'),
        'id' => "clipe",
        'description' => '',
        'class' => '',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => "</li>\n",
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => "</h2>\n",
    );
    register_sidebar($args);
  }

  public function login($email, $password, $redirect = true, $onlyCheck = false) {
    $result = $this->interface->login($email, $password, $onlyCheck);
    if ($result->status == "success") {
      if ($redirect) {
        $_SESSION[$this->flashMessageSession] = array();
        wp_redirect($this->get_link_page('index.php'));
        exit;
      }
      return true;
    }
    $this->add_flash_message(__($result->data->message, 'clipe'));
  }

  public function logout() {
    $this->interface->logout();
  }

  public function recoveryPassword($email) {
    $data = array('email' => $email);
    $result = $this->interface->request('api/users/password_recovery.json', 'post', $data);
    return $result;
  }

  public function validateUser($id, $token) {
    $data = array('id' => $id, 'token' => $token);
    $result = $this->interface->request('api/users/activateAccount.json', 'post', $data);
    if ($result->status == 'success') {
      $this->add_flash_message(__($result->data->message, 'clipe'), 'success');
    } else {
      $this->add_flash_message(__($result->message, 'clipe'));
    }
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
    // error_log($_COOKIE[$this->cookieName]);
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $result = $this->interface->request('api/users/checkAccessToken/' . $this->interface->decrypt($_COOKIE[$this->cookieName]) . '.json');
      if ($result->status == "success") {
        $b_login = true;
      } else {
        $this->interface->logout();
      }
    }
    if (!$b_login && $redirect) {
      $this->redirectLogin();
    }
    return $b_login;
  }

  /**
   * This function adds flash message to be displayed in the next page rendering.
   *
   * @param $message string message to be displayed in the next page.
   * @param $type string type of the flash message: success, info, warning, danger.
   */
  public function add_flash_message($message, $type = 'danger') {
    //get current messages
    $currentMessages = isset($_SESSION[$this->flashMessageSession]) ? $_SESSION[$this->flashMessageSession] : array();

    //add message
    $currentMessages [] = array('message' => $message, 'type' => $type);

    //store new message
    $_SESSION[$this->flashMessageSession] = $currentMessages;
  }

  /**
   * This function retrieves and flush flash messages.
   *
   * @param $flush boolean true if messages should be deleted.
   *
   * @return array array with flash messages and their types.
   */
  public function get_flash_messages($flush = true) {
    //get current messages
    if (isset($_SESSION[$this->flashMessageSession])) {
      $currentMessages = $_SESSION[$this->flashMessageSession];

      //delete messages
      if ($flush)
        $_SESSION[$this->flashMessageSession] = array();

      return $currentMessages;
    }
  }

  /**
   * This function displays flash messages. It is used in the head hook to display messages in the top section.
   *
   * @param $flush boolean true if messages should be deleted.
   */
  public function display_flash_messages($flush = true) {
    include $this->search_template('flash_messages.php');
  }

  /**
   * This function add custom code to the head section of pages.
   *
   * - Add confirmation message for element deletion.
   */
  public function clipe_head_section() {
    ?>
    <script type="text/javascript">
      confirmDeletionMessage = "<?= __('Are you sure?', 'clipe'); ?>";
      confirmCancelMessage = "<?= __('Are you sure you want to cancel the order?', 'clipe'); ?>";
    </script>
    <?php
    //check if user is in a Clipe page
    if (isset($_SERVER['QUERY_STRING']) && false !== strpos($_SERVER['QUERY_STRING'], $this->suffixPages)):

      //addition of GA tracking code
      $options = get_option('pediodosonline_option_name');
      if (!isset($options['collect-stats-data']) or 0 != $options['collect-stats-data']):
        ?>
        <script type="text/javascript">
        //load universal GA if it not loaded
          if (!window.ga || !ga.create) {
            (function (i, s, o, g, r, a, m) {
              i['GoogleAnalyticsObject'] = r;
              i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
              }, i[r].l = 1 * new Date();
              a = s.createElement(o),
                      m = s.getElementsByTagName(o)[0];
              a.async = 1;
              a.src = g;
              m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
          }
          ga('create', '<?= $this->gaTrackingCode; ?>', 'auto', {'name': 'clipe'});
          ga('clipe.send', 'pageview');
        </script>
        <?php
      endif; //addition of GA tracking code

    endif; //if user is in a clipe page
  }

  /*
   * multiple selects
   * $previusClients array of ids.
   */

  public function get_clients_options($previusClients = array(), $options = array()) {
    $clients = $this->get_clients($options)->clients;
    $html = "";
    foreach ($clients as $client) {
      $selected = "";
      if (in_array($client->Client->id, $previusClients)) {
        $selected = 'selected';
      }
      $html.='<option ' . $selected . ' value="' . $client->Client->id . '">' . $client->Client->name . '</option>';
    }
    return $html;
  }

  /*
   * clientes asociados al provedor, el api filtra epor provedor.
   */

  public function get_clients($options = array()) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $data = array_merge($data, $options);
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/clients/index.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function addition_file_of_clients() {
    if (isset($_FILES['file'])) {
      $filetmp = fopen($_FILES['file']['tmp_name'], 'r');
      $contenido = fread($filetmp, $_FILES['file']['size']);
      fclose($filetmp);

      $contenido = base64_encode($contenido);
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['file'] = $contenido;
      $result = $this->interface->request('api/clients/addFromFile.json', 'post', $data);
      if ($result->status == 'fail') {
        $resultAux = array('status' => $result->status, 'message' => $result->message);
        $resultAux['errors'] = array();
        foreach ($result->data as $objError) {
          //$resultAux['errors'][] = array('field' => $objError->field, 'error' => $objError->error->{0}->{0});
          $resultAux['errors'][] = sprintf(__('The client %s could not be created by %s', 'cilpe'), $objError->field, $objError->error->{0}->{0});
        }
      } else {
        $resultAux = array('status' => $result->status, 'message' => $result->data->message);
      }
      return json_decode(json_encode($resultAux));
    }
    return 'validate fields';
  }

  public function addition_file_of_products() {
    if (isset($_FILES['file'])) {
      $filetmp = fopen($_FILES['file']['tmp_name'], 'r');
      $contenido = fread($filetmp, $_FILES['file']['size']);
      fclose($filetmp);

      $contenido = base64_encode($contenido);
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['file'] = $contenido;
      $result = $this->interface->request('api/products/addFromFile.json', 'post', $data);

      if ($result->status == 'fail') {
        $resultAux = array('status' => $result->status, 'message' => $result->message);
        $resultAux['errors'] = array();
        foreach ($result->data as $objError) {
          //$resultAux['errors'][] = array('field' => $objError->field, 'error' => $objError->error->{0}->{0});
          $resultAux['errors'][] = sprintf(__('The Product %s could not be created by %s', 'cilpe'), $objError->field, $objError->error->{0}->{0});
        }
      } else {
        $resultAux = array('status' => $result->status, 'message' => $result->data->message);
      }
      return json_decode(json_encode($resultAux));
    }
    return 'validate fields';
  }

  public function create_client() {
    if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['zone'])) {
      $data = array('email' => $_POST['email']);
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['name'] = $_POST['name'];
      $data['address'] = $_POST['address'];
      $data['phone'] = $_POST['phone'];
      $data['code'] = isset($_POST['code']) ? $_POST['code'] : '';
      $data['short_name'] = isset($_POST['short_name']) ? $_POST['short_name'] : '';
      $data['delivery_days'] = isset($_POST['delivery_days']) ? $_POST['delivery_days'] : array();
      $data['zone'] = $_POST['zone'];
      $result = $this->interface->request('api/clients/add.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function edit_client($id) {
    if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['first_name']) && isset($_POST['last_name'])) {
      $data = array('email' => $_POST['email']);
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['name'] = $_POST['name'];
      $data['first_name'] = $_POST['first_name'];
      $data['last_name'] = $_POST['last_name'];
      if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['current_password'])) {
        $data['password'] = $_POST['password'];
        $data['confirm_password'] = $_POST['confirm_password'];
        $data['current_password'] = $_POST['current_password'];
      }
      $result = $this->interface->request('api/clients/edit/' . $id . '.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function get_client($id) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/providers/getClient/' . $id . '.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function create_product() {
    if (isset($_POST['name']) && isset($_POST['measure_type']) && (isset($_POST['category_id']) || isset($_POST['category_name']))) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['name'] = $_POST['name'];
      $data['measure_type'] = $_POST['measure_type'];
      if (isset($_POST['category_id'])) {
        $data['category_id'] = $_POST['category_id'];
      }
      if (isset($_POST['category_name'])) {
        $data['category_name'] = $_POST['category_name'];
      }
      $data['client_id'] = isset($_POST['client_id']) ? $_POST['client_id'] : array();
      $result = $this->interface->request('api/products/add.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function delete_product($id) {
    if (isset($id)) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $parameters = http_build_query(array('access_token'=>$data['access_token']));
      $result = $this->interface->request('api/products/delete/' . $id . '.json?' . $parameters, 'delete');
      return $result;
    }
    return 'validate fields';
  }

  public function edit_product($id) {
    if (isset($_POST['name'])) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['name'] = $_POST['name'];
      $data['measure_type'] = $_POST['measure_type'];
      if (isset($_POST['category_id'])) {
        $data['category_id'] = $_POST['category_id'];
      }
      if (isset($_POST['category_name'])) {
        $data['category_name'] = $_POST['category_name'];
      }
      $data['client_id'] = isset($_POST['client_id']) ? $_POST['client_id'] : array();
      $result = $this->interface->request('api/products/edit/' . $id . '.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function get_products($options = array()) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $data = array_merge($data, $options);
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/products/index.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function get_product($id) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/products/get/' . $id . '.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function get_provider($id) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/providers/get/' . $id . '.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function edit_provider($id) {
    if (isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['url'])) {
      $data = array('email' => $_POST['email']);
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['name'] = $_POST['name'];
      $data['first_name'] = $_POST['first_name'];
      $data['last_name'] = $_POST['last_name'];
      $data['phone'] = $_POST['phone'];
      $data['address'] = $_POST['address'];
      $data['url'] = $_POST['url'];
      if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['current_password'])) {
        $data['password'] = $_POST['password'];
        $data['confirm_password'] = $_POST['confirm_password'];
        $data['current_password'] = $_POST['current_password'];
      }
      $result = $this->interface->request('api/providers/edit/' . $id . '.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function create_category() {
    if (isset($_POST['name'])) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['name'] = $_POST['name'];
      $result = $this->interface->request('api/product_categories/add.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function delete_category($id) {
    if (isset($id)) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $parameters = http_build_query(array('access_token'=>$data['access_token']));
      $result = $this->interface->request('api/product_categories/delete/' . $id . '.json?'.$parameters, 'delete');
      return $result;
    }
    return 'validate fields';
  }

  public function edit_category($id) {
    if (isset($_POST['name'])) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['name'] = $_POST['name'];
      $result = $this->interface->request('api/product_categories/edit/' . $id . '.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function get_categories($options = array()) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $data = array_merge($data, $options);
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/product_categories/index.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function get_category($id) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/product_categories/get/' . $id . '.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data->ProductCategory;
      } else {
        return array();
      }
    }
  }

  public function get_categories_options($id = 0, $options = array()) {
    $categories = $this->get_categories($options)->productCategories;
    $htmlCategories = "";
    foreach ($categories as $category) {
      $selected = "";
      if ($id == $category->ProductCategory->id) {
        $selected = "selected";
      }
      $htmlCategories.='<option ' . $selected . ' value="' . $category->ProductCategory->id . '">' . $category->ProductCategory->name . '</option>';
    }
    return $htmlCategories;
  }

  public function create_office() {
    if (isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['email'])) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['address'] = $_POST['address'];
      $data['phone'] = $_POST['phone'];
      $data['email'] = $_POST['email'];
      $provider_id = $this->get_admin_provider_id();
      if ($provider_id != 0) {
        $data['provider_id'] = $provider_id;
        $result = $this->interface->request('api/headquarters/add.json', 'post', $data);
        return $result;
      } else {
        echo __('There is an error in the server of clipe or is not configured at administrator account on the backend of Worpress', 'clipe');
        exit;
      }
    }
    return 'validate fields';
  }

  public function delete_office($id) {
    if (isset($id)) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $parameters = http_build_query(array('access_token'=>$data['access_token']));
      $result = $this->interface->request('api/headquarters/delete/' . $id . '.json?'.$parameters, 'delete');
      return $result;
    }
    return 'validate fields';
  }

  public function edit_office($id) {
    if (isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['email'])) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['address'] = $_POST['address'];
      $data['phone'] = $_POST['phone'];
      $data['email'] = $_POST['email'];
      $result = $this->interface->request('api/headquarters/edit/' . $id . '.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function get_offices($options = array()) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $data = array_merge($data, $options);
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/headquarters/index.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function get_office_orders($id, $profile = 'client') {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $orders = $this->get_orders(array('profile' => $profile))->Orders;
      $office_orders = array();
      foreach ($orders as $order) {
        if ($order) {
          if ($order->HeadquartersProvider->headquarter_id == $id) {
            $office_orders[] = $order;
          }
        }
      }
      return $office_orders;
    }
  }

  public function get_office_zone($id) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/headquarters/get/' . $id . '.json?' . $parameters);
      if ($result->status == "success") {
        $provider_id = $this->get_admin_provider_id();
        $zone = $result->data->Zone;
        return $zone;
      } else {
        return array();
      }
    }
  }

  /*
   * $b_provider filter offieces by provider
   */
  public function get_office($id) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/headquarters/get/' . $id . '.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  /*public function get_providers_client_options($id = 0, $options = array()) {
    $providers = array(0 => array("id" => 1, "name" => 'testingwebilop->quemado'));
    $providers = json_decode(json_encode($providers), FALSE);
    $htmlProviders = "";
    foreach ($providers as $provider) {
      $selected = "";
      if ($id == $provider->id) {
        $selected = 'selected';
      }
      $htmlProviders.='<option ' . $selected . ' value="' . $provider->id . '">' . $provider->name . '</option>';
    }
    return $htmlProviders;
  }*/

  public function get_client_products($options = array()) {
    $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
    $provider_id = $this->get_admin_provider_id();
    if ($provider_id == 0) {
      return array();
    }
    $data['provider_id'] = $provider_id;
    $data = array_merge($data, $options);
    $parameters = http_build_query($data);
    $result = $this->interface->request('api/clients/getProducts.json?' . $parameters);
    if ($result->status == "success") {
      return $result->data->Orders;
    } else {
      return array();
    }
  }

  public function get_client_products_options($options = array()) {
    if (isset($options['headquarter_id'])) {
      $office = $this->get_office($options['headquarter_id']);
      $clientID = $office->Headquarters->client_id;
      $products = $this->get_products(array('clientId' => $clientID))->Products;
    } else {
      $products = $this->get_client_products($options);
    }
    $html = "";
    foreach ($products as $product) {
      $html.='<option value="' . $product->Product->id . '">' . $product->Product->name . '</option>';
    }
    return $html;
  }

  public function get_offices_provider_options($options = array()) {
    $offices = $this->get_offices($options)->headquarters;
    $html = "";
    $provider_id=$this->get_admin_provider_id();
    foreach ($offices as $office) {
      $officeAux = $this->get_office($office->Headquarters->id);
      if(isset($officeAux->HeadquartersProvider)){
        foreach ($officeAux->HeadquartersProvider as $HeadquartersProvider) {
          if($HeadquartersProvider->provider_id==$provider_id){
            $html.='<option value="' . $officeAux->Headquarters->id . '">' . $officeAux->Headquarters->address . '</option>';
            break;
          }
        }
      }
    }
    return $html;
  }

  public function create_order() {
    if (isset($_POST['headquarters_id']) && isset($_POST['date']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
      $data['provider_id']= $this->get_admin_provider_id();
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['headquarters_id'] = $_POST['headquarters_id'];
      $data['date'] = $_POST['date'];
      $data['product_id'] = $_POST['product_id'];
      $data['quantity'] = $_POST['quantity'];
      $result = $this->interface->request('api/orders/add.json', 'post', $data);
      return $result;
    }
    return __('Order couldn\'t be created. Please verify fields', 'clipe');
  }

  public function delete_order($id) {
    if (isset($id)) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $parameters = http_build_query(array('access_token'=>$data['access_token']));
      $result = $this->interface->request('api/orders/delete/' . $id . '.json?'.$parameters, 'delete');
      return $result;
    }
    return 'validate fields';
  }

  public function edit_order($id, $cancel = false) {
    if ($cancel) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $data['status'] = 'Cancelado';
      $result = $this->interface->request('api/orders/edit/' . $id . '.json', 'post', $data);
      return $result;
    } elseif (isset($_POST['date']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      if ($_POST['beforeDate'] != $_POST['date']) {
        $data['date'] = $_POST['date'];
      }
      $data['product_id'] = $_POST['product_id'];
      $data['quantity'] = $_POST['quantity'];
      $data['status'] = $_POST['status'];
      $result = $this->interface->request('api/orders/edit/' . $id . '.json', 'post', $data);
      return $result;
    }
    return 'validate fields';
  }

  public function get_orders($options = array()) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $data = array_merge($data, $options);
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/orders/index.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function get_order($id) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/orders/get/' . $id . '.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data;
      } else {
        return array();
      }
    }
  }

  public function get_user_id() {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/users/getId.json?' . $parameters);
      if ($result->status == "success") {
        return $result->data->id;
      } else {
        return false;
      }
    }
  }

  public function get_user($id) {
    if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
      $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]));
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/users/get/' . $id . '.json?' . $parameters);
      if ($result->status == "success") {
        $data = $result->data;
        $permissions = array();
        if (isset($data->Client) && !empty($data->Client->id)) {
          $permissions[] = 'client';
        }
        if (isset($data->Provider) && !empty($data->Provider->id)) {
          $permissions[] = 'provider';
        }
        $data->permissions = $permissions;
        return $data;
      } else {
        return array();
      }
    }
  }

  public function get_delivery_days($clientID, $officeID, $profile) {
    if ($profile == "provider") {
      //if client is 0 consult by $office
      if ($clientID != 0) {
        $result = $this->get_client($clientID);
        foreach ($result->Headquarters as $office) {
          if ($office->id == $officeID) {
            if (isset($office->delivery_days)) {
              return $office->delivery_days;
            } else {
              return array();
            }
          }
        }
      } else {

      }
    } else {
      if (isset($_COOKIE[$this->cookieName]) && $_COOKIE[$this->cookieName] != '') {
        $provider_id = $this->get_admin_provider_id();
        if ($provider_id == 0) {
          return array();
        }
        $data = array('access_token' => $this->interface->decrypt($_COOKIE[$this->cookieName]), 'provider_id' => $provider_id);
        $parameters = http_build_query($data);
        $result = $this->interface->request('api/headquarters/getDeliveryDays/' . $officeID . '.json?' . $parameters);
        if ($result->status == "success") {
          return $result->data->delivery_days;
        }
      }
    }
    return array();
  }

  public function get_delivery_days_options() {
    echo '<option value="">' . __('Chose one', 'clipe') . '</option>';
    if (isset($_POST['client']) && isset($_POST['office']) && isset($_POST['profile'])) {
      $days = $this->get_delivery_days($_POST['client'], $_POST['office'], $_POST['profile']);
      $deliveryDays = array();
      foreach ($days as $day) {
        switch ($day->day) {
          case 'Lunes':
            $deliveryDays[] = 'Monday';
            break;
          case 'Martes':
            $deliveryDays[] = 'Tuesday';
            break;
          case 'Miercoles':
            $deliveryDays[] = 'Wednesday';
            break;
          case 'Jueves':
            $deliveryDays[] = 'Thursday';
            break;
          case 'Viernes':
            $deliveryDays[] = 'Friday';
            break;
          case 'Sabado':
            $deliveryDays[] = 'Saturday';
            break;
          case 'Domingo':
            $deliveryDays[] = 'Sunday';
            break;
        }
      }
      if (!empty($deliveryDays)) {
        $date = new DateTime();
        $numberDays = isset($_POST['numberDays']) ? $_POST['numberDays'] : 5;
        for ($i = 0; $i < $numberDays;) {
          $date->add(new DateInterval('P1D'));
          if (in_array($date->format('l'), $deliveryDays)) {
            $i++;
            echo '<option value="' . $date->format('Y-m-d') . '">' . $date->format('Y-m-d ') . __($date->format('l'), 'clipe') . '</option>';
          }
        }
        //show a option selected
        if (isset($_POST['date'])) {
          $date = new DateTime($_POST['date']);
          echo '<option selected value="' . $date->format('Y-m-d') . '">' . $date->format('Y-m-d ') . __($date->format('l'), 'clipe') . '</option>';
        }
      }
    }
    exit;
  }

  public function edit_delivery_days($officeID) {
    $delivery_days = array();
    if (isset($_POST['delivery_days'])) {
      $delivery_days = $_POST['delivery_days'];
    }
    if (isset($_POST['zone'])) {
      $data['zone'] = $_POST['zone'];
    }
    if (isset($_POST['code'])) {
      $data['code'] = $_POST['code'];
    }
    $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
    $data['delivery_days'] = $delivery_days;
    $result = $this->interface->request('api/providers/editHeadquarters/' . $officeID . '.json', 'post', $data);
    return $result;
  }

  public function report_orders() {
    if (isset($_POST['dates']) && (isset($_POST['client_id']))) {
      $data['access_token'] = $this->interface->decrypt($_COOKIE[$this->cookieName]);
      $dates = explode(" to ", $_POST['dates']);
      $start_date = $dates[0];
      $end_date = $dates[1];
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      if (isset($_POST['client_id'])) {
        $data['client_id'] = $_POST['client_id'];
      }
      if (isset($_POST['status'])) {
        $data['status'] = $_POST['status'];
      }
      $parameters = http_build_query($data);
      $result = $this->interface->request('api/orders/report.json?' . $parameters, 'get', $data);
      $message = "";
      $status = "success";
      $data = array();
      if (isset($result->status) && $result->status == "error") {
        //error
        $message = $result->message;
        $status = "error";
      } else {
        $orders = $result->data->Orders;
        if (!empty($orders)) {
          foreach ($orders as $order) {
            $data[$order->Order->delivery_date][$order->Headquarters->client_id][$order->Headquarters->zone]['sedes'][$order->Headquarters->id] = $order->Headquarters->address;
            foreach ($order->OrdersProduct as $product) {
              if (isset($data[$order->Order->delivery_date][$order->Headquarters->client_id][$order->Headquarters->zone]['products'][$product->product_id]['sedes'][$order->Headquarters->id])) {
                $data[$order->Order->delivery_date][$order->Headquarters->client_id][$order->Headquarters->zone]['products'][$product->product_id]['sedes'][$order->Headquarters->id]+=$product->quantity;
              } else {
                $data[$order->Order->delivery_date][$order->Headquarters->client_id][$order->Headquarters->zone]['products'][$product->product_id] = array('name' => $product->name, 'sedes' => array($order->Headquarters->id => $product->quantity));
              }
            }
          }
        } else {
          //error
          $message = __('Not Results', 'clipe');
          $status = "error";
        }
      }
      return array('status' => $status, 'message' => $message, 'data' => $data);
    }
    return 'validate fields';
  }

  public function print_pagination($totalRows, $numberRows = 10) {
    ?>
    <nav>
      <ul class="pagination">
    <?php
    $active = isset($_GET['page']) ? $_GET['page'] : 1;
    $numberPages = ceil($totalRows / $numberRows);
    $previewUrl = $_SERVER['REQUEST_URI'];
    $previewUrl = preg_replace('/&page=(\d)+/', '', $previewUrl);
    ?>
        <li class="<?php echo ($active == 1) ? 'disabled' : ''; ?>">
          <a href="<?php echo $previewUrl; ?>&page=<?php echo $active - 1 ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php
        for ($i = 1; $i <= $numberPages; $i++) {
          ?>
          <li class="<?php echo ($i == $active) ? 'active' : ''; ?>"><a href="<?php echo $previewUrl; ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
      <?php
    }
    ?>
        <li class="<?php echo ($active == $numberPages) ? 'disabled' : ''; ?>">
          <a href="<?php echo $previewUrl; ?>&page=<?php echo $active + 1 ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    <?php
  }
  /*
   * redirect if the user not have the permission.
   */
  public function validatePermission($permission) {
    $userId = $this->get_user_id();
    $user = $this->get_user($userId);
    if (!in_array($permission, $user->permissions)) {
      $this->add_flash_message(__('the user does not have permission for the page', 'clipe'));
      wp_redirect($this->get_link_page('index.php'));
      exit();
    }
  }

}

global $pedidosOnline;
$pedidosOnline = new pedidosOnline();

add_action('wp_ajax_nopriv_clipe_delivery_days_options', array($pedidosOnline, 'get_delivery_days_options'));
add_action('wp_ajax_clipe_delivery_days_options', array($pedidosOnline, 'get_delivery_days_options'));


