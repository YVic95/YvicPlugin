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
    public $subpages = array();

    public $callbacks;

    public function register() {
        
        if( ! $this->activated( 'testimonial_manager' ) ) { return; }

        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks(); 

        $this->setSubpages();
        $this->settings->addSubPages( $this->subpages )->register();
    }

    public function setSubpages() {
        $this->subpages = array(
          array(
            'parent_slug' => 'yvic_plugin',
            'page_title' => 'Testimonial',
            'menu_title' => 'Testimonial Manager',
            'capability' => 'manage_options', 
            'menu_slug' => 'yvic_testimonial',
            'callback' => array( $this->callbacks, 'adminTestimonial') 
          )
        );
    }
}