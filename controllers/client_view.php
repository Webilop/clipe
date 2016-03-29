<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');

if(isset($_GET['id'])){
  $client = $pedidosOnline->get_client($_GET['id']);
}
else{
  wp_redirect($pedidosOnline->get_link_page('index.php'));
  exit();
}

$createOfficeUrl = $pedidosOnline->get_link_page('office_create.php') . '&client_id=' . $_GET['id']; 
