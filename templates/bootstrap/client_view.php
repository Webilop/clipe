<div class="clipe-links pull-right">
  <a title="<?echo __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?echo __('Clients', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-list"></i></a>
  <a title="<?echo __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>

<h1><?php echo $client->Client->name; ?></h1>

<h3><?= __('Headquarters', 'clipe'); ?></h3>
<?php if (!empty($client->Headquarters)): ?>
<table class="table table-striped">
  <thead>
    <tr>
      <th><?php _e('Code', 'clipe'); ?></th>
      <th><?php _e('Address', 'clipe'); ?></th>
      <th><?php _e('Phone', 'clipe'); ?></th>
      <th class="actions"><?php _e('Actions', 'clipe'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $offices = $client->Headquarters;
    foreach ($offices as $office) {
      ?>
      <tr>
        <td><?php echo isset($office->code)? $office->code: ''; ?></td>
        <td><?php echo $office->address; ?></td>
        <td><?php echo $office->phone; ?></td>
        <td class="actions">
          <a title="<?= __('View', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("office_view.php").'&id='.$office->id.'&profile=provider'; ?>"><i class="fa fa-eye"></i></a>
          <a href="<?php echo $pedidosOnline->get_link_page("delivery_days_edit.php") . '&client=' . $client->Client->id . '&office=' . $office->id ?>"><i class="fa fa-edit"></i></a>
          <a class="delete" title="<?= __('Delete', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("office_delete.php") . '&id=' . $office->id . '&profile=provider'.'&client_id=' . $client->Client->id; ?>"><i class="fa fa-trash-o"></i></a>
        </td>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>
<?php else: ?>
<div class="well">
  <?= __('There are no Headquarters', 'clipe'); ?>
</div>
<?php endif; ?>
