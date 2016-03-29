<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
$active = isset($_GET['page']) ? $_GET['page'] : 1;
$numberRows = 10;
$clients = $pedidosOnline->get_clients(array(
  'limit'    => $numberRows,
  'order_by' => 'name',
  'page'     => $active
));
$createClientUrl = $pedidosOnline->get_link_page("client_create.php");
