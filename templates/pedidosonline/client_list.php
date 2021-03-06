<h1><?php _e('list of Clients', 'clipe'); ?> <a href="<?php echo $pedidosOnline->get_link_page("client_create.php"); ?>"><i class="fa fa-plus"></i></a>
  <a title="<?= __('Add clients in block', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("batch_client_addition.php"); ?>"><i class="fa fa-file"></i></a>
</h1>
<?php if (empty($clients)): ?>
  <div class="alert alert-info">
    <?= sprintf(__('There are no clients, create your first client %s', 'clipe'), sprintf('<a href="%s">here</a>', $createClientUrl)); ?>
  </div>
<?php else: ?>
  <table class="clipe-table">
    <thead>
      <tr>
        <th><?php _e('Client', 'clipe'); ?></th>
        <th><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($clients as $client) {
        ?>
        <tr>
          <td><?php echo $client->Client->name; ?></td>
          <td><a href="<?php echo $pedidosOnline->get_link_page("client_view.php") . '&id=' . $client->Client->id ?>"><i class="fa fa-eye"></i></a></td>
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
