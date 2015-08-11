<div class="clipe-links pull-right">
  <a title="<?echo __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?echo __('Products', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('product_list.php'); ?>"><i class="fa fa-barcode"></i></a>
  <a title="<?echo __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Product Categories', 'clipe'); ?>  <a title="<?= __('Add Category', 'clipe'); ?>" href="<?= $createCategoryUrl; ?>"><i class="fa fa-plus"></i></a></h1>
<?php if (empty($categories)): ?>
  <div class="alert alert-info">
    <?= sprintf(__('There are no product categories, create a category %s', 'clipe'), sprintf('<a href="%s">', $createCategoryUrl) . __('here', 'clipe') . '</a>'); ?>
  </div>
<?php else: ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th><?php _e('Categories', 'clipe'); ?></th>
        <th class="actions"><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($categories as $category) {
        ?>
        <tr>
          <td><?php echo $category->ProductCategory->name; ?></td>
          <td class="actions">
            <a title="<?= __('View', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("category_view.php") . '&id=' . $category->ProductCategory->id ?>"><i class="fa fa-eye"></i></a>
            <a title="<?= __('Edit', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page("category_edit.php") . '&id=' . $category->ProductCategory->id ?>"><i class="fa fa-pencil-square-o"></i></a>
            <a title="<?= __('Delete', 'clipe'); ?>" class="delete" href="<?php echo $pedidosOnline->get_link_page("category_delete.php") . '&id=' . $category->ProductCategory->id ?>"><i class="fa fa-times"></i></a>
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
