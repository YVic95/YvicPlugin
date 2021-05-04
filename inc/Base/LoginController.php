<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;

use Inc\Base\BaseController;

class LoginController extends BaseController
{
  public function register() {
      
    if( ! $this->activated( 'login_manager' ) ) { return; }

    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

    add_action( 'wp_head', array( $this, 'add_login_template' ) );

  }

  public function enqueue() {
    
    wp_enqueue_style( 'loginStyle', $this->plugin_url . 'assets/css/login.min.css' );
    wp_enqueue_script( 'loginScript', $this->plugin_url . 'assets/js/login.min.js' );

  }

  public function add_login_template() {

    $file = $this->plugin_path . 'templates/login.php';
    
    if( file_exists( $file ) ) {

      load_template( $file, true );

    }

  }

}