<div class="clipe-links pull-right">
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Orders', 'clipe'); ?>
  <?php if (in_array('client', $user->permissions)): ?>
    <a title="<?= __('Add Order', 'clipe'); ?>" href="<?= $createOrderUrl; ?>"><i class="fa fa-plus"></i></a>
  <?php endif; ?>
</h1>
<?php if (empty($orders)): ?>
  <div class="alert alert-info">
    <?php
    if (in_array('client', $user->permissions)):
      echo sprintf(__('There are no orders, create your first order %s', 'clipe'), sprintf('<a href="%s">', $createOrderUrl) . __('here', 'clipe') . '</a>');
    else:
      echo sprintf(__('There are no orders, invite your clients to make their first orders', 'clipe'), sprintf('<a href="%s">', $createOrderUrl) . __('here', 'clipe') . '</a>');
    endif;
    ?>
  </div>
<?php else: ?>
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
      <?php
      foreach ($orders as $order) {
        ?>
        <tr>
          <td><?= date_format(date_create_from_format('Y-m-d', $order->Order->delivery_date), 'M d, Y'); ?></td>
          <td><?= $order->Order->address; ?></td>
          <td><?= $status[$order->Order->status]; ?></td>
          <td class="actions">
            <input type="hidden" id='id' value="<?php echo $order->Order->id ?>" />
            <a title="<?= __('View', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("order_view.php") . '&id=' . $order->Order->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-eye"></i></a>
            <a title="<?= __('Edit', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("order_edit.php") . '&id=' . $order->Order->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-pencil-square-o"></i></a>
            <?php if ($_GET['profile'] == 'client') { ?>
              <a title="<?= __('Cancel', 'clipe'); ?>" class="cancel" href="<?php echo $pedidosOnline->get_link_page("order_cancel.php") . '&id=' . $order->Order->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-times"></i></a>
            <?php } ?>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
  <div class="text-center">
    <?php
    $pedidosOnline->print_pagination($result->rows, $numberRows);
    ?>
  </div>
<?php endif; ?>
