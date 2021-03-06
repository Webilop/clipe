<h1><?php _e('Product List', 'clipe'); ?> <a href="<?php echo $pedidosOnline->get_link_page("product_create.php"); ?>"><i class="fa fa-plus"></i></a>
  <a title="<?= __('Add Products in block', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("batch_product_addition.php"); ?>"><i class="fa fa-file"></i></a>
</h1>
<?php if (empty($products)): ?>
  <div class="alert alert-info">
    <?= sprintf(__('There are no products, create your first product %s', 'clipe'), sprintf('<a href="%s">', $createProductUrl) . __('here') . '</a>'); ?>
  </div>
<?php else: ?>
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
          <td class="actions">
            <a href="<?php echo $pedidosOnline->get_link_page("product_view.php") . '&id=' . $product->Product->id ?>"><i class="fa fa-eye"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("product_edit.php") . '&id=' . $product->Product->id ?>"><i class="fa fa-pencil-square-o"></i></a>
            <a href="<?php echo $pedidosOnline->get_link_page("product_delete.php") . '&id=' . $product->Product->id ?>" class="delete"><i class="fa fa-trash-o"></i></a>
          </td>
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
<?php endif; ?>
<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
