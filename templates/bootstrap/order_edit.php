<div class="order-edition">
  <div class="clipe-links pull-right">
    <a title="<?= __('Order List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-list"></i></a>
    <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
  <h1><?php _e('Edit Order', 'clipe'); ?></h1>
  <form method="POST">
    <div class="row">
      <div class="col-sm-6">
        <input type="hidden" class="form-control" readonly="" name="headquarters_id" id="headquarters_id" value="<?= $order->HeadquartersProvider->headquarter_id; ?>">
        <?php
        $pedidosOnline->html->create('headquarters_id', array('value'=>$order->Order->address, 'label_text' => 'Headquarter', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false,'readonly'=>true));
        $pedidosOnline->html->create('client_notes', array('value'=>$order->Order->client_notes,'type' => 'textarea', 'label_text' => 'Observations', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false,'readonly'=>!$b_update_notes));
        ?>
        <?php if ($_GET['profile'] == 'provider') { ?>
          <script type="text/javascript">
            jQuery(document).ready(function () {
              jQuery('#delivery_date').daterangepicker(
                      {
                        format: 'YYYY-MM-DD',
                        singleDatePicker: true,
                      }
              );
            });
          </script>
        <?php } ?>
        <div class="form-group">
          <label for="delivery_date"><?php _e('Date', 'clipe'); ?></label>
          <?php if ($_GET['profile'] == 'client' && $b_update) {
            ?>
            <select class="form-control" class="form-control client-product-select" id="delivery_date" name="delivery_date" required="">
              <?php $pedidosOnline->get_delivery_days_options($order->Order->delivery_date, 0, $order->HeadquartersProvider->headquarter_id, 'client'); ?>
            </select>
            <div style="display: none" id="loading-days"><img src="<?php echo get_stylesheet_directory_uri() . '/ajax-loader.gif'; ?>"></div>
          <?php } else { ?>
            <input class="form-control" readonly="" type="date" id="delivery_date" name="delivery_date" required value="<?php echo isset($_POST['delivery_date']) ? $_POST['delivery_date'] : $order->Order->delivery_date; ?>"/>
          <?php } ?>
          <input type="hidden" id="beforeDate" name="beforeDate" value="<?php echo $order->Order->delivery_date; ?>"/>
        </div>
        <div class="form-group">
          <label for="status"><?php _e('Status', 'clipe'); ?></label>
          <?php if ($b_update) { ?>
            <select class="form-control" id="satus" name="status" required="">
              <?php
              foreach ($optionsStatus as $key => $value) {
                $selected = "";
                if ($key == $order->Order->status) {
                  $selected = "selected";
                }
                ?>
                <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
              <?php } ?>
            </select>
          <?php } else { ?>
            <input class="form-control" readonly="" type="text" id="status" name="status" required value="<?php echo $order->Order->status; ?>"/>
          <?php } ?>
        </div>
          <?php
        $pedidosOnline->html->create('products', array('options' => $products, 'type' => 'select', 'label_text' => 'Products', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false));
        ?>
        <div class="form-group">
          <?php if ($b_update_products) { ?>
            <div>
              <a onclick="clipe_add_product('#product-table', '#products')" class="btn btn-default login-submit pull-right">
                <i class="fa fa-plus"></i>
              </a>
            </div>
            <div class="clearfix"></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-stripped product-table" id="product-table">
            <thead>
              <tr>
                <th class="product"><?php _e('Product', 'clipe'); ?></th>
                <th class="quantity"><?php _e('Quantity', 'clipe'); ?></th>
                <th class="actions"><?php _e('Actions', 'clipe'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $productsJS = "[";
              $b_firts = true;
              if (isset($_POST['product_id'])) {
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
                $productsJS.="]";
              } else {
                foreach ($order->Product as $product) {
                  if ($b_firts) {
                    $productsJS.="$product->id";
                    $b_firts = false;
                  } else {
                    $productsJS.=",$product->id";
                  }
                  ?>
                  <tr>
                    <td><?php echo $product->name;
              echo (!$product->active) ? '<span class="error">' . __('this product is no longer available and is automatically deleted when the order is updated', 'clipe') . '</span>' : '';
              ?><input type="hidden" value="<?php echo $product->id; ?>" <?php if ($product->active) { ?>name="product_id[]"<?php } ?>/></td>
                    <td class="quantity"><input class="form-control quantity-input" value="<?php echo $product->OrdersProduct->quantity; ?>" type="number" <?php if ($product->active) { ?>name="quantity[]"<?php } ?>
                      <?php
                      if (!$b_update_products) {
                        echo "readonly";
                      }
                      ?>></td>
                    <td class="actions">
                      <?php if ($b_update_products) { ?>
                        <a onclick="clipe_remove_product(this,<?php echo $product->id; ?>);"><i class="fa fa-trash-o"></i></a>
                      <?php } ?>
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
        <?php if ($b_update): ?>
          <button class="btn btn-default pull-left login-submit" id="submit">
            <?php _e('Update', 'clipe'); ?>
          </button>
        <?php endif; ?>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  var products =<?php echo $productsJS; ?>;
  window.onload = function () {
  }
  function validateProducts() {
    if (products.length == 0) {
      document.getElementById("products").setCustomValidity('<?php echo __('Requires at least one product', 'clipe') ?>');
    } else {
      document.getElementById("products").setCustomValidity('');
    }
  }
</script>
<style type="text/css">
  .error{
    color: red;
    padding-left: 5px;
  }
</style>
