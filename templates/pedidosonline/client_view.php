<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);

get_header();
?>
<div class="clipe-container">
  <?php
  if (isset($_GET['id'])) {
    $client = $pedidosOnline->get_client($_GET['id']);
    ?>
    <h1><?php _e('Client', 'clipe'); ?> => <?php echo $client->Client->name; ?></h1>


    <?php
    if (isset($client->Headquarters)) {

    }
    ?>
    <table class="clipe-table">
      <thead>
        <tr>
          <th><?php _e('Office', 'clipe'); ?></th>
          <th><?php _e('Address', 'clipe'); ?></th>
          <th><?php _e('Phone', 'clipe'); ?></th>
          <th><?php _e('Email', 'clipe'); ?></th>
          <th><?php _e('Actions', 'clipe'); ?></th>
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
            <td><?php echo $office->email; ?></td>
            <td class="actions">
              <a title="<?= __('View', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("office_view.php").'&id='.$office->id; ?>"><i class="fa fa-eye"></i></a>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>

    <div class="clipe-links">
      <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
      <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
      <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
    </div>
    <?php
  } else {
    ?>
    <h1><?php _e('Error', 'clipe') ?></h1>
    <?php
  }
  ?>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

