<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
$office=$pedidosOnline->get_office($_GET['id']);
//print_r($office->HeadquartersProvider->{0}->provider_id);
?>
<div class="clipe-container">
    <h1><?php _e('Office', 'clipe'); ?></h1>

    <div>
      <label for="address"><?php _e('Address', 'clipe'); ?></label>
      <input type="text" id="address" name="address" value="<?php echo $office->Headquarters->address;?>" required/>
    </div>
    <div>
      <label for="phone"><?php _e('Phone', 'clipe'); ?></label>
      <input type="text" id="phone" name="phone" value="<?php echo $office->Headquarters->phone;?>" required/>
    </div>
    <div>
      <label for="email"><?php _e('Email', 'clipe'); ?></label>
      <input type="email" id="email" name="email" value="<?php echo $office->Headquarters->email;?>" required/>
    </div>
    <div>
      <label for="provider_id"><?php _e('Provider', 'clipe'); ?></label>
      <select id="provider_id" name="provider_id" required disabled>
        <option value="" >----------</option>
        <?php echo $pedidosOnline->get_providers_client_options($office->HeadquartersProvider->{0}->provider_id);?>
      </select>
    </div>

    <div class="clipe-links">
      <a href="<?php echo $pedidosOnline->get_link_page('office_list.php'); ?>"><i class="fa fa-arrow-left"></i></a>
      <a href="<?php echo $pedidosOnline->get_link_page('index.php'); ?>"><i class="fa fa-home"></i></a>
    </div>
    <?php
  ?>
</div>
<?php
get_sidebar();
get_footer();
?>

