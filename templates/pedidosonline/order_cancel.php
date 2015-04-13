<?php
/*
 * method to delete a category and is redirected to the list of categories.
 */
global $pedidosOnline;
$pedidosOnline->is_login(true);
$result = $pedidosOnline->edit_order($_GET['id'], true);
if (isset($result->status) && $result->status == "success") {
  $pedidosOnline->add_flash_message(__($result->data->message, 'clipe'), 'success');
}
elseif (isset($result->status) && $result->status == "fail") {
  $message = array_values(get_object_vars($result->data));
  $pedidosOnline->add_flash_message(__($message[0][0], 'clipe'));
}
elseif (isset($result->status) && $result->status == "error") {
  $pedidosOnline->add_flash_message(__($result->message, 'clipe'));
}
else {
  $pedidosOnline->add_flash_message($result);
}
wp_redirect($pedidosOnline->get_link_page('order_list.php').'&profile='.$_GET['profile']);
exit();
?>
?>

