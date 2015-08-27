<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //show message is uploading.exit;
  $result = $pedidosOnline->addition_file_of_products();
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status) {
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->errors), $type);
  }  else {
    $pedidosOnline->add_flash_message($result->message, $type);
  }
}
