<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->create_client();
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__($result->data->message, 'clipe'), 'success');
    wp_redirect($pedidosOnline->get_link_page('client_list.php'));
    exit();
  }elseif (isset($result->status) && $result->status == "fail") {
    $message = array_values(get_object_vars($result->data));
    $pedidosOnline->add_flash_message(__($message[0][0], 'clipe'));
  } else {
    $pedidosOnline->add_flash_message($result);
  }

}

get_header();
?>
<div class="clipe-container">
  <h1>Create of Client</h1>
  <form method="POST">
    <div>
      <label for="name"><?php _e('Name', 'clipe'); ?></label>
      <input type="text" id="name" name="name" required/>
    </div>
    <div>
      <label for="email"><?php _e('Email', 'clipe'); ?></label>
      <input type="email" id="email" name="email" required/>
    </div>
    <div>
      <label for="address"><?php _e('Address', 'clipe'); ?></label>
      <input type="address" id="address" name="address" required/>
    </div>
    <div>
      <label for="phone"><?php _e('Phone', 'clipe'); ?></label>
      <input type="phone" id="phone" name="phone" required/>
    </div>
    <div>
      <label for="code"><?php _e('Code', 'clipe'); ?></label>
      <input type="code" id="code" name="code"/>
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
        $days = $pedidosOnline->days;
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
    <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
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
<?php
get_sidebar('clipe');
get_footer();
?>

