<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pedidosOnline->edit_office($_GET['id']);
  wp_redirect($pedidosOnline->get_link_page('office_list.php'));
}
$office=$pedidosOnline->get_office($_GET['id']);
?>
<div class="clipe-container">
  <h1><?php _e('Edit Product', 'clipe'); ?></h1>
  <form method="POST">
    <div>
      <label for="address"><?php _e('Address', 'clipe'); ?></label>
      <input type="text" id="address" name="address" value="<?php echo $office->addres;?>" required/>
    </div>
    <div>
      <label for="phone"><?php _e('Phone', 'clipe'); ?></label>
      <input type="text" id="phone" name="phone" value="<?php echo $office->phone;?>" required/>
    </div>
    <div>
      <label for="email"><?php _e('Email', 'clipe'); ?></label>
      <input type="email" id="email" name="email" value="<?php echo $office->email;?>" required/>
    </div>
    <div>
      <label for="provider_id"><?php _e('Provider', 'clipe'); ?></label>
      <select id="provider_id" name="provider_id" required disabled>
        <option value="" >----------</option>
        <?php echo $pedidosOnline->get_providers_client_options($office->provider_id);?>
      </select>
    </div>
    <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>

