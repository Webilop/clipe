<?php
/**
 *
 * Template Name: pedidos-online
 * Description: The template for login in pedidosonline
 */
global $pedidosOnline;
if ($pedidosOnline->is_login()) {
  ///redirect to index of pedidos online
  wp_redirect($pedidosOnline->get_link_page('index.php'));
} else {  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedidosOnline->login($_POST['email'], $_POST['password']);
  }
}
?>

<?php get_header(); ?>
<div class="clipe-container">
  <div class="form-login row">
    <form method="POST" class="col-md-6">
      <div class="form-group">
        <label for="email"><?php _e('Email', 'clipe'); ?></label>
        <input class="form-control" type="email" id="login_email" name="email" required/>
      </div>
      <div class="form-group">
        <label for="password"><?php _e('Password', 'clipe'); ?></label>
        <input class="form-control" type="password" id="login_password" name="password" required/>
      </div>
      <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
        <?php _e('Login', 'clipe'); ?>
      </button>
      <a class="password-recovery-link" href="<?php echo $pedidosOnline->get_link_page('recovery_password.php'); ?>">
        <?php _e('Password Recovery', 'clipe'); ?>
      </a>
    </form>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>