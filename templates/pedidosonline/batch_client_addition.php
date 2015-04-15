<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //show message is uploading.exit;
  print_r($_FILES);exit;
  $result = $pedidosOnline->addition_file_of_clients();
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__($result->data->message, 'clipe'), 'success');
  }
  else {
    $pedidosOnline->add_flash_message($result);
  }
}
get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Batch Client Addition', 'clipe'); ?></h1>
  <form method="POST" enctype="multipart/form-data">
    <div>
      <label for="address"><?php _e('File', 'clipe'); ?></label>
      <input type="file" id="file" name="file" required/>
    </div>    
    <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" >
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

