<div class="clipe-links pull-right">
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Headquarters List', 'clipe'); ?>  <a title="<?= __("Add Headquarter"); ?>" href="<?php echo $pedidosOnline->get_link_page("office_create.php"). '&profile=' . $_GET['profile']; ?>"><i class="fa fa-plus"></i></a></h1>
<div class="table-responsive">
  <table class="table table-stripped">
    <thead>
      <tr>
        <th><?php _e('Headquarters', 'clipe'); ?></th>
        <th><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($offices as $office) {
        ?>
        <tr>
          <td><?= $office->Headquarters->address; ?></td>
          <td class="actions">
            <a title="<?= __('View', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("office_view.php") . '&id=' . $office->Headquarters->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-eye"></i></a>
            <a title="<?= __('Edit', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("office_edit.php") . '&id=' . $office->Headquarters->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-pencil-square-o"></i></a>
            <a class="delete" title="<?= __('Delete', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("office_delete.php") . '&id=' . $office->Headquarters->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-trash-o"></i></a>
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
</div>
