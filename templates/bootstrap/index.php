<div class="clipe-links pull-right">
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Dashboard', 'clipe'); ?></h1>

<div class="dashboard-actions">
  <?php if (in_array('provider',$user->permissions)): ?>
  <a class="btn btn-default" href="<?php echo $pedidosOnline->get_link_page('provider_edit.php') . '&id=' . $userId; ?>">
    <i class="fa fa-male"></i>
    <?php _e('Account', 'clipe'); ?>
  </a>
  <a class="btn btn-default" href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>">
    <i class="fa fa-group"></i>
    <?php _e('Clients', 'clipe'); ?>
  </a>
  <a class="btn btn-default" href="<?php echo $pedidosOnline->get_link_page('product_list.php'); ?>">
    <i class="fa fa-barcode"></i>
    <?php _e('Products', 'clipe'); ?>
  </a>
  <!--<a href="<?php /*echo $pedidosOnline->get_link_page('category_list.php'); */?>">
    <i class="fa fa-barcode"></i>
    <?php /*_e('Categories List', 'clipe'); */?>
  </a>-->
  <a class="btn btn-default" href="<?php echo $pedidosOnline->get_link_page('order_list.php').'&profile=provider'; ?>">
    <i class="fa fa-list-alt"></i>
    <?php _e('Orders', 'clipe'); ?>
  </a>
  <a class="btn btn-default" href="<?php echo $pedidosOnline->get_link_page('reports.php').'&profile=provider'; ?>">
    <i class="fa fa-briefcase"></i>
    <?php _e('Reports', 'clipe'); ?>
  </a>
  <?php endif; ?>

  <?php if (in_array( 'client',$user->permissions)): ?>
  <a class="btn btn-default" href="<?php echo $pedidosOnline->get_link_page('client_edit.php') . '&id=' . $userId; ?>">
    <i class="fa fa-male"></i>
    <?php _e('Account', 'clipe'); ?>
  </a>
  <a class="btn btn-default" href="<?php echo $pedidosOnline->get_link_page('order_list.php').'&profile=client'; ?>">
    <i class="fa fa-list-alt"></i>
    <?php _e('Orders', 'clipe'); ?>
  </a>
  <a class="btn btn-default" href="<?php echo $pedidosOnline->get_link_page('office_list.php').'&profile=client'; ?>">
    <i class="fa fa-building-o"></i>
    <?php _e('Offices', 'clipe'); ?>
  </a>
  <?php endif; ?>
</div>

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
        <td><?= $status[$order->Order->status]; ?></td>
        <td class="actions">
          <input type="hidden" id='id' value="<?php echo $order->Order->id ?>" />
          <a title="<?= __('View', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("order_view.php") . '&id=' . $order->Order->id . '&profile=' . $profile; ?>"><i class="fa fa-eye"></i></a>
          <a title="<?= __('Edit', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("order_edit.php") . '&id=' . $order->Order->id . '&profile=' . $profile; ?>"><i class="fa fa-pencil-square-o"></i></a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>
