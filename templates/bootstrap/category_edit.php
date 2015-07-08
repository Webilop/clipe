<div class="clipe-links pull-right">
  <a title="<?= __('Product categories', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa list"></i></a>
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Edit Category', 'clipe'); ?></h1>
<div class="row">
  <form method="POST" class="col-xs-6">
    <div>
      <label class="required" for="name"><?php _e('Name', 'clipe'); ?></label>
      <input class="form-control" type="name" id="name" name="name" required value="<?php echo $category->name;?>"/>
    </div>
    <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
      <?php _e('Update', 'clipe'); ?>
    </button>
  </form>
</div>
