<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('client');
$active = isset($_GET['page']) ? $_GET['page'] : 1;
$numberRows = 10;
$result = $pedidosOnline->get_offices(array('page' => $active, 'limit' => $numberRows, 'order_by' => 'address'));
$offices = $result->headquarters;
get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Office List', 'clipe'); ?>  <a href="<?php echo $pedidosOnline->get_link_page("office_create.php"). '&profile=' . $_GET['profile']; ?>"><i class="fa fa-plus"></i></a></h1>
  <table class="clipe-table">
    <thead>
      <tr>
        <th><?php _e('Offices', 'clipe'); ?></th>
        <th><?php _e('Created', 'clipe'); ?></th>
        <th><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($offices as $office) {
        ?>
        <tr>
          <td><?php echo $office->Headquarters->address; ?></td>
          <td><?php echo $office->Headquarters->created; ?></td>
          <td class="actions">
            <a href="<?php echo $pedidosOnline->get_link_page("office_view.php") . '&id=' . $office->Headquarters->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-eye"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("office_edit.php") . '&id=' . $office->Headquarters->id . '&profile=' . $_GET['profile']; ?>"><i class="fa fa-pencil-square-o"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("office_delete.php") . '&id=' . $office->Headquarters->id . '&profile=' . $_GET['profile'];?>" class="delete"><i class="fa fa-trash-o"></i></a>
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
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

