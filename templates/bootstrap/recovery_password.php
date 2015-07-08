<div class="form-login row">
  <form method="POST" class="col-md-6">
    <div class="form-group">
      <label for="email"><?php _e('Email', 'clipe'); ?></label>
      <input class="form-control" type="email" id="login_email" name="email" required/>
    </div>
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
