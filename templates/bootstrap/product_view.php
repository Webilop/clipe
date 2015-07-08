<div class="clipe-links pull-right">
  <a title="<?= __('Product List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('product_list.php');?>"><i class="fa fa-list"></i></a>
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?= $product->Product->name; ?></h1>

<div class="details">
  <div class="row">
    <div class="col-md-4">
      <label><?php _e('Measure Type', 'clipe'); ?></label>
      <div><?= $product->Product->measure_type;?></div>
    </div>
    <div class="col-md-4">
      <label><?php _e('Category', 'clipe'); ?></label>
      <div><?= $product->ProductCategory->name;?></div>
    </div>
  </div>
</div>

<h3><?php _e('Clients', 'clipe'); ?></h3>
<?php if(empty($product->Client)): ?>
<div class="alert alert-info">
  <?= __('There are no clients related to this product', 'clipe'); ?>
</div>
<?php else: ?>
<div class="table-responsive">
  <table class="table table-stripped">
    <thead>
      <tr>
        <th><?php _e('Name', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($product->Client as $client): ?>
      <tr>
        <td>
          <a href='<?= $pedidosOnline->get_link_page("client_view.php") . "&id=" . $client->id; ?>'>
            <?= $client->name; ?>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>
