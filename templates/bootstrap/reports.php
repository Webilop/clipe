<h1><?php _e('Reports', 'clipe'); ?> </h1>
<table class="table table-stripped">
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
