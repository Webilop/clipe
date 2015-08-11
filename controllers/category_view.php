<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
$category=$pedidosOnline->get_category($_GET['id']);

?>
