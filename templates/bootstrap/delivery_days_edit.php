<div class="clipe-links pull-right">
  <a title="<?= __('Clients', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('client_view.php').'&id='.$_GET['client']; ?>"><i class="fa fa-list"></i></a>
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>

<h1><?php _e('Edit client headquarters', 'clipe'); ?></h1>
<div class="row">
  <form method="POST" class="col-md-6">
    <input type="hidden" name="client_id" value="<?= $_GET['client']; ?>"/>
    <?php
    $pedidosOnline->html->create('zone',array('value'=>(isset($zone->name) ? $zone->name : ''),'label_text'=>'Zone','class'=>'form-control','div_class'=>'form-group','required'=>true));
    $pedidosOnline->html->create('Code',array('value'=>$code,'label_text'=>'Code','class'=>'form-control','div_class'=>'form-group','required'=>true));
    $pedidosOnline->html->create('delivery_days',array('value'=>$delivery_days,'type'=>'checkbox','options'=>$days,'label_text'=>'Delivery Days','class'=>'form-control','div_class'=>'form-group','required'=>true));
    ?>
    <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
      <?php _e('Update', 'clipe'); ?>
    </button>
    <script type="text/javascript">
      window.onload = function () {
        document.getElementById("submit").onclick = requiredDays;
      }
      function requiredDays() {
        b_error = true;
        jQuery("input[name='delivery_days[]']:checked").each(function () {
          b_error = false;
          return false;
        });
        if (b_error) {
          document.getElementById("Domingo").setCustomValidity('<?php _e('required to select at least one', 'clipe') ?>');
        } else {
          document.getElementById("Domingo").setCustomValidity('');
        }
        return true;
      }
    </script>
  </form>
</div>
