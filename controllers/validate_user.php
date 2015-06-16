<?php
global $pedidosOnline;
if ($pedidosOnline->is_login()) {
  $pedidosOnline->logout();
}
$pedidosOnline->validateUser($_GET['idUser'], $_GET['token']);
wp_redirect($pedidosOnline->get_link_page('index.php'));
exit();
?>
