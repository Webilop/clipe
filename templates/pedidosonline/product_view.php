<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
$product = $pedidosOnline->get_product($_GET['id']);
?>
<div class="clipe-container">
  <h1><?php _e('Product', 'clipe'); ?> => <?php echo $product->Client->name; ?></h1>

  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('product_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>

