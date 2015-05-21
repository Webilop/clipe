<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->edit_category($_GET['id']);
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__('Category edited successfully', 'clipe'), 'success');
  }
  else {
    $pedidosOnline->add_flash_message($result);
  }
  wp_redirect($pedidosOnline->get_link_page('category_list.php'));
  exit();
}
$category=$pedidosOnline->get_category($_GET['id']);

get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Edit Product', 'clipe'); ?></h1>
  <form method="POST">
    <div>
      <label for="name"><?php _e('Name', 'clipe'); ?></label>
      <input type="name" id="name" name="name" required value="<?php echo $category->name;?>"/>
    </div>
    <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

