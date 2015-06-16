<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);

$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);
//print_r($user->Provider->id);

$profile=in_array( 'client',$user->permissions) ? 'client' : 'provider';
$result = $pedidosOnline->get_orders(array('profile' => $profile, 'limit' => 5, 'order_by' => 'delivery_date', 'order_direction' => 'DESC'));
$nextOrders = isset($result->Orders) ? $result->Orders: array();

?>
