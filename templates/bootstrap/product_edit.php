<div class="clipe-links pull-right">
  <a title="<?echo __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?echo __('List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('product_list.php');?>"><i class="fa fa-list"></i></a>
  <a title="<?echo __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1>Edit Product</h1>
<form method="POST">
  <div class="row">
    <div class="col-md-6">
      <?php
      $pedidosOnline->html->create('name',array('label_text'=>'Name','class'=>'form-control','div_class'=>'form-group','required'=>true,'value'=>$product->Product->name));
      $pedidosOnline->html->create('measure_type',array('label_text'=>'Measure Type','class'=>'form-control','div_class'=>'form-group','required'=>true,'value'=>$product->Product->measure_type));
      ?>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <?php $pedidosOnline->html->create('category_id',array('type'=>'select','options'=>$categories,'value'=>$product->ProductCategory->id,'label_text'=>'Category','class'=>'form-control','div_class'=>'form-group','options_empty'=>true));   ?>
          </div>
          <div class="col-md-6">
            <?php $pedidosOnline->html->create('category_name',array('label_text'=>'New Category','class'=>'form-control','div_class'=>'form-group')); ?>
          </div>
        </div>
      </div>
      <?php $pedidosOnline->html->create('client_id',array('multiple'=>true,'type'=>'select','options'=>$clients,'value'=>$selectedClients,'label_text'=>'Clients','class'=>'form-control','div_class'=>'form-group'));   ?>
      <button class="btn btn-default pull-left login-submit" id="submit">
        <?php _e('Update', 'clipe'); ?>
      </button>
    </div>
  </div>
</form>

<script type="text/javascript">//se requiere para el js
  window.onload = function () {
    document.getElementById("submit").addEventListener("click", validateCategory);
    document.getElementById("category_name").addEventListener("change", validateCategory);
    document.getElementById("category_id").addEventListener("change", validateCategory);
  }
  function validateCategory() {
    new_category = jQuery.trim(jQuery("#category_name").val());
    var clients = jQuery('#category_id').val();
    if (clients.length == 0 && new_category == "") {
      document.getElementById("category_name").setCustomValidity('<?php echo __('Requires at least one category', 'clipe') ?>');
      return false;
    }
    document.getElementById("category_name").setCustomValidity('<?php echo __('', 'clipe') ?>');
    return true;
  }
</script>
