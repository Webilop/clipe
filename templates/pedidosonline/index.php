<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
?>
<div class="clipe-container">
  <h1>index</h1>
  <p><a href="<?php echo $pedidosOnline->get_link_page('client_list.php');?>"><?php _e('List of Client','pedidos-online');?></a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('client_create.php');?>"><?php _e('Create Client','pedidos-online');?></a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('my_account.php');?>"><?php _e('My Account','pedidos-online');?></a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('product_list.php');?>"><?php _e('Product List','pedidos-online');?></a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('supplier_list.php');?>"><?php _e('Supplier List','pedidos-online');?></a></p>
</div>
<?php
get_sidebar();
get_footer();
?>
