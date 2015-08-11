<div class="clipe-links pull-right">
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Batch Client Addition', 'clipe'); ?></h1>
<form method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="address"><?php _e('File', 'clipe'); ?> <span title="<?php echo __('supported file: xls, xlsx, xlsm, csv or ods.','clipe');?>"><i class="fa fa-info-circle"></i></span></label>
    <input type="file" id="file" name="file" required/>
  </div>
  <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
    <?php _e('Upload', 'clipe'); ?>
  </button>
</form>
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
