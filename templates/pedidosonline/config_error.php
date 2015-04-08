<?php
get_header();
?>
<div class="clipe-container">
    <h1><?php _e('Error', 'clipe'); ?></h1>
    <div class='error_message'>
      <?php
        _e('Clipe is not correctly configured in this website.',
          'clipe');
      ?>
    </div>
</div>
<?php
get_sidebar('clipe');
get_footer();
?>
