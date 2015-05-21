<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');
$product = $pedidosOnline->get_product($_GET['id']);
get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Product', 'clipe'); ?></h1>

  <div>
    <label for="name"><?php _e('Name', 'clipe'); ?></label>
    <input readonly type="text" id="name" name="name" required value="<?php echo $product->Product->name;?>"/>
  </div>
  <div>
    <label for="measure_type"><?php _e('Measure Type', 'clipe'); ?></label>
    <input readonly type="text" id="measure_type" name="measure_type" required value="<?php echo $product->Product->measure_type;?>"/>
  </div>
  <div>
    <label for="category_id"><?php _e('Category', 'clipe'); ?></label>
    <input readonly type="text" id="category_id" name="category_id" required value="<?php echo $product->ProductCategory->name;?>"/>
  </div>
  <div>
    <label for="client_id"><?php _e('Clients', 'clipe'); ?></label>
    <?php 
    $clients="";
    $b_firts=true;
    foreach ($product->Client as $client) {
      if($b_firts){
        $clients=$client->name;
      }else{
        $clients.=", ".$client->name;
      }      
    }?>
    <textarea readonly ><?php echo $clients;?></textarea>
  </div>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('product_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

