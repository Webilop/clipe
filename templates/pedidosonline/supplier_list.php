<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
$suppliers = array();
?>
<div class="clipe-container">
  <h1>list of customer</h1>
  <table>
    <thead>
      <tr>
        <th><?php _e('Suppliers', 'pedidos-online'); ?></th>
        <th><?php _e('Actions', 'pedidos-online'); ?></th>
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
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>

