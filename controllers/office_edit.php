<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('client');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->edit_office($_GET['id']);
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else
    $pedidosOnline->add_flash_message($result->message, $type);
  
  if('success' == $result->status){
    wp_redirect($pedidosOnline->get_link_page('office_list.php'). '&profile=' . $_GET['profile']);
    exit();
  }
}

$office=$pedidosOnline->get_office($_GET['id']);
?>
