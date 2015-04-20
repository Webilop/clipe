<?php
global $pedidosOnline;
$pedidosOnline->is_login(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_id'])) {
  $result = $pedidosOnline->edit_client($_POST['client_id']);
  if (isset($result->status) && $result->status == "success") {
    $pedidosOnline->add_flash_message(__($result->data->message, 'clipe'), 'success');
  } elseif (isset($result->status) && $result->status == "fail") {
    $message = array_values(get_object_vars($result->data));
    $pedidosOnline->add_flash_message(__($message[0][0], 'clipe'));
  } else {
    $pedidosOnline->add_flash_message($result);
  }
  //print_r($result);
  //wp_redirect($pedidosOnline->get_link_page('index.php'));
}

if (isset($_GET['id'])) {
  $user = $pedidosOnline->get_user($_GET['id']);
} elseif (empty($_GET['id']) || empty($user)) {
  wp_redirect($pedidosOnline->get_link_page('index.php'));
}

get_header();
?>
<div class="clipe-container">
<?php
if (isset($_GET['id'])) {
  $user = $pedidosOnline->get_user($_GET['id']);
  ?>
    <h1><?php _e('My Client Account', 'clipe'); ?></h1>
    <?php if (in_array('client', $user->permissions)) { ?>
      <form method="POST">
        <input type="hidden" name="client_id" value="<?php echo $user->Client->id; ?>"/>
        <div>
          <label for="email"><?php _e('Email', 'clipe'); ?></label>
          <input type="email" id="mail" name="email" required type="email" value="<?php echo $user->User->email; ?>"/>
        </div>
        <div>
          <label for="password"><?php _e('Password', 'clipe'); ?></label>
          <input type="password" id="password" name="password" required/>
        </div>
        <div>
          <label for="confirm_password"><?php _e('Confirm Password', 'clipe'); ?></label>
          <input type="password" id="confirm_password" name="confirm_password"/>
        </div>
        <div>
          <label for="current_password"><?php _e('Current Password', 'clipe'); ?></label>
          <input type="password" id="current_password" name="current_password"/>
        </div>
        <div>
          <label for="name"><?php _e('Name', 'clipe'); ?></label>
          <input type="text" id="name" name="name" value="<?php echo $user->Client->name; ?>"/>
        </div>
        <div>
          <label for="first_name"><?php _e('First Name', 'clipe'); ?></label>
          <input type="text" id="first_name" name="first_name" value="<?php echo $user->User->first_name; ?>"/>
        </div>
        <div>
          <label for="last_name"><?php _e('Last Name', 'clipe'); ?></label>
          <input type="text" id="last_name" name="last_name" value="<?php echo $user->User->last_name; ?>"/>
        </div>
        <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="button" id="submit" name="submit">
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
              document.getElementById("password").setCustomValidity("<?php _e("Password and confirm password Don't Match", "clipe"); ?>");
            }
            else {
              document.getElementById("password").setCustomValidity('');
            }
          }
        </script>
      </form>
  <?php
  } else {
    wp_redirect($pedidosOnline->get_link_page('index.php'));
  }
  ?>

    <div class="clipe-links">
      <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
      <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
      <a href="<?php echo $pedidosOnline->get_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
    </div>
    <?php
  } else {
    ?>
    <h1><?php _e('Error', 'clipe') ?></h1>
    <?php
  }
  ?>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>


