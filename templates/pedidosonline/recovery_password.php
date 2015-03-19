<?php
get_header();
global $pedidosOnline;
if ($pedidosOnline->is_login()) {
  ///redirect to index of pedidos online
  wp_redirect($pedidosOnline->get_link_page('index.php'));
} else {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result=$pedidosOnline->recoveryPassword($_POST['email']);
    ?><p> <?php print_r($result); ?></p><?php
  }
  ?>
  <div class="form-login">
    <form method="POST">
      <div>
        <label for="email"><?php _e('Email', 'pedidos-online'); ?></label>
        <input type="email" id="login_email" name="email" required/>
      </div>
      <input type="submit" value="<?php _e('Recovery', 'pedidos-online'); ?>" class="login-submit" id="submit" name="submit">
    </form>
  </div>

  <?php
}
get_sidebar();
get_footer();
?>