<div class="clipe-links pull-right">
  <a title="<?= __('Dashboard', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
  <a title="<?= __('Logout', 'clipe'); ?>" href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
</div>

<h1><?php _e('Edit Client', 'clipe'); ?></h1>
<form method="POST">
  <input type="hidden" name="client_id" value="<?php echo $user->Client->id; ?>"/>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label class="required" for="email"><?php _e('Email', 'clipe'); ?></label>
        <input class="form-control" type="email" id="mail" name="email" required type="email" value="<?php echo $user->User->email; ?>"/>
      </div>
      <div class="form-group">
        <label for="password"><?php _e('Password', 'clipe'); ?></label>
        <input class="form-control" type="password" id="password" name="password"/>
      </div>
      <div class="form-group">
        <label for="confirm_password"><?php _e('Confirm Password', 'clipe'); ?></label>
        <input class="form-control" type="password" id="confirm_password" name="confirm_password"/>
      </div>
      <div class="form-group">
        <label for="current_password"><?php _e('Current Password', 'clipe'); ?></label>
        <input class="form-control" type="password" id="current_password" name="current_password"/>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="first_name"><?php _e('First Name', 'clipe'); ?></label>
        <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo $user->User->first_name; ?>"/>
      </div>
      <div class="form-group">
        <label for="last_name"><?php _e('Last Name', 'clipe'); ?></label>
        <input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo $user->User->last_name; ?>"/>
      </div>
      <div class="form-group">
        <label class="required" for="name"><?php _e('Business Name', 'clipe'); ?></label>
        <input required class="form-control" type="text" id="name" name="name" value="<?php echo $user->Client->name; ?>"/>
      </div>
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
