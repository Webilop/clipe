<div class="clipe-links pull-right">
  <a title="<?= __('Product categories', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa fa-list"></i></a>
  <a title="<?= __('Dashboard', 'clipe'); ?>"href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php echo $category->name; ?></h1>

<h3><?= __('Products', 'clipe'); ?></h3>
<?php
echo '<pre>'; print_r($category); echo '</pre>';
?>
