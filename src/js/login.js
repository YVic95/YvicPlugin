document.addEventListener( 'DOMContentLoaded', (e) => {
    const showAuthenticationBtn = document.getElementById('show-btn'),
        authenticationContainer = document.getElementById('yvic-authentication-container'),
        close = document.getElementById('yvic-authentication-close');
        console.log('works');

        showAuthenticationBtn.addEventListener( 'click', () => {
            console.log(e);
            authenticationContainer.classList.add( 'show' );
            showAuthenticationBtn.classList.add( 'hide' );
        } );

        close.addEventListener( 'click', () => {
            authenticationContainer.classList.remove( 'show' );
            showAuthenticationBtn.classList.remove( 'hide' );
        });
} )