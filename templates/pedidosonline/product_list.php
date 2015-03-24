<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$products = $pedidosOnline->get_products();

get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Product List', 'clipe'); ?>?></h1>
  <table class="clipe-table">
    <thead>
      <tr>
        <th><?php _e('Products', 'clipe'); ?></th>
        <th><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($products as $product) {
        ?>
        <tr>
          <td><?php //echo $client->Client->name;  ?></td>
          <td><a href="<?php //echo $pedidosOnline->get_link_page("client_view.php").'&id='.$client->Client->id ?>"><i class="fa fa-eye"></i></a></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

