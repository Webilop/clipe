<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('client');
$active = isset($_GET['page']) ? $_GET['page'] : 1;
$numberRows = 10;
$result = $pedidosOnline->get_offices(array('page' => $active, 'limit' => $numberRows, 'order_by' => 'address'));
$offices = $result->headquarters;
?>
