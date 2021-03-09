<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;

class Activate
{
   public static function activate() {
     flush_rewrite_rules();

     if ( get_option( 'yvic_plugin' ) ) {
       return;
     }

     $default = array();

     update_option( 'yvic_plugin', $default );
   }
}