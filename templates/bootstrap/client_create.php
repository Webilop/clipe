<div class="clipe-links pull-right">
  <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
</div>
<h1><?= __("Create Client", "clipe") ?></h1>

<div class="row">
  <form method="POST" class="col-md-6">
    <div class="form-group">
      <label class="required" for="name"><?php _e('Name', 'clipe'); ?></label>
      <input class="form-control" type="name" id="name" name="name" required/>
    </div>
    <div class="form-group">
      <label class="required" for="email"><?php _e('Email', 'clipe'); ?></label>
      <input class="form-control" type="email" id="email" name="email" required/>
    </div>
    <div class="form-group">
      <label class="required" for="address"><?php _e('Address', 'clipe'); ?></label>
      <input class="form-control" type="address" id="address" name="address" required/>
    </div>
    <div class="form-group">
      <label class="required" for="phone"><?php _e('Phone', 'clipe'); ?></label>
      <input class="form-control" type="phone" id="phone" name="phone" required/>
    </div>
    <div class="form-group">
      <label for="code"><?php _e('Code', 'clipe'); ?></label>
      <input class="form-control" type="text" id="code" name="code"/>
    </div>
    <div class="form-group">
      <label for="short_name"><?php _e('Short Name', 'clipe'); ?></label>
      <input class="form-control" type="text" id="short_name" name="short_name"/>
    </div>
    <div class="form-group">
      <label class="required" for="zone"><?php _e('Zone', 'clipe'); ?></label>
      <input class="form-control" type="text" id="zone" name="zone" required=""/>
    </div>
    <div class="form-group">
      <label class="required" for="delivery_days"><?php _e('Delivery Days', 'clipe'); ?></label>
      <?php
      foreach ($days as $key => $value) {
        ?>
        <div class="checkbox">
          <label >
          <input type="checkbox"  id="<?php echo $key ?>" name="delivery_days[]" value="<?php echo $key ?>"/>
          <?php echo $value; ?>
          </label>
        </div>
        <?php
      }
      ?>
    </div>
    <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
      <?php _e('Create', 'clipe'); ?>
    </button>
  </form>
</div>

<script type="text/javascript">
  window.onload = function () {
    document.getElementById("submit").onclick = requiredDays;
  }
  function requiredDays() {
    b_error = true;
    jQuery("input[name='delivery_days[]']:checked").each(function () {
      b_error = false;
      return false;
    });
    if (b_error) {
      document.getElementById("Domingo").setCustomValidity('<?php _e('required to select at least one', 'clipe') ?>');
    } else {
      document.getElementById("Domingo").setCustomValidity('');
    }
    return true;
  }
</script>
