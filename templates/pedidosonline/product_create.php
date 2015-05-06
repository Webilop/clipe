<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $pedidosOnline->create_product();
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__($result->data->message, 'clipe'), 'success');
    wp_redirect($pedidosOnline->get_link_page('product_list.php'));
    exit();
  } elseif (isset($result->status) && $result->status == "fail") {
    $message = array_values(get_object_vars($result->data));
    $pedidosOnline->add_flash_message(__($message[0][0], 'clipe'));
  }
}

get_header();
?>
<div class="clipe-container">
  <h1>Create Product</h1>
  <form method="POST">
    <div>
      <label for="name"><?php _e('Name', 'clipe'); ?></label>
      <input type="text" id="name" name="name" required/>
    </div>
    <div>
      <label for="measure_type"><?php _e('Measure Type', 'clipe'); ?></label>
      <input type="text" id="measure_type" name="measure_type" required/>
    </div>
    <div>
      <label for="category_name"><?php _e('For New Category', 'clipe'); ?></label>
      <input type="text" id="category_name" name="category_name"/>
    </div>
    <div>
      <label for="category_id"><?php _e('Category', 'clipe'); ?></label>
      <select id="category_id" name="category_id" >
        <option value=""></option>
        <?php echo $pedidosOnline->get_categories_options(); ?>
      </select>
    </div>
    <div>
      <label for="client_id"><?php _e('Clients', 'clipe'); ?></label>
      <select id="client_id" name="client_id[]" multiple>
        <?php echo $pedidosOnline->get_clients_options(); ?>
      </select>
    </div>
    <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('product_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<script type="text/javascript">//se requiere para el js 
  window.onload = function () {
    document.getElementById("submit").addEventListener("click", validateCategory);
    document.getElementById("category_name").addEventListener("change", validateCategory);
    document.getElementById("category_id").addEventListener("change", validateCategory);
  }
  function validateCategory() {
    new_category=jQuery.trim(jQuery("#category_name").val());
    var clients = jQuery('#category_id').val(); 
    if (clients.length == 0 && new_category=="") {
      document.getElementById("category_name").setCustomValidity('<?php echo __('Requires at least one category', 'clipe') ?>');
      return false;
    }
    document.getElementById("category_name").setCustomValidity('<?php echo __('', 'clipe') ?>');
    return true;
  }
</script>

<?php
get_sidebar('clipe');
get_footer();
?>

