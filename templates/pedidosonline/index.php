<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);

$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);
//print_r($user->Provider->id);
?>
<div class="clipe-container">
  <h1><?php _e('Index', 'clipe'); ?></h1>

  <h3><?php _e('Section General', 'clipe'); ?></h3>
  <p><a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><?php _e('Logout', 'clipe'); ?></a></p>

  <?php if (in_array('provider',$user->permissions)) { ?><h3><?php _e('Section Provider', 'clipe'); ?></h3>
    <p><a href="<?php echo $pedidosOnline->get_link_page('provider_edit.php') . '&id=' . $userId; ?>"><?php _e('My Account', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><?php _e('List of Client', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('product_list.php'); ?>"><?php _e('Product List', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><?php _e('Categories List', 'clipe'); ?></a></p>
  <?php } ?>

  <?php if (in_array( 'client',$user->permissions)) { ?><h3><?php _e('Section Client', 'clipe'); ?></h3>
    <p><a href="<?php echo $pedidosOnline->get_link_page('client_edit.php') . '&id=' . $userId; ?>"><?php _e('My Account', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('office_list.php'); ?>"><?php _e('Offices', 'clipe'); ?></a></p>
    <p><a href="<?php echo $pedidosOnline->get_link_page('supplier_list.php'); ?>"><?php _e('Supplier List', 'clipe'); ?></a></p>
  <?php } ?>
</div>
<?php
get_sidebar();
get_footer();
?>
