document.addEventListener( 'DOMContentLoaded', function(e) {
    let testimonialForm = document.getElementById('yvic-testimonial-form');

    testimonialForm.addEventListener( 'submit', (e) => {
        e.preventDefault();

        //reset the form messages
        resetMessage();

        //collect all the data
        let data = {
            name: document.querySelector( '[name="name"]' ).value,
            email: document.querySelector( '[name="email"]' ).value,
            message: document.querySelector( '[name="message"]' ).value
        }
        
        //data validation
        if( ! data.name ) {
            testimonialForm.querySelector( '[data-error="invalidName"]' ).classList.add( 'show' );
            return;
        }

        if( ! validateEmail( data.email ) ) {
            testimonialForm.querySelector( '[data-error="invalidEmail"]' ).classList.add( 'show' );
            return;
        }

        if( ! data.message ) {
            testimonialForm.querySelector( '[data-error="invalidMessage"]' ).classList.add( 'show' );
            return;
        }
        

        //ajax http post request
        let url = testimonialForm.dataset.url;
        let params = new URLSearchParams( new FormData( testimonialForm ) );

        console.log( params);

        testimonialForm.querySelector( '.js-form-submission' ).classList.add( 'show' );
        
        fetch( url, {
            method: "POST",
            body: params
        }).then( res => res.json() )
            .catch(error => {
                resetMessage();
                testimonialForm.querySelector( '.js-form-error' ).classList.add( 'show' );
            })
            .then( response => {
                resetMessage();
                //dealing with response
            } )
        
    } );

} );

function resetMessage() {
    document.querySelectorAll( '.msg-holder' ).forEach( msg => msg.classList.remove( 'show' ) );
}

function validateEmail( email ) {
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}