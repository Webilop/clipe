<?php
get_header();
global $pedidosOnline;
if (!isset($_GET['profile'])) {
  // If no profile, exit
  $pedidosOnline->validatePermission();
}
$pedidosOnline->validatePermission($_GET['profile']);
$pedidosOnline->is_login(true);
$office = $pedidosOnline->get_office($_GET['id']);
$orders = $pedidosOnline->get_office_orders($_GET['id'], $_GET['profile']);

$userId = $pedidosOnline->get_user_id();
$user = $pedidosOnline->get_user($userId);
