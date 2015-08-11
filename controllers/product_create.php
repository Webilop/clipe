<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
//global $clients;
$clients=$pedidosOnline->get_clients_options();
$categories=$pedidosOnline->get_categories_options();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->create_product();
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else
    $pedidosOnline->add_flash_message($result->message, $type);

  if('success' == $result->status){
    wp_redirect($pedidosOnline->get_link_page('product_list.php'));
    exit();
  }
}

?>
