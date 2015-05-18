<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['office'])) {
  $result = $pedidosOnline->edit_delivery_days($_GET['office']);
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__($result->data->message, 'clipe'), 'success');
  } elseif (isset($result->status) && $result->status == "fail") {
    $message = array_values(get_object_vars($result->data));
    $pedidosOnline->add_flash_message(__($message[0][0], 'clipe'));
  } else {
    $pedidosOnline->add_flash_message($result);
  }
}

if (isset($_GET['client']) && isset($_GET['office'])) {
  $delivery_days = $pedidosOnline->get_delivery_days($_GET['client'], $_GET['office'], 'provider');
  $zone = $pedidosOnline->get_office_zone($_GET['office']);
  $delivery_days = (array) $delivery_days;
} elseif (empty($_GET['id']) || empty($user)) {
  wp_redirect($pedidosOnline->get_link_page('index.php'));
}
$days = $pedidosOnline->days;
get_header();
?>
<div class="clipe-container">
  <?php
  if (isset($_GET['client']) && isset($_GET['office'])) {
    ?>
    <h1><?php _e('Delivery days', 'clipe'); ?></h1>
    <form method="POST">
      <input type="hidden" name="client_id" value="<?= $_GET['client']; ?>"/>
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
        <label for=""><?php echo __('Zone','clipe'); ?></label>
        <input type="text"  name="zone" value="<?php echo isset($zone->name) ? $zone->name: ''; ?>"/>
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
    <?php
  } else {
    ?>
    <h1><?php _e('Error', 'clipe') ?></h1>
    <?php
  }
  ?>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>


