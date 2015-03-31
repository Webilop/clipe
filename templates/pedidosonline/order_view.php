<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
$order=$pedidosOnline->get_order($_GET['id']);
//print_r($order->HeadquartersProvider->{0}->provider_id);
?>
<div class="clipe-container">
    <h1><?php _e('Order', 'clipe'); ?></h1>

    <div>
      <label for="headquarters_provider_id"><?php _e('Offices ', 'clipe'); ?></label>
      <span name="headquarters_provider_id" id="headquarters_provider_id">
        <?php echo $order->Order->address?>
      </span>
    </div>
    <div>
      <label for="status"><?php _e('Status ', 'clipe'); ?></label>
      <span name="status" id="status">
        <?php echo $order->Order->status?>
      </span>
    </div>
    <div>
      <label for="date"><?php _e('Date', 'clipe'); ?></label>
      <input type="date" id="date" name="date" required value="<?php echo $order->Order->delivery_date;?>"/>
    </div>
    <table class="clipe-table" id="product-table">
      <thead>
        <tr>
          <th><?php _e('Product', 'clipe'); ?></th>
          <th><?php _e('Quantity', 'clipe'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order->Product as $product) {
            ?>
        <tr>
          <td><?php echo $product->name;?><input type="hidden" value="<?php echo $product->id;?>" name="product_id[]"/></td>
          <td><span ><?php echo $product->OrdersProduct->quantity;?></span></td>
        </tr>
        <?php
        }?>
      </tbody>
    </table>

    <div class="clipe-links">
      <a href="<?php echo $pedidosOnline->get_link_page('order_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
      <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    </div>
    <?php
  ?>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

