<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
if (isset($_GET['id'])) {
  $client = $pedidosOnline->get_client($_GET['id']);
}
?>
<div class="clipe-container">
  <h1><?php _e('Client', 'pedidos-online'); ?> => <?php echo $client->Client->name; ?></h1>


  <?php
  if (isset($client->Headquarters)) {

  }
  ?>
  <table>
    <thead>
      <tr>
        <th><?php _e('Office', 'pedidos-online'); ?></th>
        <th><?php _e('Address', 'pedidos-online'); ?></th>
        <th><?php _e('Phone', 'pedidos-online'); ?></th>
        <th><?php _e('Email', 'pedidos-online'); ?></th>
        <th><?php _e('Actions', 'pedidos-online'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $offices = $client->Headquarters;
      foreach ($offices as $office) {
        ?>
        <tr>
          <td><?php echo $office->code; ?></td>
          <td><?php echo $office->address; ?></td>
          <td><?php echo $office->phone; ?></td>
          <td><?php echo $office->email; ?></td>
          <td>Proximamente ...</td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>

  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>

