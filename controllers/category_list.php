<?php
global $pedidosOnline;
$pedidosOnline->validatePermission('provider');
$pedidosOnline->is_login(true);
$active = isset($_GET['page']) ? $_GET['page'] : 1;
$numberRows=10;
$result = $pedidosOnline->get_categories(array('page'=>$active,'limit' => $numberRows, 'order_by' => 'name'));
$categories = $result->productCategories;

$createCategoryUrl = $pedidosOnline->get_link_page("category_create.php");

?>
