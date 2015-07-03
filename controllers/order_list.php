<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if (isset($_GET['profile'])) {
  $active = isset($_GET['page']) ? $_GET['page'] : 1;
  $numberRows = 10;
  $result = $pedidosOnline->get_orders(array('profile' => $_GET['profile'], 'page' => $active, 'limit' => $numberRows, 'order_by' => 'delivery_date', 'order_direction' => 'DESC'));
  $orders = empty($result->Orders) ? array() : $result->Orders;
}

$createOrderUrl = $pedidosOnline->get_link_page("order_create.php") . '&profile=' . $_GET['profile'];
$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);

?>
