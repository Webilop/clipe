<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['office'])) {
  $result = $pedidosOnline->edit_delivery_days($_GET['office']);
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else
    $pedidosOnline->add_flash_message($result->message, $type);
}

if (isset($_GET['client']) && isset($_GET['office'])) {
  $delivery_days = $pedidosOnline->get_delivery_days($_GET['client'], $_GET['office'], 'provider');
  $office = $pedidosOnline->get_office($_GET['office']);
  $zone=isset($office->Zone) ? $office->Zone : '';
  $provider_id=$pedidosOnline->get_admin_provider_id();
  $code=isset($office->HeadquartersProvider->code) ? $office->HeadquartersProvider->code: '';
  $delivery_days = (array) $delivery_days;
} elseif (empty($_GET['id']) || empty($user) || empty($_GET['client']) || empty($_GET['office'])) {
  wp_redirect($pedidosOnline->get_link_page('index.php'));
}
$days = $pedidosOnline->days;

?>
