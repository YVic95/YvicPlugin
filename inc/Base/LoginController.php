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

    add_action( 'wp_ajax_nopriv_yvic_login', array( $this, 'login' ) );

  }

  public function enqueue() {

    if( is_user_logged_in() ) { return; }
    
    wp_enqueue_style( 'loginStyle', $this->plugin_url . 'assets/css/login.min.css' );
    wp_enqueue_script( 'loginScript', $this->plugin_url . 'assets/js/login.min.js' );

  }

  public function add_login_template() {

    if( is_user_logged_in() ) { return; }

    $file = $this->plugin_path . 'templates/login.php';
    
    if( file_exists( $file ) ) {

      load_template( $file, true );

    }

  }

  public function login() {

    check_ajax_referer( 'ajax-login-nonce', 'yvic-authentication' );

    $info = array();

    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;
    
    $userSignOn = wp_signon( $info );

    if( is_wp_error( $userSignOn ) ) {
      echo json_encode(
        array(
          'status' => false,
          'message' => 'Wrong username or password'
        )
      );
      die();
    }

    echo json_encode(
      array(
        'status' => true,
        'message' => 'Login successfull, redirecting to ...'
      )
    );
    die();

  }

}