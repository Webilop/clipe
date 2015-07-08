<div class="clipe-links pull-right">
  <a href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
</div>
<h1><?php _e('Create Category', 'clipe'); ?></h1>
<div class="row">
  <form method="POST" class="col-xs-6">
    <div class="form-group">
      <label class="required" for="name"><?php _e('Name', 'clipe'); ?></label>
      <input class="form-control" type="name" id="name" name="name" required/>
    </div>
    <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
      <?php _e('Create', 'clipe'); ?>
    </button>
  </form>
</div>
