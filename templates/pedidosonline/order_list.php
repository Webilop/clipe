<h1><?php _e('Order List', 'clipe'); ?>  <a href="<?php echo $pedidosOnline->get_link_page("order_create.php") . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-plus"></i></a></h1>
<?php if (empty($orders)): ?>
  <div class="alert alert-info">
    <?php
    if (in_array('client', $user->permissions)):
      echo sprintf(__('There are no orders, create your first order %s', 'clipe'), sprintf('<a href="%s">here</a>', $createOrderUrl));
    else:
      echo sprintf(__('There are no orders, invite your clients to make their first orders', 'clipe'), sprintf('<a href="%s">here</a>', $createOrderUrl));
    endif;
    ?>
  </div>
<?php else: ?>
  <table class="clipe-table">
    <thead>
      <tr>
        <th><?php _e('Offices', 'clipe'); ?></th>
        <th><?php _e('Created', 'clipe'); ?></th>
        <th><?php _e('Status', 'clipe'); ?></th>
        <th><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($orders as $order) {
        ?>
        <tr>
          <td><?php echo $order->Order->address; ?></td>
          <td><?php echo $order->Order->created; ?></td>
          <td><?php echo $order->Order->status; ?></td>
          <td class="actions">
            <input type="hidden" id='id' value="<?php echo $order->Order->id ?>" />
            <a href="<?php echo $pedidosOnline->get_link_page("order_view.php") . '&id=' . $order->Order->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-eye"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("order_edit.php") . '&id=' . $order->Order->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-pencil-square-o"></i></a>
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
<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
