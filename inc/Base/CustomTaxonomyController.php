<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\TaxonomyCallbacks;


class CustomTaxonomyController extends BaseController
{   
    public $settings;

    public $subpages = array();

    public $callbacks;

    public $tax_callbacks;

    public $taxonomies = array();

    public function register() {
        
        if( ! $this->activated( 'taxonomy_manager' ) ) { return; }

        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks(); 
        $this->tax_callbacks = new TaxonomyCallbacks();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->setSubpages();
        $this->settings->addSubPages( $this->subpages )->register();
    }

    public function setSubpages() {
        $this->subpages = array(
          array(
            'parent_slug' => 'yvic_plugin',
            'page_title' => 'Custom Taxonomies',
            'menu_title' => 'Taxonomy Manager',
            'capability' => 'manage_options', 
            'menu_slug' => 'yvic_taxonomy',
            'callback' => array( $this->callbacks, 'adminTaxonomies' ), 
          )
        );
    }

    public function setSettings() {
      $args = array(
        array(
        'option_group' => 'yvic_plugin_tax_settings',
        'option_name' => 'yvic_plugin_tax',
        'callback' => array( $this->tax_callbacks, 'taxSanitize' )
        )
      );
      $this->settings->setSettings( $args );
    }

    public function setSections() {
      $args = array(
        array(
          'id' => 'yvic_tax_index',
          'title' => 'Taxonomy Manager',
          'callback' => array( $this->tax_callbacks, 'taxSectionManager' ),
          'page' => 'yvic_plugin_tax'
        )
      );
  
      $this->settings->setSections( $args );
    }

    public function setFields() {
      $args = array(
        array(
          'id' => 'taxonomy',
          'title' => 'Taxonomy ID',
          'callback' => array( $this->tax_callbacks, 'textField' ),
          'page' => 'yvic_plugin_tax',
          'section' => 'yvic_tax_index',
          'args' => array(
            'option_name' => 'yvic_plugin_tax',
            'label_for' => 'taxonomy',
            'placeholder' => 'hint: genre',
            'array' => 'taxonomy'
          ) 
        ),
        //singular name
        array(
          'id' => 'singular_name',
          'title' => 'Singular name',
          'callback' => array( $this->tax_callbacks, 'textField' ),
          'page' => 'yvic_plugin_tax',
          'section' => 'yvic_tax_index',
          'args' => array(
              'option_name' => 'yvic_plugin_tax',
              'label_for' => 'singular_name',
              'placeholder' => 'hint: Genre',
              'array' => 'taxonomy'
          ) 
        ),
        //checkbox
        array(
          'id' => 'hierarchical',
          'title' => 'Hierarchical',
          'callback' => array( $this->tax_callbacks, 'checkboxField' ),
          'page' => 'yvic_plugin_tax',
          'section' => 'yvic_tax_index',
          'args' => array(
              'option_name' => 'yvic_plugin_tax',
              'label_for' => 'hierarchical',
              'class' => 'ui-toggle',
              'array' => 'taxonomy'
          ) 
        ),
      );

      $this->settings->setFields( $args );
    }


}