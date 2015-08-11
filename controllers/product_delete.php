<?php
/*
 * method to delete a category and is redirected to the list of categories.
 */
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
$result=$pedidosOnline->delete_product($_GET['id']);
$type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
if('fail' == $result->status && !empty($result->data))
  $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
else
  $pedidosOnline->add_flash_message($result->message, $type);

wp_redirect($pedidosOnline->get_link_page('product_list.php'));
exit();
?>


