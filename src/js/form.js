document.addEventListener( 'DOMContentLoaded', function(e) {
    let testimonialForm = document.getElementById('yvic-testimonial-form');

    testimonialForm.addEventListener( 'submit', (e) => {
        e.preventDefault();
        console.log('Submit has been prevented');
    } );
} );