<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pedidosOnline->edit_order($_GET['id']);
  wp_redirect($pedidosOnline->get_link_page('order_list.php'));
}
$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);
if (in_array('provider',$user->permissions)) {
  
}
get_header();
$order = $pedidosOnline->get_order($_GET['id']);
print_r($order);
?>
<div class="clipe-container">
  <h1><?php _e('Edit Office', 'clipe'); ?></h1>
  <form method="POST">
    <div>
      <label for="headquarters_provider_id"><?php _e('Offices ', 'clipe'); ?></label>
      <span name="headquarters_provider_id" id="headquarters_provider_id">
        <?php echo $order->Order->address?>
      </span>
    </div>
    <div>
      <label for="date"><?php _e('Date', 'clipe'); ?></label>
      <input type="date" id="date" name="date" required value="<?php echo $order->Order->delivery_date;?>"/>
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
        <?php foreach ($order->Product as $product) {
            ?>
        <tr>
          <td><?php echo $product->name;?><input type="hidden" value="<?php echo $product->id;?>" name="product_id[]"/></td>
          <td><input value="<?php echo $product->OrdersProduct->quantity;?>" type="number" name="quantity[]"/></td>
          <td>
            <a onclick="clipe_remove_product(this);"><i class="fa fa-trash-o"></i></a>
          </td>
        </tr>
        <?php
        }?>
      </tbody>
    </table>
    <?php if($order->Order->status=='Pendiente'){?>
    <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="" id="submit" name="submit">
    <?php }?>
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('order_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

