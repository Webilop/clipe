<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if(isset($_GET['profile'])){
  $orders = $pedidosOnline->get_orders(array('profile'=>$_GET['profile']));
}

get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Order List', 'clipe'); ?>  <a href="<?php echo $pedidosOnline->get_link_page("order_create.php").'&profile='.$_GET['profile'];?>"><i class="fa fa-plus"></i></a></h1>
  <table class="clipe-table">
    <thead>
      <tr>
        <th><?php _e('Offices', 'clipe'); ?></th>
        <th><?php _e('Created', 'clipe'); ?></th>
        <th><?php _e('Status', 'clipe'); ?></th>
        <th><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($orders as $order) {
        ?>
        <tr>
          <td><?php echo $order->Order->address;  ?></td>
          <td><?php echo $order->Order->created;  ?></td>
          <td><?php echo $order->Order->status;  ?></td>
          <td>
            <a href="<?php echo $pedidosOnline->get_link_page("order_view.php").'&id='.$order->Order->id.'&profile='.$_GET['profile']; ?>"><i class="fa fa-eye"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("order_edit.php").'&id='.$order->Order->id.'&profile='.$_GET['profile'];?>"><i class="fa fa-pencil-square-o"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("order_delete.php").'&id='.$order->Order->id.'&profile='.$_GET['profile'];?>"><i class="fa fa-trash-o"></i></a>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

