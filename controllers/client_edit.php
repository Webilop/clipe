<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('client');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
  $result = $pedidosOnline->edit_user($_POST['user_id']);
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else
    $pedidosOnline->add_flash_message($result->message, $type);
}

if (isset($_GET['id'])) {
  $user = $pedidosOnline->get_user($_GET['id']);
} elseif (empty($_GET['id']) || empty($user)) {
  wp_redirect($pedidosOnline->get_link_page('index.php'));
}
