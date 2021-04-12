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

      add_action( 'save_post', array( $this, 'save_meta_post' ) ); 

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
        'testimonial_author',
        'Testimonial Options',
        array( $this, 'render_fetures_box' ),
        'testimonial',
        'side',
        'default'
      );
  }

  public function render_fetures_box( $post ) {
    
    wp_nonce_field( 'yvic_testimonial', 'yvic_testimonial_nonce' );

    $data = get_post_meta( $post->ID, '_yvic_testimonial_key', true );

    $name = isset( $data['name'] ) ? $data['name'] : '';

    $email = isset( $data['email'] ) ? $data['email'] : '';

    $approval_value = isset( $data['approval_value'] ) ? $data['approval_value'] : false;

    $featured_value = isset( $data['featured_value'] ) ? $data['featured_value'] : false;

    ?>

    <label for="yvic_testimonial_author">Testimonial Author</label>
    <input type="text" id="yvic_testimonial_author" name="yvic_testimonial_author" value="<?php echo esc_attr( $name ); ?>">

    <label for="yvic_testimonial_email">Email Address</label>
    <input type="text" id="yvic_testimonial_email" name="yvic_testimonial_email" value="<?php echo esc_attr( $email ); ?>">
    
    <div class="testimonial_box">
      <label for="yvic_testimonial_approval">Approved</label>
      <div class="ui-toggle">
        <input type="checkbox" id="yvic_testimonial_approval" name="yvic_testimonial_approval" value="1" <?php echo esc_attr( $approval_value ) ? 'checked' : ''; ?>>
        <label for="yvic_testimonial_approval"><div></div></label>
      </div>
    </div>

    <div class="testimonial_box">
      <label for="yvic_testimonial_featured">Featured</label>
      <div class="ui-toggle">
        <input type="checkbox" id="yvic_testimonial_featured" name="yvic_testimonial_featured" value="1" <?php echo esc_attr( $featured_value ) ? 'checked' : ''; ?>>
        <label for="yvic_testimonial_featured"><div></div></label>
      </div>
    </div>

    <?php 

  }


  public function save_meta_post( $post_id ) {

    $nonce = $_POST['yvic_testimonial_nonce'];
    // $email_nonce = $_POST['yvic_testimonial_author_email_nonce'];
    // $approval_nonce = $_POST['yvic_testimonial_author_approval_nonce'];
    // $featured_nonce = $_POST['yvic_testimonial_author_featured_nonce'];

    if( ! isset( $nonce ) ) {

      return  $post_id;

    }
   
    if( ! wp_verify_nonce( $nonce, 'yvic_testimonial' ) ) {

      return  $post_id;

    }

    if( ! current_user_can( 'edit_post', $post_id ) ) {

      return  $post_id;

    }

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      
      return  $post_id;

    }

    $data = array(

      'name' => sanitize_text_field( $_POST['yvic_testimonial_author'] ),
      'email' => sanitize_text_field( $_POST['yvic_testimonial_email'] ),
      'approval_value' => isset( $_POST['yvic_testimonial_approval'] ) ? 1 : 0,
      'featured_value' => isset( $_POST['yvic_testimonial_featured'] ) ? 1 : 0

    );

    update_post_meta( $post_id, '_yvic_testimonial_key', $data );

  }

    
}