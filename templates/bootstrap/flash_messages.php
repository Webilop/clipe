<?php
global $pedidosOnline;
$currentMessages = $pedidosOnline->get_flash_messages();
if(!empty($currentMessages)):
?>
<div class="clipe-flash-messages">
  <?php foreach($currentMessages as $message): ?>
  <div class="alert alert-<?= $message['type']; ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?= $message['message']; ?>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
