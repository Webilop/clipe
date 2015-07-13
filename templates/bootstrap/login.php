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
      <?php
      $pedidosOnline->html->create('email',array('label_text'=>'Email','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('password',array('type'=>'password','label_text'=>'Password','class'=>'form-control','div_class'=>'form-group','required'=>true));
      ?>
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