<h1><?php _e('Create Office', 'clipe'); ?></h1>
<form method="POST">
  <div>
    <label for="address"><?php _e('Address', 'clipe'); ?></label>
    <input type="text" id="address" name="address" required/>
  </div>
  <div>
    <label for="phone"><?php _e('Phone', 'clipe'); ?></label>
    <input type="text" id="phone" name="phone" required/>
  </div>
  <div>
    <label for="email"><?php _e('Email', 'clipe'); ?></label>
    <input type="email" id="email" name="email" required/>
  </div>
  <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" name="submit">
</form>
<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('office_list.php'). '&profile=' . $_GET['profile']; ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
