<?php
global $pedidosOnline;
$currentMessages = $pedidosOnline->get_flash_messages();
if(!empty($currentMessages)):
?>
<div class="clipe-flash-messages">
  <?php foreach($currentMessages as $message): ?>
  <div class="<?= $message['type']; ?>"><?= $message['message']; ?></div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
