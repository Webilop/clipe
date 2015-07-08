  <div class="clipe-links pull-right">
    <a title="<?= __('Product Categories', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa fa-list"></i></a>
    <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
  <h1><?php _e('Products', 'clipe'); ?> <a title="<?= __('Add Product', 'clipe'); ?>" href="<?= $createProductUrl; ?>"><i class="fa fa-plus"></i></a>
    <a title="<?= __('Add Products in block', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("batch_product_addition.php"); ?>"><i class="fa fa-file"></i></a>
  </h1>
  <?php if (empty($products)): ?>
    <div class="alert alert-info">
      <?= sprintf(__('There are no products, create your first product %s', 'clipe'), sprintf('<a href="%s">', $createProductUrl) . __('here') . '</a>'); ?>
    </div>
  <?php else: ?>
    <table class="table table-stripped">
      <thead>
        <tr>
          <th><?php _e('Product', 'clipe'); ?></th>
          <th><?php _e('Measure Type', 'clipe'); ?></th>
          <th><?php _e('Category', 'clipe'); ?></th>
          <th><?php _e('Actions', 'clipe'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($products as $product) {
          ?>
          <tr>
            <td><?php echo $product->Product->name; ?></td>
            <td><?= $product->Product->measure_type; ?></td>
            <td>
              <a href='<?= $pedidosOnline->get_link_page("category_view.php") . "&id=" . $product->ProductCategory->id; ?>'><?= $product->ProductCategory->name; ?></a>
            </td>
            <td class="actions">
              <a title="<?= __('View', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("product_view.php") . '&id=' . $product->Product->id ?>"><i class="fa fa-eye"></i></a>
              <a title="<?= __('Edit', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("product_edit.php") . '&id=' . $product->Product->id ?>"><i class="fa fa-pencil-square-o"></i></a>
              <a class="delete" title="<?= __('Delete', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("product_delete.php") . '&id=' . $product->Product->id ?>"><i class="fa fa-trash-o"></i></a>
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
