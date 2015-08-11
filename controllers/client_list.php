<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
$active = isset($_GET['page']) ? $_GET['page'] : 1;
$numberRows=10;
$result = $pedidosOnline->get_clients(array('page'=>$active,'limit' => $numberRows, 'order_by' => 'name'));
$clients = $result->clients;

$createClientUrl = $pedidosOnline->get_link_page("client_create.php");

?>
