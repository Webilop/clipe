<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$active = isset($_GET['page']) ? $_GET['page'] : 1;
  $numberRows = 5;
$result = $pedidosOnline->get_products(array('page'=>$active,'limit' => $numberRows, 'order_by' => 'name'));
$products=$result->Products;
get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Product List', 'clipe'); ?> <a href="<?php echo $pedidosOnline->get_link_page("product_create.php"); ?>"><i class="fa fa-plus"></i></a>
    <a title="<?= __('Add Products in block', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("batch_product_addition.php"); ?>"><i class="fa fa-file"></i></a>
  </h1>
  <table class="clipe-table">
    <thead>
      <tr>
        <th><?php _e('Products', 'clipe'); ?></th>
        <th><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($products as $product) {
        ?>
        <tr>
          <td><?php echo $product->Product->name; ?></td>
          <td><a href="<?php echo $pedidosOnline->get_link_page("product_view.php") . '&id=' . $product->Product->id ?>"><i class="fa fa-eye"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("product_edit.php") . '&id=' . $product->Product->id ?>"><i class="fa fa-pencil-square-o"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("product_delete.php") . '&id=' . $product->Product->id ?>"><i class="fa fa-trash-o"></i></a></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
  <div class="text-center">
    <?php
    $pedidosOnline->print_pagination($result->rows, $numberRows);
    ?>
  </div>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

