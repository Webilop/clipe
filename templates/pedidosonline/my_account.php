<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
if (isset($_GET['id'])) {
  $client = $pedidosOnline->get_client($_GET['id']);
}
?>
<div class="clipe-container">
  <h1><?php _e('My Account', 'pedidos-online'); ?></h1>


  <?php /* <table>
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
    <td><a href="<?php echo $pedidosOnline->get_link_page("view_client.php").'&id='.$client->Client->id?>"><i class="fa fa-eye"></i></a></td>
    </tr>
    <?php
    }
    ?>
    </tbody>
    </table>
    </div> */ ?>

  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>

