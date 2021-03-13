<div class="wrap">
    <h1>CPT Manager</h1>
    <?php settings_errors() ?>
    <form method="post" action="options.php">
    <?php 
        settings_fields( 'yvic_plugin_cpt_settings' );
        do_settings_sections( 'yvic_plugin_cpt' );
        submit_button();
    ?>
    </form>
</div>