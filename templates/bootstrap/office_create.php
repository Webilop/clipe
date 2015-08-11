<div class="clipe-links pull-right">
  <a title="<?echo __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?echo __('List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('office_list.php'). '&profile=' . $_GET['profile']; ?>"><i class="fa fa-arrow-left"></i></a>
  <a title="<?echo __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Create Headquarter', 'clipe'); ?></h1>
<form method="POST">
  <div class="row">
    <div class="col-md-6">
      <?php
      $pedidosOnline->html->create('address',array('label_text'=>'Address','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('phone',array('label_text'=>'Phone','class'=>'form-control','div_class'=>'form-group','required'=>true));
      ?>
    </div>
  </div>
  <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
    <?php _e('Create', 'clipe'); ?>
  </button>
</form>
