<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
$clients = $pedidosOnline->get_clients_list(array('limit'=>50,'order_by'=>'name'));
?>
<div><h1>list of customer</h1>
  <table>
    <thead>
      <tr>
        <th><?php _e('Client', 'pedidos-online'); ?></th>
        <th><?php _e('Actions', 'pedidos-online'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($clients as $client) {
        ?>
        <tr>
          <td><?php echo $client->Client->name; ?></td>
          <td>Proximamente..</td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
<?php
get_sidebar();
get_footer();
?>

