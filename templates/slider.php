<?php 

$args = array(
    'post_type' => 'testimonial',
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'meta_query' => array(
        array(
            'key' => '_yvic_testimonial_key',
            'value' => 's:14:"approval_value";i:1;s:14:"featured_value";i:1;',
            'compare' => 'LIKE'
        )
    ) 
);

$query = new WP_QUERY( $args );

if( $query->have_posts() ) :
    $i = 1;
    echo '<div class="custom-slider-wrap"><div class="custom-slider-container">
    <div class="custom-slider-view"><ul class="testimonial_list">';

        while( $query->have_posts() ) : $query->the_post();
            $data = get_post_meta( get_the_ID(),'_yvic_testimonial_key', true );
            $name = $data['name'] ?? '';
            echo '<li class="custom-slider-view-slide'.( $i === 1 ? ' is-active' : '' ).'"><p class="testimonial-message">'. get_the_content() .'</p><p class="testimonial-author">~'. $name .'~</p></li>';
            $i++;  
        endwhile;

    echo '</ul></div><div class="custom-slider-arrows"><span class="arrow arrow-left">&#60;</span>
    <span class="arrow arrow-right">&#62;</span></div></div></div>';
endif;

wp_reset_postdata();