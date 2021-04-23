<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\TestimonialCallbacks;



class TestimonialController extends BaseController
{
  public $settings;

  public $callbacks;

  public function register() {
      
      if( ! $this->activated( 'testimonial_manager' ) ) { return; }

      $this->settings = new SettingsApi();

      $this->callbacks = new TestimonialCallbacks();

      add_action( 'init', array( $this, 'testimonial_post_type' ) );

      add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

      add_action( 'save_post', array( $this, 'save_meta_post' ) ); 

      add_action( 'manage_testimonial_posts_columns', array( $this, 'set_custom_columns' ) );

      add_action( 'manage_testimonial_posts_custom_column', array( $this, 'set_custom_columns_data' ), 10, 2 );

      add_filter( 'manage_edit-testimonial_sortable_columns', array( $this, 'set_custom_columns_sortable' ) );

      $this->setShortcodePage();

      add_shortcode( 'testimonial-form', array( $this, 'testimonial_form' ) ); 

      add_shortcode( 'testimonial-slideshow', array( $this, 'testimonial_slideshow' ) );

      add_action( 'wp_ajax_submit_testimonial', array( $this, 'submition_testimonial' ) );
      
      add_action( 'wp_ajax_nopriv_submit_testimonial', array( $this, 'submition_testimonial' ) ); 
      
  }

  public function submition_testimonial() {
    
    //sanitize the data;

    if( ! DOING_AJAX || ! check_ajax_referer( 'testimonial-nonce', 'nonce' ) ) {
      return $this->return_json( 'error' );
    }

    

    $name = sanitize_text_field( $_POST['name'] );
    $email = sanitize_email( $_POST['email'] );
    $message = sanitize_textarea_field( $_POST['message'] );

    //store the data to the Testimonial CPT;

    $data = array(
      'name'           => $name,
      'email'          => $email,
      'approval_value' => 0,
      'featured_value' => 0
    );

    $args = array(
      'post_title'   => 'Testimonial from ' . $name,
      'post_content' => $message,
      'post_author'  => 1,
      'post_status'  => 'publish',
      'post_type'    => 'testimonial',
      'meta_input'   => array(
        '_yvic_testimonial_key' => $data
      ) 
    );

    $postID = wp_insert_post( $args );

    //send response;

    if( $postID ) {
      return $this->return_json( 'success' );
    }

    return $this->return_json( 'error' );
  }

  public function return_json( $status ) {
    $return = array(
      'status' => $status
    );

    wp_send_json( $return );
    wp_die();
  } 

  public function setShortcodePage() {

    $subpage = array(
      array(
        'parent_slug' => 'edit.php?post_type=testimonial',
        'page_title'  => 'Shortcodes',
        'menu_title'  => 'Shortcodes',
        'capability'  => 'manage_options', 
        'menu_slug'   => 'yvic_testimonial_shortcode',
        'callback'    => array( $this->callbacks, 'shortcodePage' )
      )
    );

    $this->settings->addSubpages( $subpage )->register();
    
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
        array( $this, 'render_features_box' ),
        'testimonial',
        'side',
        'default'
      );
  }

  public function render_features_box( $post ) {
    
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

    $nonce = isset ( $_POST['yvic_testimonial_nonce'] ) ? $_POST['yvic_testimonial_nonce'] : null;

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
      'email' => sanitize_email( $_POST['yvic_testimonial_email'] ),
      'approval_value' => isset( $_POST['yvic_testimonial_approval'] ) ? 1 : 0,
      'featured_value' => isset( $_POST['yvic_testimonial_featured'] ) ? 1 : 0

    );

    update_post_meta( $post_id, '_yvic_testimonial_key', $data );

  }

  public function set_custom_columns( $columns ) {
    
    $title = $columns['title'];
    $date = $columns['date'];
    unset( $columns['title'], $columns['date'] );

    $columns['name'] = 'Author Name';
    $columns['title'] = $title;
    $columns['approval_value'] = 'Approved';
    $columns['featured_value'] = 'Featured';
    $columns['date'] = $date;

    return $columns;

  }

  public function set_custom_columns_data( $column, $post_id ) {

    $data = get_post_meta( $post_id, '_yvic_testimonial_key', true );

    $name = isset( $data['name'] ) ? $data['name'] : '';

    $email = isset( $data['email'] ) ? $data['email'] : '';

    $approval_value = isset( $data['approval_value'] ) && $data['approval_value'] === 1 ? '<strong>YES</strong>'  : 'NO';

    $featured_value = isset( $data['featured_value'] ) && $data['featured_value'] === 1 ? '<strong>YES</strong>'  : 'NO';

    switch( $column ) {
      case 'name': 
        echo '<strong>'. $name .'</strong><br><a hfer="mailto:'. $email .'">'. $email .'</a>';
        break;
      
      case 'approval_value':
        echo $approval_value;
        break;

      case 'featured_value':
        echo $featured_value;
        break;

    }

  }

  public function set_custom_columns_sortable( $columns ) {

    $columns['name'] = 'name';
    $columns['approval_value'] = 'approval_value';
    $columns['featured_value'] = 'featured_value';

    return $columns;

  }

  public function testimonial_form() {

    ob_start();

    echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/css/form.min.css \" type=\"text/css\" media=\"all\">";

    require_once( "$this->plugin_path/templates/testimonial-form.php" );

    echo "<script src=\"$this->plugin_url/assets/js/form.min.js \"></script>";

    return ob_get_clean();

  }

  public function testimonial_slideshow() {

    ob_start();

    echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/css/slider.min.css \" type=\"text/css\" media=\"all\">";

    require_once( "$this->plugin_path/templates/slider.php" );

    echo "<script src=\"$this->plugin_url/assets/js/slider.min.js \"></script>";

    return ob_get_clean();

  }
  
}