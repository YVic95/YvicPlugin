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

      $this->storeCustomTaxonomies();

      if ( !empty( $this->taxonomies ) ) {
        add_action( 'init', array( $this, 'registerCustomTaxonomy' ) );
      }
  }

  public function setSubpages() {
      $this->subpages = array(
        array(
          'parent_slug' => 'yvic_plugin',
          'page_title'  => 'Custom Taxonomies',
          'menu_title'  => 'Taxonomy Manager',
          'capability'  => 'manage_options', 
          'menu_slug'   => 'yvic_taxonomy',
          'callback'    => array( $this->callbacks, 'adminTaxonomies' ), 
        )
      );
  }

  public function setSettings() {
    $args = array(
      array(
      'option_group' => 'yvic_plugin_tax_settings',
      'option_name'  => 'yvic_plugin_tax',
      'callback'     => array( $this->tax_callbacks, 'taxSanitize' )
      )
    );
    $this->settings->setSettings( $args );
  }

  public function setSections() {
    $args = array(
      array(
        'id'       => 'yvic_tax_index',
        'title'    => 'Taxonomy Manager',
        'callback' => array( $this->tax_callbacks, 'taxSectionManager' ),
        'page'     => 'yvic_plugin_tax'
      )
    );

    $this->settings->setSections( $args );
  }

  public function setFields() {
    $args = array(
      array(
        'id'       => 'taxonomy',
        'title'    => 'Taxonomy ID',
        'callback' => array( $this->tax_callbacks, 'textField' ),
        'page'     => 'yvic_plugin_tax',
        'section'  => 'yvic_tax_index',
        'args'     => array(
          'option_name' => 'yvic_plugin_tax',
          'label_for'   => 'taxonomy',
          'placeholder' => 'hint: genre',
          'array'       => 'taxonomy'
        ) 
      ),
      //singular name
      array(
        'id'       => 'singular_name',
        'title'    => 'Singular name',
        'callback' => array( $this->tax_callbacks, 'textField' ),
        'page'     => 'yvic_plugin_tax',
        'section'  => 'yvic_tax_index',
        'args'     => array(
            'option_name' => 'yvic_plugin_tax',
            'label_for'   => 'singular_name',
            'placeholder' => 'hint: Genre',
            'array'       => 'taxonomy'
        ) 
      ),
      //checkbox
      array(
        'id'       => 'hierarchical',
        'title'    => 'Hierarchical',
        'callback' => array( $this->tax_callbacks, 'checkboxField' ),
        'page'     => 'yvic_plugin_tax',
        'section'  => 'yvic_tax_index',
        'args'     => array(
            'option_name' => 'yvic_plugin_tax',
            'label_for'   => 'hierarchical',
            'class'       => 'ui-toggle',
            'array'       => 'taxonomy'
        ) 
      ),
    );

    $this->settings->setFields( $args );
  }

  public function storeCustomTaxonomies() {

    //get taxonomy array
    $options = get_option( 'yvic_plugin_tax' ) ?: array();

    //store info in array 
    foreach ($options as $option) {

      $labels = array(
        'name'              => $option['singular_name'],
        'singular_name'     => $option['singular_name'],
        'search_items'      => 'Search ' . $option['singular_name'],
        'all_items'         => 'All ' . $option['singular_name'] . 's',
        'parent_item'       => 'Parent ' . $option['singular_name'],
        'parent_item_colon' => 'Parent ' . $option['singular_name'] . ':',
        'edit_item'         => 'Edit ' . $option['singular_name'],
        'update_item'       => 'Update ' . $option['singular_name'],
        'add_new_item'      => 'Add New ' . $option['singular_name'],
        'new_item_name'     => 'New ' . $option['singular_name'] . ' Name',
        'menu_name'         => $option['singular_name']
      );

      $this->taxonomies[] = array(
        'hierarchical'      => ( isset($option['hierarchical']) && $option['hierarchical'] ) ? true : false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => $option['taxonomy'] )
      );

    }

    //register taxonomy

  }

  public function registerCustomTaxonomy() {

    foreach( $this->taxonomies as $taxonomy ) {

      register_taxonomy( $taxonomy['rewrite']['slug'], array( 'book' ), $taxonomy );
    }
      
  }

}