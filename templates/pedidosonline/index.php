<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);

$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);
//print_r($user->Provider->id);

get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Index', 'clipe'); ?></h1>

  <h3><?php _e('Section General', 'clipe'); ?></h3>
  <p><a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><?php _e('Logout', 'clipe'); ?></a></p>

  <?php if (in_array('provider',$user->permissions)) { ?><h3><?php _e('Section Provider', 'clipe'); ?></h3>
    <p><a href="<?php echo $pedidosOnline->get_link_page('provider_edit.php') . '&id=' . $userId; ?>"><?php _e('Account', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><?php _e('List of Client', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('product_list.php'); ?>"><?php _e('Product List', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><?php _e('Categories List', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('order_list.php').'&profile=provider'; ?>"><?php _e('Orders', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('reports.php'); ?>"><?php _e('Reports', 'clipe'); ?></a></p>
  <?php } ?>

  <?php if (in_array( 'client',$user->permissions)) { ?><h3><?php _e('Section Client', 'clipe'); ?></h3>
    <p><a href="<?php echo $pedidosOnline->get_link_page('client_edit.php') . '&id=' . $userId; ?>"><?php _e('Account', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('order_list.php').'&profile=client'; ?>"><?php _e('Orders', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('office_list.php').'&profile=client'; ?>"><?php _e('Offices', 'clipe'); ?></a></p>
    <?php /*<p><a href="<?php echo $pedidosOnline->get_link_page('supplier_list.php'); ?>"><?php _e('Supplier List', 'clipe'); ?></a></p>*/?>
  <?php } ?>


  <?php
  $profile=in_array( 'client',$user->permissions) ? 'client' : 'provider';
  $result = $pedidosOnline->get_orders(array('profile' => $profile, 'limit' => 5, 'order_by' => 'delivery_date', 'order_direction' => 'DESC'));
  $nextOrders = isset($result->Orders) ? $result->Orders: array();
  ?>
  <div class="page-heading">
    <h3><?php _e('Last Orders', 'clipe'); ?></h3>
  </div>
  <?php if(empty($nextOrders)): ?>
    <div class="alert alert-info"><?= __('There are not orders for next days', 'clipe'); ?></div>
  <?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th><?php _e('Delivery Date', 'clipe'); ?></th>
          <th><?php _e('Address', 'clipe'); ?></th>
          <th><?php _e('Status', 'clipe'); ?></th>
          <th class="actions"><?php _e('Actions', 'clipe'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($nextOrders as $order): ?>
        <tr>
          <td><?= date_format(date_create_from_format('Y-m-d', $order->Order->delivery_date), 'M d, Y'); ?></td>
          <td><?= $order->Order->address; ?></td>
          <td><?= $order->Order->status; ?></td>
          <td class="actions">
            <input type="hidden" id='id' value="<?php echo $order->Order->id ?>" />
            <a title="<?= __('View', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("order_view.php") . '&id=' . $order->Order->id . '&profile=' . $profile; ?>"><i class="fa fa-eye"></i></a>
            <a title="<?= __('Edit', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("order_edit.php") . '&id=' . $order->Order->id . '&profile=' . $profile; ?>"><i class="fa fa-pencil-square-o"></i></a>
            <?php if ($profile == 'client') { ?>
              <a title="<?= __('Cancel', 'clipe'); ?>" class="cancel" href="<?php echo $pedidosOnline->get_link_page("order_cancel.php") . '&id=' . $order->Order->id . '&profile=' . $profile; ?>"><i class="fa fa-times"></i></a>
            <?php } ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>

</div>
<?php
get_sidebar('clipe');
get_footer();
?>
