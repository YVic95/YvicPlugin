document.addEventListener( 'DOMContentLoaded', (e) => {
    const showAuthenticationBtn = document.getElementById('show-btn'),
        authenticationContainer = document.getElementById('yvic-authentication-container'),
        close = document.getElementById('yvic-authentication-close'),
        authenticationForm = document.getElementById( 'yvic-authentication-form' ),
        status = authenticationForm.querySelector( '[data-message="status"]' );


        showAuthenticationBtn.addEventListener( 'click', () => {
            authenticationContainer.classList.add( 'show' );
            showAuthenticationBtn.classList.add( 'hide' );
        } );

        close.addEventListener( 'click', () => {
            authenticationContainer.classList.remove( 'show' );
            showAuthenticationBtn.classList.remove( 'hide' );
        });

        authenticationForm.addEventListener( 'submit', e => {
            e.preventDefault();

            //reset form messages
            resetMessages();

             //collect all the data
            let data = {
            name: document.querySelector( '[name="username"]' ).value,
            password: document.querySelector( '[name="password"]' ).value,
            nonce: document.querySelector( '[name="yvic-authentication"]' ).value
            }

            //data validation
            if( !data.name || !data.password ) {
                status.innerHTML = "Missing Data";
                status.classList.add( 'error' );
                return;
            }

            //ajax http post request
            let url = authenticationForm.dataset.url;
            
            let params = new URLSearchParams( new FormData( authenticationForm ) );

            authenticationForm.querySelector( '[name="submit"]' ).value = 'You are logging in...';
            authenticationForm.querySelector( '[name="submit"]' ).disabeled = true;

            fetch( url, {
                method: "POST",
                body: params
            }).then( res => res.json() )
                .catch( error => {
                    resetMessages(); } )
                .then( response => {
                    resetMessages();
                    if( response === 0 || !response.status ) {
                        status.innerHTML = response.message;
                        status.classList.add( 'error' );
                        return;
                    }

                    status.innerHTML = response.message;
                    status.classList.add( 'success' );
                    authenticationForm.reset();

                    window.location.reload();
                } )

        } );

        function resetMessages() {
            //reseting all the messages
            status.innerHTML = "";
            status.classList.remove( 'error', 'success' );
            authenticationForm.querySelector( '[name="submit"]' ).value = 'Login';
            authenticationForm.querySelector( '[name="submit"]' ).disabeled = false;
        }
} )