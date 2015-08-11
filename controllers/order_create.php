<?php

global $pedidosOnline;
global $products;
$pedidosOnline->is_login(true);
//redirect if not client
$pedidosOnline->validatePermission('client');
$products = $pedidosOnline->get_client_products_options();
$headquarters=$pedidosOnline->get_offices_provider_options();
if (empty($products)) {
  $pedidosOnline->add_flash_message(__('You can not create orders because the provider did not assign you products.','clipe'), 'danger');
  wp_redirect($pedidosOnline->get_link_page('index.php') . '&profile=' . $_GET['profile']);
  exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->create_order();
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if ('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else
    $pedidosOnline->add_flash_message($result->message, $type);

  if ('success' == $result->status) {
    wp_redirect($pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']);
    exit();
  }
}
?>
