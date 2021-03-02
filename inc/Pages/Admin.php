<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Pages;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Admin extends BaseController
{
  public $settings;
  public $callbacks;
  public $callbacks_mngr;
  public $pages = array();
  public $subpages = array();

  public function register() {
    $this->settings = new SettingsApi();

    $this->callbacks = new AdminCallbacks(); 
    $this->callbacks_mngr = new ManagerCallbacks(); 

    $this->setPages();

    $this->setSubpages();

    $this->setSettings();
    $this->setSections();
    $this->setFields();

    $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->
    addSubPages( $this->subpages )->register();
  }

  public function setPages() {
    $this->pages = array(
      array(
        'page_title' => 'Yvic Plugin', 
        'menu_title' => 'Yvic', 
        'capability' => 'manage_options',
        //necessary for args
        'menu_slug' => 'yvic_plugin', 
        'callback' => array( $this->callbacks, 'adminDashboard' ), 
        'icon_url' => 'dashicons-buddicons-groups', 
        'position' => 110
      ),
    );
  }

  public function setSubpages() {
    $this->subpages = array(
      array(
        'parent_slug' => 'yvic_plugin',
        'page_title' => 'Custom Post Type',
        'menu_title' => 'CPT',
        'capability' => 'manage_options', 
        'menu_slug' => 'yvic_cpt',
        'callback' => array( $this->callbacks, 'adminCpt' ), 
      ),
      array(
        'parent_slug' => 'yvic_plugin',
        'page_title' => 'Custom Taxonomies',
        'menu_title' => 'Taxonomies',
        'capability' => 'manage_options', 
        'menu_slug' => 'yvic_taxonomies',
        'callback' => array( $this->callbacks, 'adminTaxonomies' ), 
      ),
      array(
        'parent_slug' => 'yvic_plugin',
        'page_title' => 'Custom Widgets',
        'menu_title' => 'Widgets',
        'capability' => 'manage_options', 
        'menu_slug' => 'yvic_widgets',
        'callback' => array( $this->callbacks, 'adminWidgets' ), 
      ),
    );
  }

  public function setSettings() {
    $args = array();
    foreach( $this->managers as $key => $value ) {
      
      $args[] = array(
        'option_group' => 'yvic_plugin_settings',
        'option_name' => $key,
        'callback' => array( $this->callbacks_mngr, 'checkSanitize' )
      );
    }
    $this->settings->setSettings( $args );
  }

  public function setSections() {
    $args = array(
      array(
        'id' => 'yvic_admin_index',
        'title' => 'Settings Manager',
        'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
        'page' => 'yvic_plugin'
      )
    );

    $this->settings->setSections( $args );
  }

  public function setFields() {
    $args = array();
    foreach( $this->managers as $key => $value ) {
      $args[] = array(
        'id' => $key,
        'title' => $value,
        'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
        'page' => 'yvic_plugin',
        'section' => 'yvic_admin_index',
        'args' => array(
          'label_for' => $key,
          'class' => 'ui-toggle'
        ) 
      );
    }
    $this->settings->setFields( $args );
  }
}