<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->create_office();
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status && !empty($result->data)) {
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  } else {
    $pedidosOnline->add_flash_message($result->message, $type);
  }

  if('success' == $result->status) {
    wp_redirect($pedidosOnline->get_link_page('client_list.php'));
    exit();
  }
}
$days = $pedidosOnline->get_days();
$clientsData = $pedidosOnline->get_clients(array('limit' => 1000));
$clients = array();
foreach ($clientsData->clients as $clientData) {
  $clients[$clientData->Client->id] = $clientData->Client->name;
}
