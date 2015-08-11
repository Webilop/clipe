<?php
global $pedidosOnline;
//load controller
$pedidosOnline->load_controller();

get_header();
?>
<div class="clipe-container">
  <?php $pedidosOnline->load_view(); ?>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>

