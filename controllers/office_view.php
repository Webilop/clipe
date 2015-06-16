<?php
get_header();
global $pedidosOnline;
//$pedidosOnline->validatePermission('client');
$pedidosOnline->is_login(true);
$order = $pedidosOnline->get_office($_GET['id']);
$orders = $pedidosOnline->get_office_orders($_GET['id'], $_GET['profile']);
//print_r($order->HeadquartersProvider->{0}->provider_id);
$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);
?>
