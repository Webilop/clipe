<h1><?php _e('Delivery days', 'clipe'); ?></h1>
<form method="POST">
  <input type="hidden" name="client_id" value="<?= $_GET['client']; ?>"/>
  <div class="form-group">
    <label class="required" for=""><?php echo __('Zone', 'clipe'); ?></label>
    <input required class="form-control" type="text" name="zone" value="<?php echo isset($zone->name) ? $zone->name : ''; ?>"/>
  </div>
  <div class="form-group">
    <label for=""><?php echo __('Code', 'clipe'); ?></label>
    <input class="form-control" type="text"  name="code" value="<?php echo $code; ?>"/>
  </div>
  <div class="form-group">
    <?php
    foreach ($days as $key => $value) {
      $checked = "";
      if (in_array($key, $delivery_days)) {
        $checked = "checked";
      }
      ?>
      <div class="checkbox">
        <label for="">
          <input type="checkbox"  id="<?php echo $key ?>" <?php echo $checked ?> name="delivery_days[]" value="<?php echo $key ?>"/>
          <?php echo $value; ?>
        </label>
      </div>
    <?php } ?>  
  </div>
  <div class="form-group">
    <label for=""><?php echo __('Zone', 'clipe'); ?></label>
    <input type="text"  name="zone" value="<?php echo isset($zone->name) ? $zone->name : ''; ?>"/>
  </div>

  <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="button" id="submit" name="submit">
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
</form>

<div class="clipe-links">
  <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
