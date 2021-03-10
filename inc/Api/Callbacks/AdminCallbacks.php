<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Api\Callbacks;
use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
  public function adminDashboard() {
    return require_once( "$this->plugin_path/templates/admin.php" );
  }

  public function adminCpt() {
    return require_once( "$this->plugin_path/templates/cpt.php" );
  }

  public function adminTaxonomies() {
    return require_once( "$this->plugin_path/templates/taxonomies.php" );
  }

  public function adminWidgets() {
    return require_once( "$this->plugin_path/templates/widgets.php" );
  }
  public function adminGallery() {
    return require_once( "$this->plugin_path/templates/gallery.php" );
  }
  public function adminTestimonial() {
    return require_once( "$this->plugin_path/templates/testimonial.php" );
  }
  public function adminTemplate() {
    return require_once( "$this->plugin_path/templates/template_mng.php" );
  }
  public function adminChat() {
    return require_once( "$this->plugin_path/templates/chat.php" );
  }
  public function adminMembership() {
    return require_once( "$this->plugin_path/templates/membership.php" );
  }
  public function adminLogin() {
    return require_once( "$this->plugin_path/templates/login.php" );
  }
  public function yvicTextExample() {
    $value = esc_attr( get_option( 'text_example' ) );
    echo '<input type="text" class="regular-text" name="text_example" value="'. $value .'" 
    placeholder="Write Something Here!">';
  }

  public function yvicFirstName() {
    $value = esc_attr( get_option( 'first_name' ) );
    echo '<input type="text" class="regular-text" name="first_name" value="'. $value .'" 
    placeholder="Write Your First Name Here!">';
  }
  
}