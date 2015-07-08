<div class="clipe-links pull-right">
  <a href="<?php echo $pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Order', 'clipe'); ?></h1>

<div class="row">
  <div class="col-md-4">
    <label><?php _e('Offices ', 'clipe'); ?></label>
    <div><?php echo $order->Order->address; ?></div>
  </div>
  <div class="col-md-4">
    <label><?php _e('Status ', 'clipe'); ?></label>
    <div><?php echo $status[$order->Order->status]; ?></div>
  </div>
  <div class="col-md-4">
    <label><?php _e('Date', 'clipe'); ?></label>
    <div><?= date_format(date_create_from_format('Y-m-d', $order->Order->delivery_date), 'M d, Y'); ?></div>
  </div>
</div>

<h3><?= __('Products', 'clipe'); ?></h3>
<table class="table table-stripped" id="product-table">
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
        <td><?php echo $product->name; ?><input type="hidden" value="<?php echo $product->id; ?>" name="product_id[]"/></td>
        <td><span ><?php echo $product->OrdersProduct->quantity; ?></span></td>
      </tr>
    <?php }
    ?>
  </tbody>
</table>
<?php if (count((array) $order->OrderHistory)) {
  ?>
  <h3><?= __('History', 'clipe'); ?></h3>
  <table class="table table-stripped" id="product-table">
    <thead>
      <tr>
        <th><?php _e('Date', 'clipe'); ?></th>
        <th><?php _e('Changes', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($order->OrderHistory as $history) {
        //print_r($history);
        //echo'*********************';
        ?>
        <tr>
          <td><?php echo $history->created; ?></td>
          <td>
            <ul style="list-style-type:disc">
              <?php
              $fields = json_decode($history->fields);
              $old_values = json_decode($history->old_values);
              $new_values = json_decode($history->new_values);
              foreach ($fields as $key => $field) {
                $s1 = "";
                $s2 = "";
                $s3 = "";
                $b_print=true;
                switch ($field) {
                  case 'status':
                    $message = "the status was changed, before %s => after %s.";
                    $s1 = isset($old_values[$key]) ? $old_values[$key] : '';
                    if(empty($s1)){
                      $b_print=false;
                      $message = "The order has been created with a status %s%s";
                    }else{
                      $s1=$status[$s1];
                    }
                    $s2 = isset($new_values[$key]) ? $new_values[$key] : '';
                    if(!empty($s2)){
                      $s2=$status[$s2];
                    }
                    break;
                  case 'delivery_date':
                    $message = "the delivery date was changed, before %s => after %s.";
                    $s1 = isset($old_values[$key]) ? $old_values[$key] : '';
                    if(empty($s1)){
                      $message = "The order has been created with a delivery date %s%s";
                    }
                    $s2 = isset($new_values[$key]) ? $new_values[$key] : '';
                    break;
                  case 'products':
                    foreach ($old_values[$key] as $key2 => $old_value) {
                      if (isset($old_value[0]) && isset($new_values[$key][$key2][0])) {
                        $message = "the %s product was changed , before %s => after %s.";
                        $s1 = $old_value[0];
                        $s2 = $old_value[1];
                        $s3 = $new_values[$key][$key2][1];
                      } elseif (!isset($old_value[0]) && isset($new_values[$key][$key2][0])) {
                        $message = "The %s product was added, amount %s.";
                        $s1 = $new_values[$key][$key2][0];
                        $s2 = $new_values[$key][$key2][1];
                      } elseif (isset($old_value[0]) && !isset($new_values[$key][$key2][0])) {
                        $message = "the %s product was deleted.";
                        $s1 = $old_value[0];
                        $s2 = '';
                      }
                      echo '<li>' . sprintf($message, $s1, $s2, $s3) . '</li>';
                    }
                    $b_print=false;
                    break;

                  default:
                    $message = "this type of change is not recognized";
                    $s1 = '';
                    $s2 = '';
                    break;
                }
                if($b_print){
                  echo '<li>' . sprintf($message, $s1, $s2, $s3) . '</li>';
                }
              }
              ?>
            </ul>
          </td>
        </tr>
      <?php }
      ?>
    </tbody>
  </table>
<?php } ?>
