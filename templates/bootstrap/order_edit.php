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
        <div class="form-group">
          <label for="headquarters"><?php _e('Headquarters', 'clipe'); ?></label>
          <input type="hidden" class="form-control" readonly="" name="headquarters_id" id="headquarters_id" value="<?= $order->HeadquartersProvider->headquarter_id; ?>">
          <input class="form-control" readonly="" name="headquarter" id="headquarters" value="<?= $order->Order->address; ?>">
        </div>
        <div class="form-group">
          <label for="client_notes"><?php _e('Observations', 'clipe'); ?></label>
          <textarea class="form-control" name="<?= $b_update_notes ? 'client_notes': '';?>" id="client_notes" <?= $b_update_notes ? '': 'readonly';?>><?= $order->Order->client_notes; ?></textarea>
        </div>
        <?php if($_GET['profile'] == 'provider'){ ?>
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
          <?php if($_GET['profile'] == 'client' && $b_update ){ ?>
          <select class="form-control" class="form-control client-product-select" id="delivery_date" name="delivery_date" required="">
            <?php $pedidosOnline->get_delivery_days_options($order->Order->delivery_date,0,$order->HeadquartersProvider->headquarter_id,'client');?>
          </select>
          <div style="display: none" id="loading-days"><img src="<?php echo get_stylesheet_directory_uri() . '/ajax-loader.gif'; ?>"></div>
          <?php }else{ ?>
            <input class="form-control" readonly="" type="date" id="delivery_date" name="delivery_date" required value="<?php echo $order->Order->delivery_date; ?>"/>
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
        <div class="form-group">
          <label for="products"><?php _e('Products', 'clipe'); ?></label>
          <select class="form-control" id="products" name="products">
            <?php
            if ($b_provider) {//provider consult
              echo$pedidosOnline->get_client_products_options(array('headquarter_id' => $order->HeadquartersProvider->headquarter_id));
            } else {//client consult
              echo$pedidosOnline->get_client_products_options();
            }
            ?>
          </select>
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
              echo (!$product->active) ? '<span class="error">' . __('this product is no longer available and is automatically deleted when the order is updated', 'clipe') . '</span>' : ''; ?><input type="hidden" value="<?php echo $product->id; ?>" <?php if ($product->active) { ?>name="product_id[]"<?php } ?>/></td>
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
    }else{
      document.getElementById("products").setCustomValidity('');
    }
  }
  }
</script>
<style type="text/css">
.error{
  color: red;
  padding-left: 5px;
}
</style>