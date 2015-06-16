<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['provider_id'])) {
  $result = $pedidosOnline->edit_provider($_POST['provider_id']);
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if(!empty($result->message))
    $pedidosOnline->add_flash_message($result->message, $type);
  else if('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  //wp_redirect($pedidosOnline->get_link_page('index.php'));
}

if (isset($_GET['id'])) {
  $user = $pedidosOnline->get_user($_GET['id']);
} else {
  wp_redirect($pedidosOnline->get_link_page('index.php'));
}

?>
