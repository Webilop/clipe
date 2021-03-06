<div class="clipe-links pull-right">
  <a title="<?echo __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?echo __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>

<h1><?php _e('Edit Client', 'clipe'); ?></h1>
<form method="POST">
  <div class="row">
    <input type="hidden" name="user_id" value="<?php echo $user->User->id; ?>"/>
    <div class="col-md-6">
      <?php
      $pedidosOnline->html->create('email', array('value'=>$user->User->email,'label_text' => 'Email', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => true));
      $pedidosOnline->html->create('password', array('type' => 'password', 'label_text' => 'Password', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false));
      $pedidosOnline->html->create('confirm_password', array('type' => 'password', 'label_text' => 'Confirm Password', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false));
      $pedidosOnline->html->create('current_password', array('type' => 'password', 'label_text' => 'Current Password', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false));
      ?>
    </div>
    <div class="col-md-6">
      <?php
      $pedidosOnline->html->create('first_name', array('value'=>$user->User->first_name,'label_text' => 'First Name', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false));
      $pedidosOnline->html->create('last_name', array('value'=>$user->User->last_name,'label_text' => 'Last Name', 'class' => 'form-control', 'div_class' => 'form-group', 'required' => false));
      ?>
    </div>
  </div>
  <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
    <?php _e('Update', 'clipe'); ?>
  </button>
  <script type="text/javascript">
    window.onload = function () {
      document.getElementById("password").onchange = requiredPassword;
      document.getElementById("confirm_password").onchange = requiredPassword;
      document.getElementById("current_password").onchange = requiredPassword;
    }
    function requiredPassword() {
      var current_password = document.getElementById("current_password").value;
      var confirm_password = document.getElementById("confirm_password").value;
      var password = document.getElementById("password").value;
      var b_error = false;
      if (password != '' && current_password == '') {
        document.getElementById("current_password").setCustomValidity("<?php _e("if you update the password the current password is required.", "clipe"); ?>");
      }
      else {
        document.getElementById("current_password").setCustomValidity('');
      }
      if (confirm_password != password) {
        document.getElementById("password").setCustomValidity("<?php _e('Password and confirm password Don\'t Match', 'clipe'); ?>");
      }
      else {
        document.getElementById("password").setCustomValidity('');
      }
    }
  </script>
</form>
