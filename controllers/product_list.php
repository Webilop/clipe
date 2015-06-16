<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
$active = isset($_GET['page']) ? $_GET['page'] : 1;
$numberRows = 10;
$result = $pedidosOnline->get_products(array('page'=>$active,'limit' => $numberRows, 'order_by' => 'name'));
$products=isset($result->Products) ? $result->Products: array();

$createProductUrl = $pedidosOnline->get_link_page("product_create.php");

?>
