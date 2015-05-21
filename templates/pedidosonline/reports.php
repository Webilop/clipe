<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
$pedidosOnline->validatePermission('provider');

get_header();
?>
<div class="clipe-container">
  <h1><?php _e('Reports', 'clipe'); ?> </h1>
  <table class="clipe-table">
    <thead>
      <tr>
        <th><?php _e('Report', 'clipe'); ?></th>
        <th><?php _e('Action', 'clipe'); ?></th>
      </tr>
    </thead>
    <tbody>    
        <tr>
          <td><?php _e('Report of Orders', 'clipe'); ?></td>
          <td class="actions">            
            <a href="<?php echo $pedidosOnline->get_link_page("report_orders.php")?>"><i class="fa fa-eye"></i></a>                   
          </td>
        </tr>
    </tbody>
  </table>
  <div class="clipe-links">
    <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

