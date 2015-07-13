<h1><?php echo __("Report Orders", 'clipe'); ?></h1>
<form method="POST">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="client_id"><?php _e('Client', 'clipe'); ?></label>
        <select id="client_id" name="client_id[]" required="" multiple="" class="form-control">
          <?php echo $pedidosOnline->get_clients_options(); ?>
        </select>
      </div>
      <div class="form-group">
        <label for="status"><?php _e('Status', 'clipe'); ?></label>
        <select id="status" name="status[]" multiple="" class="form-control">
          <?php foreach ($statusOptions as $key => $value): ?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
          <?php endforeach; ?>
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="dates"><?php _e('Date Range', 'clipe'); ?></label>
        <input type="text" name="dates" id="dates" value="" required class="form-control" />
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-default login-submit" id="submit">
    <?php _e('Create', 'clipe'); ?>
  </button>
</form>

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
  <div class="pull-right clipe-links">
    <a onclick="return printReport();"><i class="fa fa-print"></i></a>
  </div>
  <div class="visible-print-block print" id="print">
    <?php
    foreach ($reports as $day => $clients):
      ?>
      <div class="date-group-container">
        <h3><?php echo __('Date', 'clipe') . ': ' . $day ?></h3>
        <?php
        foreach ($clients as $clientID => $zones):
          foreach ($zones as $zoneName => $zonesData): ?>
            <h4><? printf("%s - %s", $clientNames[$clientID], $zoneName); ?></h4>
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-condensed table-report">  
                <thead>
                  <tr>
                    <th class="product">
                      <?= __("Producto/sede"); ?>
                    </th>
                    <?php foreach($zonesData['sedes'] as $id => $name): ?>
                      <th class="headquarter-code"><?= $name; ?></th>
                    <?php endforeach; ?>
                    <th class="total"><?= __("Total"); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($zonesData['products'] as $productID => $product): ?>
                  <tr>
                    <td>
                      <?php echo $product['name']; ?>
                    </td>
                    <?php
                    $totalProductQuantity = 0;
                    foreach ($zonesData['sedes'] as $sedeID => $orders):
                      $totalProductQuantity += isset($product['sedes'][$sedeID]) ? $product['sedes'][$sedeID] : 0;
                      ?>
                      <td><?php echo isset($product['sedes'][$sedeID]) ? $product['sedes'][$sedeID] : 0; ?></td>
                    <?php endforeach; ?>
                    <td><?= $totalProductQuantity; ?></td>
                  </tr>
                  <?php endforeach; ?>              
                </tbody>
              </table>
            </div>
          <?php
          endforeach; //zones
        endforeach; //clients ?>
      </div>
    <?php endforeach; //days ?>
  </div>
  <script type="text/javascript">
    function printReport() {
      var clipeStyles = "<?= plugins_url('css/styles.css', __FILE__)?>";
      html = jQuery("#print").html();
      var mywindow = window.open('', 'my div', 'height=400,width=600');
      mywindow.document.write('<html><head><title><?php _e('Report Orders', 'clipe'); ?></title>');
      mywindow.document.write('<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" type="text/css" />');
      mywindow.document.write('<link rel="stylesheet" href="' + clipeStyles + '" type="text/css" />');
      mywindow.document.write('</head><body >');
      mywindow.document.write(html);
      mywindow.document.write('</body></html>');

      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10

      //mywindow.print();
      //mywindow.close();

      return false;
    }
  </script>
  <?php
}
?>
