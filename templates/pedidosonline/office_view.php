<h1><?php _e('Office', 'clipe'); ?></h1>

<div>
  <label for="address"><?php _e('Address', 'clipe'); ?></label>
  <input type="text" id="address" name="address" value="<?php echo $office->Headquarters->address; ?>" required/>
</div>
<div>
  <label for="phone"><?php _e('Phone', 'clipe'); ?></label>
  <input type="text" id="phone" name="phone" value="<?php echo $office->Headquarters->phone; ?>" required/>
</div>
<div>
  <label for="email"><?php _e('Email', 'clipe'); ?></label>
  <input type="email" id="email" name="email" value="<?php echo $office->Headquarters->email; ?>" required/>
</div>
<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('office_list.php') . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
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
