<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->edit_order($_GET['id']);
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__($result->data->message, 'clipe'), 'success');
    wp_redirect($pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']);
    exit();
  } elseif (isset($result->status) && $result->status == "fail") {
    $message = array_values(get_object_vars($result->data));
    $pedidosOnline->add_flash_message(__($message[0][0], 'clipe'));
  } else {
    $pedidosOnline->add_flash_message($result);
  }  
}
get_header();
$order = $pedidosOnline->get_order($_GET['id']);
$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);
$optionsStatus = array();
$b_update = false;
$b_provider = false;
if (in_array('provider', $user->permissions)) {
  $optionsStatus = array("Pendiente", "Cancelado", "En progreso", "Completado");
  $b_update = true;
  $b_provider = true;
} else {
  if ($order->Order->status == "Pendiente") {
    $optionsStatus = array("Pendiente", "Cancelado");
    $b_update = true;
  }
}
?>
<div class="clipe-container">
  <h1><?php _e('Edit Order', 'clipe'); ?></h1>
  <form method="POST">
    <div>
      <label for="headquarters_provider_id"><?php _e('Offices ', 'clipe'); ?></label>
      <span name="headquarters_provider_id" id="headquarters_provider_id">
        <?php echo $order->Order->address ?>
      </span>
    </div>
    <?php
    if ($_GET['profile'] == 'provider') {
      wp_enqueue_script('moment', "//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js", array('jquery'));
      wp_enqueue_script('daterangepicker', "//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js", array('jquery'));
      wp_enqueue_style('daterangepicker', "//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css");
      ?>
      <script type="text/javascript">
        jQuery(document).ready(function () {
          jQuery('#date').daterangepicker(
                  {
                    format: 'YYYY-MM-DD',
                    singleDatePicker: true,
                  }
          );
        });
      </script>
      <?php
    }
    ?>
    <div>
      <label for="date"><?php _e('Date', 'clipe'); ?></label>
      <input readonly="" type="date" id="date" name="date" required value="<?php echo $order->Order->delivery_date; ?>"/>
      <input type="hidden" id="date" name="beforeDate" value="<?php echo $order->Order->delivery_date; ?>"/>
    </div>
    <div>
      <label for="status"><?php _e('Status', 'clipe'); ?></label>
      <?php if ($b_update) { ?>
        <select id="satus" name="status" required="">
          <?php
          foreach ($optionsStatus as $value) {
            $selected = "";
            if ($value == $order->Order->status) {
              $selected = "selected";
            }
            ?>
            <option <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
          <?php } ?>
        </select>
      <?php } else { ?>
        <input readonly="" type="text" id="status" name="status" required value="<?php echo $order->Order->status; ?>"/>
      <?php } ?>
    </div>
    <div>
      <label for="products"><?php _e('Products', 'clipe'); ?></label>
      <select id="products" name="products">
        <?php
        if ($b_provider) {//provider consult
          echo$pedidosOnline->get_client_products_options(array('headquarter_id' => $order->HeadquartersProvider->headquarter_id));
        } else {//client consult
          echo$pedidosOnline->get_client_products_options();
        }
        ?>
      </select>
      <?php if ($b_update) { ?>
        <a onclick="clipe_add_product('#product-table', '#products')"><i class="fa fa-plus"></i></a>
      <?php } ?>
    </div>
    <table class="clipe-table" id="product-table">
      <thead>
        <tr>
          <th><?php _e('Product', 'clipe'); ?></th>
          <th><?php _e('Quantity', 'clipe'); ?></th>
          <th><?php _e('Actions', 'clipe'); ?></th>
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
            <td><?php echo $product->name; ?><input type="hidden" value="<?php echo $product->id; ?>" name="product_id[]"/></td>
            <td><input value="<?php echo $product->OrdersProduct->quantity; ?>" type="number" name="quantity[]"/ <?php
              if (!$b_update) {
                echo "readonly";
              }
              ?>></td>
            <td>
              <?php if ($b_update) { ?>
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
    <?php if ($b_update) { ?>
      <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="" id="submit" name="submit">
    <?php } ?>
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>

<script type="text/javascript">
  var products =<?php echo $productsJS; ?>;
  window.onload = function () {
    document.getElementById("submit").addEventListener("click", validateProducts);
  }
  function validateProducts() {
    if (products.length == 0) {
      document.getElementById("products").setCustomValidity('<?php echo __('Requires at least one product', 'clipe') ?>');
    }
  }
</script>
<?php
get_sidebar('clipe');
get_footer();
?>

