<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
$order = $pedidosOnline->get_order($_GET['id']);
//print_r($order->HeadquartersProvider->{0}->provider_id);
?>
