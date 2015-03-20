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
  <div class="clipe-container">
    <div class="clipe-login">
      <form method="POST">
        <div>
          <label for="email"><?php _e('Email', 'clipe'); ?></label>
          <input type="email" id="login_email" name="email" required type="email"/>
        </div>
        <div>
          <label for="password"><?php _e('Password', 'clipe'); ?></label>
          <input type="password" id="login_password" name="password" required/>
        </div>
        <input type="submit" value="<?php _e('Login', 'clipe'); ?>" class="button" id="submit" name="submit">
        <a class="button" href="<?php echo $pedidosOnline->get_link_page('recovery_password.php'); ?>"><?php _e('Recovery Password', 'clipe'); ?></a>
      </form>
    </div>
  </div>

  <?php
}
get_sidebar();
get_footer();
?>