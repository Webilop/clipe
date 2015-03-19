<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pedidosOnline->create_client();
}
?>
<div><h1>Create of Client</h1></div>
<div class="">
  <form method="POST">
    <div>
      <label for="name"><?php _e('Name', 'pedidos-online'); ?></label>
      <input type="name" id="name" name="name" required/>
    </div>
    <div>
      <label for="email"><?php _e('Email', 'pedidos-online'); ?></label>
      <input type="email" id="email" name="email" required/>
    </div>
    <div>
      <label for="address"><?php _e('Address', 'pedidos-online'); ?></label>
      <input type="address" id="address" name="address" required/>
    </div>
    <div>
      <label for="phone"><?php _e('Phone', 'pedidos-online'); ?></label>
      <input type="phone" id="phone" name="phone" required/>
    </div>
    <div>
      <label for="code"><?php _e('Code', 'pedidos-online'); ?></label>
      <input type="code" id="code" name="code"/>
    </div>
    <input type="submit" value="<?php _e('Login', 'pedidos-online'); ?>" class="login-submit" id="submit" name="submit">
  </form>
</div>
<?php
get_sidebar();
get_footer();
?>

