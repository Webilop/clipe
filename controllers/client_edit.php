<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('client');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_id'])) {
  $result = $pedidosOnline->edit_client($_POST['client_id']);
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else
    $pedidosOnline->add_flash_message($result->message, $type);
  //print_r($result);
  //wp_redirect($pedidosOnline->get_link_page('index.php'));
}

if (isset($_GET['id'])) {
  $user = $pedidosOnline->get_user($_GET['id']);
} elseif (empty($_GET['id']) || empty($user)) {
  wp_redirect($pedidosOnline->get_link_page('index.php'));
}

?>
