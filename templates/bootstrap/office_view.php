<div class="clipe-links pull-right">
  <a title="<?echo __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <?php if (in_array('client', $user->permissions)): ?>
    <a title="<?echo __('Headquarter List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('office_list.php') . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-list"></i></a>
    <a title="<?echo __('Edit', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('office_edit.php') . '&id=' . $order->Headquarters->id.'&profile='.$_GET['profile']; ?>"><i class="fa fa-edit"></i></a>
  <?php endif; ?>
  <a title="<?echo __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>

<h1><?php _e('Headquarter', 'clipe'); ?></h1>

<div class="details">
  <div class="row">
    <div class="col-md-4">
      <label><?php _e('Address', 'clipe'); ?></label>
      <div><?php echo $order->Headquarters->address; ?></div>
    </div>
    <div class="col-md-4">
      <label><?php _e('Phone', 'clipe'); ?></label>
      <div><?php echo $order->Headquarters->phone; ?></div>
    </div>
    <div class="col-md-4">
      <label><?php _e('Email', 'clipe'); ?></label>
      <div><?php echo $order->Headquarters->email; ?></div>
    </div>
  </div>
</div>

<h3><?= __('Orders', 'clipe'); ?></h3>
<div class="table-responsive">
  <table class="table table-stripped">
    <thead>
      <tr>
        <th><?php _e('ID', 'clipe'); ?></th>
        <th><?php _e('Status', 'clipe'); ?></th>
        <th><?php _e('Delivery Date', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($orders as $order) {
        ?>
        <tr>
          <td><?php echo $order->Order->id; ?></td>
          <td><?php echo $order->Order->status; ?></td>
          <td><?php echo $order->Order->delivery_date; ?></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
