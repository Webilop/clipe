<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pedidosOnline->create_category();
}
$category=$pedidosOnline->get_category($_GET['id']);
?>
<div class="clipe-container">
  <h1>Create Product</h1>
  <form method="POST">
    <div>
      <label for="name"><?php _e('Name', 'clipe'); ?></label>
      <input type="name" id="name" name="name" required value="<?php echo $category->name;?>"/>
    </div>
    <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="" id="submit" name="submit">
  </form>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>

