<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
$product = $pedidosOnline->get_product($_GET['id']);

?>
