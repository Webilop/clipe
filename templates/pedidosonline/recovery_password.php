<?php
global $pedidosOnline;
if ($pedidosOnline->is_login()) {
  ///redirect to index of pedidos online
  wp_redirect($pedidosOnline->get_link_page('index.php'));
} else {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $pedidosOnline->recoveryPassword($_POST['email']);
    ?><p> <?php print_r($result); ?></p><?php
  }
}

//get login page url
$options = get_option('pediodosonline_option_name');
$id = !empty($options['login_page']) ? $options['login_page'] : null;
$loginPage = get_permalink($id);

get_header();
?>
<div class="clipe-container">
  <div class="clipe-container">
    <div class="form-login">
      <form method="POST">
        <div>
          <label for="email"><?php _e('Email', 'clipe'); ?></label>
          <input type="email" id="login_email" name="email" required/>
        </div>
        <input type="submit" value="<?php _e('Recovery', 'clipe'); ?>" class="login-submit" id="submit" name="submit">
      </form>
    </div>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>
