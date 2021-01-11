<div class="wrap">
  <h1>HEy, this is smth!</h1>
  <?php settings_errors() ?>

  <form method="post" action="options.php">
    <?php 
      settings_fields( 'yvic_options_group' );
      do_settings_sections( 'yvic_plugin' );
      submit_button();
    ?>
  </form>
</div>