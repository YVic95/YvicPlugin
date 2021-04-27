//declaration of variables
const sliderView = document.querySelector( '.testimonial_list' ),
    sliderViewSLides = document.querySelectorAll( '.custom-slider-view-slide' ),
    arrowLeft = document.querySelector( '.arrow-left' ),
    arrowRight = document.querySelector( '.arrow-right' ),
    sliderLength = sliderViewSLides.length;


//sliding function
const slideMe = ( sliderViewItems, isActiveItem ) => {
    //update the classes
    isActiveItem.classList.remove( 'is-active' );
    
    sliderViewItems.classList.add( 'is-active' );

    //css transform the active slide position
    sliderView.setAttribute( 'style', 'transform:translateX(-' + sliderViewItems.offsetLeft + 'px)' );

}

//before sliding function
const beforeSliding = i => {
    
    let isActiveItem = document.querySelector( '.custom-slider-view-slide.is-active' ),
        currentItem = Array.from( sliderViewSLides ).indexOf( isActiveItem ) + i,
        nextItem = currentItem + i,
        sliderViewItems = document.querySelector('.custom-slider-view-slide:nth-child('+ nextItem +')');
    
    // if nextItem is bigger than the # of slides
    if( nextItem > sliderLength ) {
        sliderViewItems = document.querySelector('.custom-slider-view-slide:nth-child(1)');
    }
    
    // if nextItem = 0
    if( nextItem == 0 ) {
        sliderViewItems = document.querySelector('.custom-slider-view-slide:nth-child('+ sliderLength +')');
    }

    //triggering sliding function
    slideMe( sliderViewItems, isActiveItem );
}

//triggering arrows
arrowRight.addEventListener( 'click', () => beforeSliding(1) );
arrowLeft.addEventListener( 'click', () => beforeSliding(0) );
