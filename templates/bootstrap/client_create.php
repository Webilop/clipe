<div class="clipe-links pull-right">
  <a title="<?echo __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?echo __('List', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
  <a title="<?echo __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>
<h1><?= __("Create Client", "clipe") ?></h1>

<div class="row">
  <form method="POST" class="col-md-6">
    <?php
      $pedidosOnline->html->create('name',array('label_text'=>'Name','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('email',array('label_text'=>'Email','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('address',array('label_text'=>'Adress','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('phone',array('label_text'=>'Phone','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('Code',array('label_text'=>'Code','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('short_name',array('label_text'=>'Short Name Office','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('zone',array('label_text'=>'Zone','class'=>'form-control','div_class'=>'form-group','required'=>true));
      $pedidosOnline->html->create('delivery_days',array('type'=>'checkbox','options'=>$days,'label_text'=>'Delivery Days','class'=>'form-control','div_class'=>'form-group','required'=>true));
    ?>
    <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
      <?php _e('Create', 'clipe'); ?>
    </button>
  </form>
</div>

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
