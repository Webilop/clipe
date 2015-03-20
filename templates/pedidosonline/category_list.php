<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
$categories = $pedidosOnline->get_categories();
?>
<div class="clipe-container">
  <h1><?php _e('Category List', 'clipe'); ?>?></h1>
  <table>
    <thead>
      <tr>
        <th><?php _e('Products', 'clipe'); ?></th>
        <th><?php _e('Actions', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($categories as $category) {
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
get_sidebar();
get_footer();
?>

