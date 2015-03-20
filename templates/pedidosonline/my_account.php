<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
?>
<div class="clipe-container">
  <?php
  if (isset($_GET['id'])) {
    $user = $pedidosOnline->get_user($_GET['id']);
    print_r($user);
    exit;
    ?>
    <h1><?php _e('My account', 'clipe'); ?> => <?php echo $user->Client->name; ?></h1>
    <form method="POST">
      <div>
        <label for="email"><?php _e('Email', 'clipe'); ?></label>
        <input type="email" id="mail" name="email" required type="email" value="<?php $user->email; ?>"/>
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
        <label for="first_name"><?php _e('First Name', 'clipe'); ?></label>
        <input type="text" id="first_name" name="first_name" value="<?php $user->first_name; ?>"/>
      </div>
      <div>
        <label for="last_name"><?php _e('Last Name', 'clipe'); ?></label>
        <input type="text" id="last_name" name="last_name" value="<?php $user->last_name; ?>"/>
      </div>

      <div>
        <label for="name"><?php _e('Name', 'clipe'); ?></label>
        <input type="text" id="name" name="name" value="<?php $user->name; ?>"/>
      </div>
      <div>
        <label for="address"><?php _e('Address', 'clipe'); ?></label>
        <input type="text" id="address" name="address" value="<?php $user->address; ?>"/>
      </div>
      <div>
        <label for="phone"><?php _e('Phone', 'clipe'); ?></label>
        <input type="text" id="phone" name="phone" value="<?php $user->phone; ?>"/>
      </div>
      <div>
        <label for="url"><?php _e('Url', 'clipe'); ?></label>
        <input type="url" id="url" name="url" value="<?php $user->url; ?>"/>
      </div>
      <input type="submit" value="<?php _e('Update', 'clipe'); ?>" class="button" id="submit" name="submit">
    </form>

    <div class="clipe-links">
      <a href="<?php echo $pedidosOnline->get_link_page('client_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
      <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
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
get_sidebar();
get_footer();
?>


