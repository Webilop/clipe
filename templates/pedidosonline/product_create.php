<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pedidosOnline->create_product();
}
?>
<div class="clipe-container">
  <h1>Create Product</h1>
  <form method="POST">
    <div>
      <label for="name"><?php _e('Name', 'clipe'); ?></label>
      <input type="name" id="name" name="name" required/>
    </div>
    <div>
      <label for="measure_type"><?php _e('Measure Type', 'clipe'); ?></label>
      <input type="text" id="measure_type" name="measure_type" required/>
    </div>
    <div>
      <label for="category_name"><?php _e('New Category', 'clipe'); ?></label>
      <input type="text" id="category_name" name="category_name"/>
    </div>
    <div>
      <label for="category_id"><?php _e('Category', 'clipe'); ?></label>
      <select id="category_id" name="category_id" required>
        <option value="">---------</option>
      </select>
    </div>
    <div>
      <label for="client_id"><?php _e('Category', 'clipe'); ?></label>
      <select id="client_id" name="client_id[]" required multiple>
        <option value="">----------</option>
        <?php echo $pedidosOnline->get_category_options();?>
      </select>
    </div>
    <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>

