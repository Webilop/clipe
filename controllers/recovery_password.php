<?php
global $pedidosOnline;
//if the user is already logged in
if($pedidosOnline->is_login())
  $pedidosOnline->redirectLogin();

//init the password recovery
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
  $result = $pedidosOnline->recoveryPassword($_POST['email']);
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else{
    $pedidosOnline->add_flash_message($result->message, $type);
    $pedidosOnline->redirectLogin();
  }
}

?>
