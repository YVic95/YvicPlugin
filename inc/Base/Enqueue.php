<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;
use \Inc\Base\BaseController;

class Enqueue extends BaseController
{
  public function register() {
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
  }
  //enqueue all scripts
  function enqueue() {
    wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/css/mystyle.min.css' );
    wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/js/myscript.js' );
  }
}
// 'assets/mystyle.css', 'assets/myscript.js'