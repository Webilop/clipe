<?php
/*
 * method to delete a category and is redirected to the list of categories.
 */
global $pedidosOnline;
$pedidosOnline->is_login(true);
$result=$pedidosOnline->delete_product($_GET['id']);
wp_redirect($pedidosOnline->get_link_page('product_list.php'));
?>
?>

