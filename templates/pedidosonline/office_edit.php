<h1><?php _e('Edit Headquarters', 'clipe'); ?></h1>
<form method="POST">
  <div>
    <label for="address"><?php _e('Address', 'clipe'); ?></label>
    <input type="text" id="address" name="address" value="<?php echo $office->Headquarters->address;?>" required/>
  </div>
  <div>
    <label for="phone"><?php _e('Phone', 'clipe'); ?></label>
    <input type="text" id="phone" name="phone" value="<?php echo $office->Headquarters->phone;?>" required/>
  </div>
  <div>
    <label for="email"><?php _e('Email', 'clipe'); ?></label>
    <input type="email" id="email" name="email" value="<?php echo $office->Headquarters->email;?>" required/>
  </div>
  <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="" id="submit" name="submit">
</form>
<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('office_list.php').'&profile='.$_GET['profile']; ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
