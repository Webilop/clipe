<div class="clipe-links pull-right">
  <a title="<?= __('Product List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('product_list.php');?>"><i class="fa fa-list"></i></a>
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?= __('Create Product', 'clipe'); ?></h1>
<form method="POST">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="name"><?php _e('Name', 'clipe'); ?></label>
        <input class="form-control" type="text" id="name" name="name" required/>
      </div>
      <div class="form-group">
        <label for="measure_type"><?php _e('Measure Type', 'clipe'); ?></label>
        <input class="form-control" type="text" id="measure_type" name="measure_type" required/>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="category_id"><?php _e('Category', 'clipe'); ?></label>
            <select class="form-control" id="category_id" name="category_id">
              <option value=""></option>
              <?php echo $pedidosOnline->get_categories_options(); ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="category_name"><?php _e('New Category', 'clipe'); ?></label>
            <input class="form-control" type="text" id="category_name" name="category_name"/>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="client_id"><?php _e('Clients', 'clipe'); ?></label>
        <select class="form-control" id="client_id" name="client_id[]" multiple>
          <?php echo $pedidosOnline->get_clients_options(); ?>
        </select>
      </div>
      <button class="btn btn-default pull-left login-submit" id="submit">
        <?php _e('Create', 'clipe'); ?>
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
    new_category=jQuery.trim(jQuery("#category_name").val());
    var clients = jQuery('#category_id').val(); 
    if (clients.length == 0 && new_category=="") {
      document.getElementById("category_name").setCustomValidity('<?php echo __('Requires at least one category', 'clipe') ?>');
      return false;
    }
    document.getElementById("category_name").setCustomValidity('');
    return true;
  }
</script>
