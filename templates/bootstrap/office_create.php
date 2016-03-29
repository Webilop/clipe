<div class="clipe-links pull-right">
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?= $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?= $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?php _e('Create Headquarter', 'clipe'); ?></h1>
<form method="POST">
  <div class="row">
    <div class="col-md-6">
      <?php
      $pedidosOnline->html->create('client_id',
        array(
          'type' => 'select',
          'options' => $clients,
          'label_text' => 'Client',
          'class' => 'form-control',
          'div_class' => 'form-group',
          'options_empty' => true,
          'value' => key_exists('client_id', $_GET)? $_GET['client_id'] : null
        )
      );
      $pedidosOnline->html->create('address',
        array('label_text' => 'Address',
              'class' => 'form-control',
              'div_class' => 'form-group',
              'required' => true));
      $pedidosOnline->html->create('phone',
        array(
          'label_text' => 'Phone','class' => 'form-control',
          'div_class' => 'form-group','required' => true));
      $pedidosOnline->html->create('email',
        array(
          'label_text' => 'Email','class' => 'form-control',
          'div_class' => 'form-group','required' => true));
      $pedidosOnline->html->create('code',
        array(
          'label_text' => 'code','class' => 'form-control',
          'div_class' => 'form-group','required' => true));
      $pedidosOnline->html->create('short_name',
        array(
          'label_text' => 'Short Name Office','class' => 'form-control',
          'div_class' => 'form-group','required' => false));
      $pedidosOnline->html->create('zone',
        array(
          'label_text' => 'Zone','class' => 'form-control',
          'div_class' => 'form-group','required' => true));
      $pedidosOnline->html->create('delivery_days',
        array(
          'type' => 'checkbox',
          'options' => $days,
          'label_text' => 'Delivery Days',
          'label_id' => 'delivery_label',
          'class' => 'form-control',
          'div_class' => 'form-group',
          'required' => true));
      ?>
    </div>
  </div>
  <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
    <?php _e('Create', 'clipe'); ?>
  </button>
</form>
<script type="text/javascript">
  window.onload = function () {
    document.getElementById("submit").onclick = requiredDays;
  }
  function requiredDays() {
    var b_error = true;
    jQuery("input[name='delivery_days[]']:checked").each(function () {
      b_error = false;
      return false;
    });
    if (b_error) {
      document.getElementById('delivery_label').setCustomValidity('<?php _e('required to select at least one', 'clipe') ?>');
    } else {
      document.getElementById('delivery_label').setCustomValidity('');
    }
    return true;
  }
</script>
