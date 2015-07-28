<div class="clipe-links pull-right">
  <a title="<?echo __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?echo __('List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa list"></i></a>
  <a title="<?echo __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Edit Category', 'clipe'); ?></h1>
<div class="row">
  <form method="POST" class="col-xs-6">
    <?php $pedidosOnline->html->create('name',array('label_text'=>'Name','class'=>'form-control','div_class'=>'form-group','required'=>true,'value'=>$category->name)); ?>
    <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
      <?php _e('Update', 'clipe'); ?>
    </button>
  </form>
</div>
