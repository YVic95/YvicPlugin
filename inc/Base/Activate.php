<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;

class Activate
{
  public static function activate() {
    flush_rewrite_rules();

    $default = array();

    if ( ! get_option( 'yvic_plugin' ) ) {
      update_option( 'yvic_plugin', $default );
    }

    if ( ! get_option( 'yvic_plugin_cpt' ) ) {
      update_option( 'yvic_plugin_cpt', $default );
    }
     
   }
}