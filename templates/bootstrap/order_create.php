<div class="order-edition">
  <div class="clipe-links pull-right">
    <a title="<?= __('Order List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-list"></i></a>
    <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
  <h1><?php _e('Create Order', 'clipe'); ?></h1>
  <form method="POST">
    <div class="row">
      <div class="col-sm-6">
        <?php
        $pedidosOnline->html->create('headquarters_id', array('options' => $headquarters, 'type' => 'select', 'label_text' => 'Headquarters', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => true));
        $pedidosOnline->html->create('client_notes', array('type' => 'textarea', 'label_text' => 'Observations', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false));
        ?>
        <div class="form-group">
          <label for="delivery_date"><?php _e('Delivery Date', 'clipe'); ?></label>
          <select class="form-control" class="form-control client-product-select" id="delivery_date" name="delivery_date" ></select>
          <div style="display: none" id="loading-days"><img src="<?php echo get_stylesheet_directory_uri() . '/ajax-loader.gif'; ?>"></div>
        </div>
        <?php
        $pedidosOnline->html->create('products', array('options' => $products, 'type' => 'select', 'label_text' => 'Products', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false));
        ?>
        <div class="form-group">
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
              <?php
              $productsJS = "[";
              if (isset($_POST['product_id'])) {
                $b_firts = true;
                $quantities = $_POST['quantity'];
                foreach ($_POST['product_id'] as $key => $product) {
                  if ($b_firts) {
                    $productsJS.=$product;
                    $b_firts = false;
                  } else {
                    $productsJS.=",$product";
                  }
                  ?>
                  <tr>
                    <td><?php echo $products[$product];
                  ?><input type="hidden" value="<?php echo $product; ?>" name="product_id[]"/></td>
                    <td class="quantity"><input class="form-control quantity-input" value="<?php echo $quantities[$key]; ?>" type="number" name="quantity[]"></td>
                    <td class="actions">
                      <a onclick="clipe_remove_product(this,<?php echo $product; ?>);"><i class="fa fa-trash-o"></i></a>
                    </td>
                  </tr>
                  <?php
                }
              }
              $productsJS.="]";
              ?>
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
  var products = <?php echo $productsJS; ?>;
  var beforeDate = '<?php
          if (isset($_POST['delivery_date'])) {
            echo $_POST['delivery_date'];
          } else {
            echo '';
          }
          ?>';
  window.onload = function () {
    document.getElementById("submit").addEventListener("click", validateProducts);
    document.getElementById("headquarters_id").addEventListener("change", deletePostBeforegetDeliveryDay);
    getDeliveryDay();
  }
  function deletePostBeforegetDeliveryDay() {
    if (beforeDate != '') {
      beforeDate = "";
    }
    getDeliveryDay();
  }

  function getDeliveryDay() {
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    var formData = new FormData();
    formData.append('action', 'clipe_delivery_days_options');
    formData.append('client', 0);
    formData.append('profile', 'client');
    formData.append('office', jQuery("#headquarters_id").val());
    if (beforeDate != "") {
      formData.append('beforeDate', beforeDate);
    }

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
    } else {
      document.getElementById("products").setCustomValidity('');
    }
  }
</script>
