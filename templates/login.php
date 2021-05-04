<form id="yvic-authentication-form" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
    <div class="authentication-button">
        <input class="yvic-show-authentication-button" type="button" value="Login" >
    </div>
    <div id="yvic-authentication-container" class="authentication-container">
        <a id="yvic-authentication-close" class="close" href="#">&times;</a>
        <h2>Site login</h2>
        <label for="username">Username</label>
        <input id="username" type="text" name="username">
        <label for="password">Password</label>
        <input id="password" type="password" name="password">
        <input class="submit_button" type="submit" value="Login" name="submit">
        <p class="status"></p>
        <p class="actions">
            <a href="<?php echo wp_lostpassword_url(); ?>">Forgot password?</a> /
            <a href="<?php echo wp_registration_url(); ?>">Registration</a>
        </p>
        <?php wp_nonce_field( 'ajax-login-nonce', 'yvic-authentication' ); ?>
    </div>
</form>