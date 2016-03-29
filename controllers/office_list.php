<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('client');
$active = isset($_GET['page']) ? $_GET['page'] : 1;
$numberRows = 10;
$result = $pedidosOnline->get_offices(array('page' => $active, 'limit' => $numberRows, 'order_by' => 'address'));
if(!isset($result->headquarters)){
  wp_redirect($pedidosOnline->get_link_page('office_list.php'). '&profile=' . $_GET['profile']);
}
$offices = $result->headquarters;
