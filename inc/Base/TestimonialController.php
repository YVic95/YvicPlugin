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
    $meta_box_names = array('Author', 'Email Address', 'Approval', 'Featured');
    foreach($meta_box_names as $name) {
      add_meta_box(
        'testimonial',
        $name,
        array( $this, 'author_box' ),
        'testimonial',
        'side',
        'default'
      );
    }
  
  }

  public function author_box( $post ) {
    
    wp_nonce_field( 'yvic_testimonial_author', 'yvic_testimonial_author_nonce' );

    $value = get_post_meta( $post->ID, '_yvic_testimonial_author_key', true );

    wp_nonce_field( 'yvic_testimonial_author_email', 'yvic_testimonial_author_email_nonce' );
    
    $email_value = get_post_meta( $post->ID, '_yvic_testimonial_author_email_key', true );

    wp_nonce_field( 'yvic_testimonial_author_approval', 'yvic_testimonial_author_approval_nonce' );
    
    $approval_value = get_post_meta( $post->ID, '_yvic_testimonial_author_approval_key', true );

    wp_nonce_field( 'yvic_testimonial_author_featured', 'yvic_testimonial_author_featured_nonce' );
    
    $featured_value = get_post_meta( $post->ID, '_yvic_testimonial_author_featured_key', true );


    ?>

    <label for="yvic_testimonial_author">Testimonial Author</label>
    <input type="text" id="yvic_testimonial_author" name="yvic_testimonial_author" value="<?php echo esc_attr( $value ); ?>">

    <label for="yvic_testimonial_author_email">Email Address</label>
    <input type="text" id="yvic_testimonial_author_email" name="yvic_testimonial_author_email" value="<?php echo esc_attr( $email_value ); ?>">
    
    <div class="testimonial_box">
      <label for="yvic_testimonial_author_approval">Approval</label>
      <div class="ui-toggle">
        <input type="checkbox" id="yvic_testimonial_author_approval" name="yvic_testimonial_author_approval" value="1" <?php echo esc_attr( $approval_value ) ? 'checked' : ''; ?>>
        <label for="yvic_testimonial_author_approval"><div></div></label>
      </div>
    </div>

    <div class="testimonial_box">
      <label for="yvic_testimonial_author_featured">Featured</label>
      <div class="ui-toggle">
        <input type="checkbox" id="yvic_testimonial_author_featured" name="yvic_testimonial_author_featured" value="1" <?php echo esc_attr( $featured_value ) ? 'checked' : ''; ?>>
        <label for="yvic_testimonial_author_featured"><div></div></label>
      </div>
    </div>

    <?php 

  }


  public function save_meta_post( $post_id ) {

    $nonce = $_POST['yvic_testimonial_author_nonce'];
    $email_nonce = $_POST['yvic_testimonial_author_email_nonce'];
    $approval_nonce = $_POST['yvic_testimonial_author_approval_nonce'];
    $featured_nonce = $_POST['yvic_testimonial_author_featured_nonce'];

    if( ! isset( $nonce ) || ! isset( $email_nonce ) || ! isset( $approval_nonce ) || !isset( $featured_nonce ) ) {

      return  $post_id;

    }
   
    if( ! wp_verify_nonce( $nonce, 'yvic_testimonial_author' ) || ! wp_verify_nonce( $email_nonce, 'yvic_testimonial_author_email' ) || 
    ! wp_verify_nonce( $approval_nonce, 'yvic_testimonial_author_approval' ) || ! wp_verify_nonce( $featured_nonce, 'yvic_testimonial_author_featured' ) ) {

      return  $post_id;

    }

    if( ! current_user_can( 'edit_post', $post_id ) ) {

      return  $post_id;

    }

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      
      return  $post_id;

    }

    $data = sanitize_text_field( $_POST['yvic_testimonial_author'] ); 
    update_post_meta( $post_id, '_yvic_testimonial_author_key', $data );

    $email_data = sanitize_text_field( $_POST['yvic_testimonial_author_email'] ); 
    update_post_meta( $post_id, '_yvic_testimonial_author_email_key', $email_data );

    $approval_data = filter_var($_POST['yvic_testimonial_author_approval'], FILTER_SANITIZE_NUMBER_INT); 
    update_post_meta( $post_id, '_yvic_testimonial_author_approval_key', $approval_data );

    $featured_data = filter_var($_POST['yvic_testimonial_author_featured'], FILTER_SANITIZE_NUMBER_INT); 
    update_post_meta( $post_id, '_yvic_testimonial_author_featured_key', $featured_data );
  }

    
}