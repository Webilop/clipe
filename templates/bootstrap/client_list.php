<div class="clipe-links pull-right">
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Clients', 'clipe'); ?> <a title="<?= __('Add Client', 'clipe'); ?>" href="<?= $createClientUrl; ?>"><i class="fa fa-plus"></i></a>
  <a title="<?= __('Add clients in block', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("batch_client_addition.php"); ?>"><i class="fa fa-file"></i></a></h1>
<?php if (empty($clients)): ?>
  <div class="alert alert-info">
    <?= sprintf(__('There are no clients, create your first client %s', 'clipe'), sprintf('<a href="%s">', $createClientUrl) . __('here', 'clipe') . '</a>'); ?>
  </div>
<?php else: ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th><?php _e('Client', 'clipe'); ?></th>
        <th class="actions"><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($clients as $client) {
        ?>
        <tr>
          <td><?php echo $client->Client->name; ?></td>
          <td class="actions">
            <a href="<?php echo $pedidosOnline->get_link_page("client_view.php") . '&id=' . $client->Client->id ?>"><i class="fa fa-eye"></i></a>
            <a class="delete" title="<?= __('Delete', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("client_delete.php") . '&id=' . $client->Client->id?>"><i class="fa fa-trash-o"></i></a>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
  <div class="text-center">
    <?php
    $pedidosOnline->print_pagination($result->rows,$numberRows);
    ?>
  </div>
<?php endif; ?>
