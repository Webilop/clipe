<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);

$user_id=$pedidosOnline->get_user_id(true);
?>
<div class="clipe-container">
  <h1>index</h1>
  <p><a href="<?php echo $pedidosOnline->get_link_page('client_list.php');?>"><?php _e('List of Client','clipe');?></a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('client_create.php');?>"><?php _e('Create Client','clipe');?></a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('my_account.php').'&id=' . $user_id;?>"><?php _e('My Account','clipe');?></a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('product_list.php');?>"><?php _e('Product List','clipe');?></a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('supplier_list.php');?>"><?php _e('Supplier List','clipe');?></a></p>
</div>
<?php
get_sidebar();
get_footer();
?>
