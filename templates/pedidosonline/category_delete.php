<?php
/*
 * method to delete a category and is redirected to the list of categories.
 */
global $pedidosOnline;
$pedidosOnline->is_login(true);
$result=$pedidosOnline->delete_category($_GET['id']);
if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__('Category deleted successfully', 'clipe'), 'success');
  }
  else {
    $pedidosOnline->add_flash_message($result);
  }
wp_redirect($pedidosOnline->get_link_page('category_list.php'));
exit();
?>
?>

