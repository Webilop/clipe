<div class="form-login row">
  <form method="POST" class="col-md-6">
    <?php $pedidosOnline->html->create('email',array('label_text'=>'Email','class'=>'form-control','div_class'=>'form-group','required'=>true));?>
    <button type="submit" class="btn btn-default pull-left login-submit" id="submit">
      <?php _e('Recovery', 'clipe'); ?>
    </button>
    <?php if(!empty($loginPage)): ?>
    <a class="password-recovery-link" href="<?= $loginPage ?>">
      <?php _e('Login', 'clipe'); ?>
    </a>
    <?php endif; ?>
  </form>
</div>
