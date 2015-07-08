<div class="clipe-links pull-right">
  <a title="<?= __('Headquarter List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('office_list.php').'&profile='.$_GET['profile']; ?>"><i class="fa fa-list"></i></a>
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Edit Headquarters', 'clipe'); ?></h1>
<form method="POST">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label class="required" for="address"><?php _e('Address', 'clipe'); ?></label>
        <input class="form-control" type="text" id="address" name="address" value="<?php echo $office->Headquarters->address;?>" required/>
      </div>
      <div class="form-group">
        <label class="required" for="phone"><?php _e('Phone', 'clipe'); ?></label>
        <input class="form-control" type="text" id="phone" name="phone" value="<?php echo $office->Headquarters->phone;?>" required/>
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
    <?php _e('Update', 'clipe'); ?>
  </button>
</form>
