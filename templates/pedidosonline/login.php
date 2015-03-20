<?php
/**
 *
 * Template Name: pedidos-online
 * Description: The template for login in pedidosonline
 */
get_header();
global $pedidosOnline;
if ($pedidosOnline->is_login()) {
  ///redirect to index of pedidos online
  wp_redirect($pedidosOnline->get_link_page('index.php'));
} else {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedidosOnline->login($_POST['email'], $_POST['password']);
  }
  ?>
  <div class="form-login">
    <form method="POST">
      <div>
        <label for="email"><?php _e('Email', 'pedidos-online'); ?></label>
        <input type="email" id="login_email" name="email" required/>
      </div>
      <div>
        <label for="password"><?php _e('Password', 'pedidos-online'); ?></label>
        <input type="password" id="login_password" name="password" required/>
      </div>
      <input type="submit" value="<?php _e('Login', 'pedidos-online'); ?>" class="login-submit" id="submit" name="submit">
      <a class="button button-primary login-recovery" href="<?php echo $pedidosOnline->get_link_page('recovery_password.php'); ?>"><?php _e('Recovery Password', 'pedidos-online'); ?></a>
    </form>
  </div>

  <?php
}
get_sidebar();
get_footer();
?>