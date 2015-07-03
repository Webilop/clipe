<?php

global $pedidosOnline;
$pedidosOnline->is_login(true);
$order = $pedidosOnline->get_order($_GET['id']);
$status = $pedidosOnline->get_status();
if ($order->Order->status == 5 && $_GET['profile'] == 'provider') {
  $options=get_option('pediodosonline_option_name');
  if(isset($options['change_new_status']) & $options['change_new_status']){
    $result = $pedidosOnline->update_new_status_order($_GET['id']);
  }
  $type = in_array($result->status, array('error', 'fail')) ? 'danger' : 'success';
  if($result->status=='success'){
    $pedidosOnline->add_flash_message(__('The order status is now “In progress”, according to the admin configuration.','Clipe'), $type);
    $order->Order->status=3;
  }else{
  if ('fail' == $result->status && !empty($result->data))
    $pedidosOnline->add_flash_message($pedidosOnline->get_request_error_message($result->data), $type);
  else
    $pedidosOnline->add_flash_message($result->message, $type);
  }
}
get_header();
?>
