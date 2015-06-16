<h1><?php _e('Category List', 'clipe'); ?>  <a href="<?php echo $pedidosOnline->get_link_page("category_create.php");?>"><i class="fa fa-plus"></i></a></h1>
<table class="clipe-table">
  <thead>
    <tr>
      <th><?php _e('Categories', 'clipe'); ?></th>
      <th><?php _e('Created', 'clipe'); ?></th>
      <th><?php _e('Actions', 'clipe'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($categories as $category) {
      ?>
      <tr>
        <td><?php echo $category->ProductCategory->name;  ?></td>
        <td><?php echo $category->ProductCategory->created;  ?></td>
        <td>
          <a href="<?php echo $pedidosOnline->get_link_page("category_view.php").'&id='.$category->ProductCategory->id ?>"><i class="fa fa-eye"></i></a>
          <a href="<?php echo $pedidosOnline->get_link_page("category_edit.php").'&id='.$category->ProductCategory->id ?>"><i class="fa fa-pencil-square-o"></i></a>
          <a href="<?php echo $pedidosOnline->get_link_page("category_delete.php").'&id='.$category->ProductCategory->id ?>"><i class="fa fa-trash-o"></i></a>
        </td>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>
<div class="text-center">
    <?php
    $pedidosOnline->print_pagination($result->rows,$numberRows);
    ?>
  </div>
<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
