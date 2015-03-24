<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pedidosOnline->create_client();
}
?>
<div class="clipe-container">
  <h1>Create of Client</h1>
  <form method="POST">
    <div>
      <label for="name"><?php _e('Name', 'clipe'); ?></label>
      <input type="text" id="name" name="name" required/>
    </div>
    <div>
      <label for="email"><?php _e('Email', 'clipe'); ?></label>
      <input type="email" id="email" name="email" required/>
    </div>
    <div>
      <label for="address"><?php _e('Address', 'clipe'); ?></label>
      <input type="address" id="address" name="address" required/>
    </div>
    <div>
      <label for="phone"><?php _e('Phone', 'clipe'); ?></label>
      <input type="phone" id="phone" name="phone" required/>
    </div>
    <div>
      <label for="code"><?php _e('Code', 'clipe'); ?></label>
      <input type="code" id="code" name="code"/>
    </div>
    <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>

