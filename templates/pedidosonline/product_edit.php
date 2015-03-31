<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pedidosOnline->edit_product($_GET['id']);
}
$product = $pedidosOnline->get_product($_GET['id']);
print_r($product);exit;

get_header();
?>
<div class="clipe-container">
  <h1>Edit Product</h1>
  <form method="POST">
    <div>
      <label for="name"><?php _e('Name', 'clipe'); ?></label>
      <input type="text" id="name" name="name" required value="<?php echo $product->name;?>"/>
    </div>
    <div>
      <label for="measure_type"><?php _e('Measure Type', 'clipe'); ?></label>
      <input type="text" id="measure_type" name="measure_type" required value="<?php echo $product->measure_type;?>"/>
    </div>
    <div>
      <label for="category_name"><?php _e('For New Category', 'clipe'); ?></label>
      <input type="text" id="category_name" name="category_name" value="<?php echo $product->category_name;?>"/>
    </div>
    <div>
      <label for="category_id"><?php _e('Category', 'clipe'); ?></label>
      <select id="category_id" name="category_id" >
        <option value="">----------</option>
        <?php echo $pedidosOnline->get_categories_options($product->category_id);?>
      </select>
    </div>
    <div>
      <label for="client_id"><?php _e('Clients', 'clipe'); ?></label>
      <select id="client_id" name="client_id[]" multiple>
        <option value=""><?php _e('None', 'clipe'); ?></option>
        <?php echo $pedidosOnline->get_clients_options($product->clients);?>
      </select>
    </div>
    <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

