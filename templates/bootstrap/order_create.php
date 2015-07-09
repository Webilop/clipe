<div class="order-edition">
  <div class="clipe-links pull-right">
    <a title="<?= __('Order List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('order_list.php').'&profile='.$_GET['profile']; ?>"><i class="fa fa-list"></i></a>
    <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
  <h1><?php _e('Create Order', 'clipe'); ?></h1>
  <form method="POST">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="headquarters_id"><?php _e('Headquarters', 'clipe'); ?></label>
          <select class="form-control" name="headquarters_id" id="headquarters_id">
            <?php echo $pedidosOnline->get_offices_provider_options(); ?>
          </select>
        </div>
        <div class="form-group">
          <label for="client_notes"><?php _e('Observations', 'clipe'); ?></label>
          <textarea class="form-control" name="client_notes" id="client_notes"></textarea>
        </div>
        <div class="form-group">
          <label for="delivery_date"><?php _e('Delivery Date', 'clipe'); ?></label>
          <select class="form-control" class="form-control client-product-select" id="delivery_date" name="delivery_date" required=""></select>
          <div style="display: none" id="loading-days"><img src="<?php echo get_stylesheet_directory_uri() . '/ajax-loader.gif'; ?>"></div>
        </div>
        <div class="form-group">
          <label for="products"><?php _e('Products', 'clipe'); ?></label>
          <select class="form-control" id="products" name="products">
            <?php echo $products?>
          </select>
          <div>
            <a onclick="clipe_add_product('#product-table', '#products')" class="btn btn-default login-submit pull-right">
              <i class="fa fa-plus"></i>
            </a>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-stripped product-table" id="product-table">
            <thead>
              <tr>
                <th><?php _e('Product', 'clipe'); ?></th>
                <th class="quantity"><?php _e('Quantity', 'clipe'); ?></th>
                <th class="actions"><?php _e('Actions', 'clipe'); ?></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <button class="btn btn-default pull-left login-submit" id="submit">
          <?php _e('Create', 'clipe'); ?>
        </button>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript">//se requiere para el js
  var products = [];
  window.onload = function () {
    document.getElementById("submit").addEventListener("click", validateProducts);
    document.getElementById("headquarters_id").addEventListener("change", getDeliveryDay);
    getDeliveryDay();
  }
  function getDeliveryDay() {
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    var formData = new FormData();
    formData.append('action', 'clipe_delivery_days_options');
    formData.append('client', 0);
    formData.append('profile', 'client');
    formData.append('office', jQuery("#headquarters_id").val());

    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      contentType: false,
      processData: false,
      data: formData,
      beforeSend: function () {
        jQuery("#loading-days").show();
      },
      success: function (response) {
        jQuery("#loading-days").hide();
        jQuery('#delivery_date').html(response);
      }
    });
  }

  function validateProducts() {
    console.log(products);
    console.log(products.length);
    if (products.length == 0) {
      document.getElementById("products").setCustomValidity('<?php echo __('Requires at least one product', 'clipe') ?>');
    }else{
      document.getElementById("products").setCustomValidity('');
    }
  }
</script>
