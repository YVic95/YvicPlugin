<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;


class TestimonialController extends BaseController
{
  public function register() {
      
      if( ! $this->activated( 'testimonial_manager' ) ) { return; }

      add_action( 'init', array( $this, 'testimonial_post_type' ) );

  }

  public function testimonial_post_type() {

    $labels = array(
      'name'          => 'Testimonials',
      'singular_name' => 'Testimonial'
    );

    $args = array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => false,
      'menu_icon' => 'dashicons-testimonial',
      'exclude_from_search' => true,
      'publicly_queriable' => false,
      'supports' => array( 'title', 'editor' )
    );
    
    register_post_type( 'testimonial', $args );

  }

    
}