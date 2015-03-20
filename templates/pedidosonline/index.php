<?php
get_header();
global $pedidosOnline;
$pedidosOnline->is_login(true);
?>
<div>
  <h1>index</h1>
  <p><a href="<?php echo $pedidosOnline->get_link_page('list_clients.php');?>">list of Client</a></p>
  <p><a href="<?php echo $pedidosOnline->get_link_page('create_client.php');?>">Create of Client</a></p>
</div>
<?php
get_sidebar();
get_footer();
?>
