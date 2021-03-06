<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
$clients=$pedidosOnline->get_clients_options();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->report_orders();
  $objClients = $pedidosOnline->get_clients();
  $clientNames = array();
  $reports = array();
  foreach ($objClients as $client) {
    $clientNames[$client->Client->id] = $client->Client->name;
  }
  if ($result['status'] == "error") {
    $pedidosOnline->add_flash_message($result['message']);
  } else {
    $reports = $result['data'];
  }
}

//get status options
$statusOptions = $pedidosOnline->get_status();

wp_enqueue_script('moment', "//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js", array('jquery'));
wp_enqueue_script('daterangepicker', "//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js", array('jquery'));
wp_enqueue_style('daterangepicker', "//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css");
?>
