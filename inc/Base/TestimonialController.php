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

      add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

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

  public function add_meta_boxes() {

    add_meta_box(
      'testimonial',
      'Author',
      array( $this, 'author_box' ),
      'testimonial',
      'side',
      'default'
    );

  }

  public function author_box( $post ) {
    
    wp_nonce_field( 'yvic_testimonial_author', 'yvic_testimonial_author_nonce' );

    $value = get_post_meta( $post->ID, '_yvic_testimonial_author_key', true );

    ?>
    
    <label for="yvic_testimonial_author">Testimonial Author</label>
    <input type="text" id="yvic_testimonial_author" name="yvic_testimonial_author" value="<?php echo esc_attr( $value ); ?>">

    <?php 

  }

    
}