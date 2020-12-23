<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Pages;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{
  public $settings;
  public $callbacks;
  public $pages = array();
  public $subpages = array();

  public function register() {
    $this->settings = new SettingsApi();

    $this->callbacks = new AdminCallbacks(); 

    $this->setPages();

    $this->setSubpages();

    $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->
    addSubPages( $this->subpages )->register();
  }

  public function setPages() {
    $this->pages = array(
      array(
        'page_title' => 'Yvic Plugin', 
        'menu_title' => 'Yvic', 
        'capability' => 'manage_options',
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
}