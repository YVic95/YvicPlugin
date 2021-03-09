<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;


class CustomPostTypeController extends BaseController
{
    public $subpages = array();

    public $callbacks;

    public function register() {
        
        $option = get_option( 'yvic_plugin' );

        $activated = isset( $option['cpt_manager'] ) ? $option['cpt_manager'] : false;

        if( ! $activated ) {
            return;
        }

        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks(); 

        $this->setSubpages();
        $this->settings->addSubPages( $this->subpages )->register();
        add_action( 'init', array( $this, 'activate' ) );
    }

    public function setSubpages() {
        $this->subpages = array(
          array(
            'parent_slug' => 'yvic_plugin',
            'page_title' => 'Custom Post Type',
            'menu_title' => 'CPT Manager',
            'capability' => 'manage_options', 
            'menu_slug' => 'yvic_cpt',
            'callback' => array( $this->callbacks, 'adminCpt' ), 
          )
        );
      }

   
    public function activate() {
        register_post_type ( 'yvic_products',
            array(
                'labels' => array(
                    'name' => 'Products',
                    'singular' => 'Product'
                ),
                'public' => true,
                'has_archive' => true
            )
        ); 
    }
}