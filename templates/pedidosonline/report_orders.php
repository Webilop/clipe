<h1><?php echo __("Report Orders", 'clipe'); ?></h1>
<form method="POST">
  <div>
    <label for="client_id"><?php _e('Client', 'clipe'); ?></label>
    <select id="client_id" name="client_id[]" required="" multiple="">
      <?php echo $pedidosOnline->get_clients_options(); ?>
    </select>
  </div>  
  <div>
    <label for="status"><?php _e('Status', 'clipe'); ?></label>
    <select id="status" name="status[]" multiple="">        
    <?php foreach ($statusOptions as $key => $value): ?>
      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label for="dates"><?php _e('Date Range', 'clipe'); ?></label>
    <input type="text" name="dates" id="dates" value="" required readonly=""/>
  </div>

  <input type="submit" value="<?php _e('Create', 'clipe'); ?>" class="" id="submit" name="submit">
</form>

<div class="clipe-links">    
  <a href="<?php echo $pedidosOnline->get_link_page('reports_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
  <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery('#dates').daterangepicker(
            {
              format: 'YYYY-MM-DD',
              dateLimit: {days: 31},
              separator: ' to ',
            }
    );
  });
</script>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($reports)) {
  /* echo '<br>****************** <br>';
    print_r($reports); */
  ?>
  <div class="clipe-links">
    <a onclick="return printReport();"><i class="fa fa-print"></i></a>
  </div>
  <div class="container visible-print-block print" id="print">
    <?php
    foreach ($reports as $day => $clients) {
      ?>
      <div class="container table-responsive">
        <h1><?php echo __('Date', 'clipe') . ' ' . $day ?></h1>
        <?php
        foreach ($clients as $clientID => $zones) {
          ?>
          <h1><?php echo __('Client', 'clipe') . ' ' . $clientNames[$clientID] ?></h1>
          <?php
          foreach ($zones as $key => $zonesData) {
            ?>
            <h1><?php echo __('Zone', 'clipe') . ' ' . $key ?></h1>
            <table class="table table-bordered table-hover table-condensed">  
              <thead>
                <tr>
                  <th>
                    Producto/sede
                  </th>
                  <?php
                  foreach ($zonesData['sedes'] as $id => $name) {
                    ?><th><?php echo $name; ?></th><?php
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($zonesData['products'] as $productID => $product) {
                  ?>
                  <tr>
                    <td>
                      <?php echo $product['name']; ?>
                    </td>
                    <?php
                    foreach ($zonesData['sedes'] as $sedeID => $orders) {
                      ?>
                      <td><?php echo isset($product['sedes'][$sedeID]) ? $product['sedes'][$sedeID] : 0; ?></td><?php
          }
                    ?>
                  </tr>
                  <?php
                }
                ?>              
              </tbody>
            </table>
            <?php
          }
        }
        ?>
      </div>
      <?php
    }
    ?>
  </div>
  <script type="text/javascript">
    function printReport() {
      html = jQuery("#print").html();
      var mywindow = window.open('', 'my div', 'height=400,width=600');
      mywindow.document.write('<html><head><title><?php _e('Report Orders', 'clipe'); ?></title>');
      mywindow.document.write('<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" type="text/css" />');
      mywindow.document.write('</head><body >');
      mywindow.document.write(html);
      mywindow.document.write('</body></html>');

      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10

      mywindow.print();
      mywindow.close();

      return false;
    }
  </script>
  <?php
}
?>

