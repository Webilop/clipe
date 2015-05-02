<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //show message is uploading.exit;
  $result = $pedidosOnline->addition_file_of_products();
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__($result->message, 'clipe'), 'success');
  } else {
    foreach ($result->errors as $error) {
      $pedidosOnline->add_flash_message($error);
    }
  }
}
get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Batch Product Addition', 'clipe'); ?></h1>
  <form method="POST" enctype="multipart/form-data">
    <div>
      <label for="address"><?php _e('File', 'clipe'); ?> <span title="<?php echo __('supported file: xls, xlsx, xlsm, csv or ods.','clipe');?>"><i class="fa fa-info-circle"></i></span></label>
      <input type="file" id="file" name="file" required/>
    </div>    
    <input type="submit" value="<?php _e('Upload', 'clipe'); ?>" class="" id="submit" >
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('product_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
  <script type="text/javascript">
    window.onload = function () {
      document.getElementById("file").onchange = requiredFile;
    }
    
    function requiredFile(){
      ext=jQuery('#file').val().split('.').pop().toLowerCase();
      if(jQuery.inArray(ext, ['xls','xlsx','xlsm','csv','ods']) == -1) {
          document.getElementById("file").setCustomValidity("<?php _e("the file is not supported, check it xls, xlsx, xlsm, csv or ods.", "clipe"); ?>");
      }else{
        document.getElementById("file").setCustomValidity('');
      }      
    }

  </script>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

