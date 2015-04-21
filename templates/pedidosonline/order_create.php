<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->create_order();
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__($result->data->message, 'clipe'), 'success');
  } elseif (isset($result->status) && $result->status == "fail") {
    $message = array_values(get_object_vars($result->data));
    $pedidosOnline->add_flash_message(__($message[0][0], 'clipe'));
  } else {
    $pedidosOnline->add_flash_message($result);
  }
  wp_redirect($pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']);
  exit();
}

get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Create Order', 'clipe'); ?></h1>
  <form method="POST">
    <div>
      <label for="headquarters_provider_id"><?php _e('Offices ', 'clipe'); ?></label>
      <select name="headquarters_provider_id" id="headquarters_provider_id">
<?php echo $pedidosOnline->get_offices_provider_options(); ?>
      </select>
    </div>
    <div>
      <label for="date"><?php _e('Date', 'clipe'); ?></label>
      <input type="date" id="date" name="date" required/>
    </div>
    <div>
      <label for="products"><?php _e('Products', 'clipe'); ?></label>
      <select id="products" name="products">
<?php echo $pedidosOnline->get_client_products_options(); ?>
      </select>
      <a onclick="clipe_add_product('#product-table', '#products')"><i class="fa fa-plus"></i></a>
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
      </tbody>
    </table>
    <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<script type="text/javascript">//se requiere para el js 
  var products = [];
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

