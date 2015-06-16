<h1>list of customer</h1>
<table class="clipe-table">
  <thead>
    <tr>
      <th><?php _e('Suppliers', 'clipe'); ?></th>
      <th><?php _e('Actions', 'clipe'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($suppliers as $supplier) {
      ?>
      <tr>
        <td><?php //echo $client->Client->name;  ?></td>
        <td><a href="<?php //echo $pedidosOnline->get_link_page("client_view.php").'&id='.$client->Client->id ?>"><i class="fa fa-eye"></i></a></td>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>
<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
