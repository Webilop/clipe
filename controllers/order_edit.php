<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->edit_order($_GET['id']);
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else
    $pedidosOnline->add_flash_message($result->message, $type);

  if('success' == $result->status){
    wp_redirect($pedidosOnline->get_link_page('order_list.php') . '&profile=' . $_GET['profile']);
    exit();
  }
}

$order = $pedidosOnline->get_order($_GET['id']);
$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);
$optionsStatus = array();
$b_update = false;
$b_provider = false;
$b_update_products = false;
if (in_array('provider', $user->permissions)) {
  $optionsStatus = array("Pendiente", "Cancelado", "En progreso", "Completado");
  $b_update = true;
  $b_update_products = true;
  $b_provider = true;
} else {
  if ($order->Order->status == "Pendiente") {
    $optionsStatus = array("Pendiente", "Cancelado");
    $b_update = true;
  }
}

if ($_GET['profile'] == 'provider') {
  wp_enqueue_script('moment', "//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js", array('jquery'));
  wp_enqueue_script('daterangepicker', "//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js", array('jquery'));
  wp_enqueue_style('daterangepicker', "//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css");
}

?>
