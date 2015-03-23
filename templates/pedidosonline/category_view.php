<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
$category=$pedidosOnline->get_category($_GET['id']);
?>
<div class="clipe-container">
    <h1><?php _e('Category', 'clipe'); ?> => <?php echo $category->name; ?></h1>

    <div class="clipe-links">
      <a href="<?php echo $pedidosOnline->get_link_page('category_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
      <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    </div>
    <?php
  ?>
</div>
<?php
get_sidebar();
get_footer();
?>

