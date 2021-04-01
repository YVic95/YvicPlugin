<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;


class LoginController extends BaseController
{
    public $subpages = array();

    public $callbacks;

    public function register() {
        
        if( ! $this->activated( 'login_manager' ) ) { return; }

        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks(); 

        $this->setSubpages();
        $this->settings->addSubPages( $this->subpages )->register();
    }

    public function setSubpages() {
        $this->subpages = array(
          array(
            'parent_slug' => 'yvic_plugin',
            'page_title' => 'Login',
            'menu_title' => 'Login Manager',
            'capability' => 'manage_options', 
            'menu_slug' => 'yvic_login',
            'callback' => array( $this->callbacks, 'adminLogin' ), 
          )
        );
    }
}