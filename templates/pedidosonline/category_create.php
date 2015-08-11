<h1><?php _e('Create Category', 'clipe'); ?></h1>
<form method="POST">
  <div>
    <label for="name"><?php _e('Name', 'clipe'); ?></label>
    <input type="text" id="name" name="name" required/>
  </div>
  <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" name="submit">
</form>
<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
