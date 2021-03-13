<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;


class CustomPostTypeController extends BaseController
{
    public $settings;

    public $subpages = array();

    public $callbacks;

    public $cpt_callbacks;

    public $custom_post_types = array();

    public function register() {
        
        if( ! $this->activated( 'cpt_manager' ) ) { return; }

        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks(); 
        $this->cpt_callbacks = new CptCallbacks(); 

        $this->setSubpages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addSubPages( $this->subpages )->register();
        
        $this->storeCustomPostTypes();

        if ( !empty( $this->custom_post_types ) ) {
            add_action( 'init', array( $this, 'registerCustomPostType' ) );
        }
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

    public function setSettings() {
        $args = array(
            array(
            'option_group' => 'yvic_plugin_cpt_settings',
            'option_name' => 'yvic_plugin_cpt',
            'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
            )
        );
        $this->settings->setSettings( $args );
    }

    public function setSections() {
        $args = array(
          array(
            'id' => 'yvic_cpt_index',
            'title' => 'Custom Post Type Manager',
            'callback' => array( $this->cpt_callbacks, 'cptSectionManager' ),
            'page' => 'yvic_plugin_cpt'
          )
        );
    
        $this->settings->setSections( $args );
      }

      public function setFields() {

        $args = array(
            //post type id
            array(
                'id' => 'post_type',
                'title' => 'Custom Post Type ID',
                'callback' => array( $this->cpt_callbacks, 'textField' ),
                'page' => 'yvic_plugin_cpt',
                'section' => 'yvic_cpt_index',
                'args' => array(
                    'option_name' => 'yvic_plugin_cpt',
                    'label_for' => 'post_type',
                    'placeholder' => 'hint: Product'
                ) 
            ),
            //singular name
            array(
                'id' => 'singular_name',
                'title' => 'Singular name',
                'callback' => array( $this->cpt_callbacks, 'textField' ),
                'page' => 'yvic_plugin_cpt',
                'section' => 'yvic_cpt_index',
                'args' => array(
                    'option_name' => 'yvic_plugin_cpt',
                    'label_for' => 'singular_name',
                    'placeholder' => 'hint: Product'
                ) 
            ),
            //plural name
            array(
                'id' => 'plural_name',
                'title' => 'Plural name',
                'callback' => array( $this->cpt_callbacks, 'textField' ),
                'page' => 'yvic_plugin_cpt',
                'section' => 'yvic_cpt_index',
                'args' => array(
                    'option_name' => 'yvic_plugin_cpt',
                    'label_for' => 'plural_name',
                    'placeholder' => 'hint: Products'
                ) 
            ),
            //public
            array(
                'id' => 'public',
                'title' => 'Public',
                'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
                'page' => 'yvic_plugin_cpt',
                'section' => 'yvic_cpt_index',
                'args' => array(
                    'option_name' => 'yvic_plugin_cpt',
                    'label_for' => 'public',
                    'class' => 'ui-toggle'
                ) 
            ),
            //has_archive
            array(
                'id' => 'has_archive',
                'title' => 'Archive',
                'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
                'page' => 'yvic_plugin_cpt',
                'section' => 'yvic_cpt_index',
                'args' => array(
                    'option_name' => 'yvic_plugin_cpt',
                    'label_for' => 'has_archive',
                    'class' => 'ui-toggle'
                ) 
            ),
            
        );
        $this->settings->setFields( $args );
      }


    public function storeCustomPostTypes() {
        $this->custom_post_types = array(
            array(
                'post_type' => 'test',
                'name' => 'SMth',
                'singular_name' => '',
                'add_new' => '',
                'add_new_item' => '',
                'edit_item' => '',
                'new_item' => '',
                'view_item' => '',
                'view_items' => '',              
                'search_items' => '',             
                'not_found' => '',      
                'not_found_in_trash' => '',      
                'parent_item_colon' => '',       
                'all_items' => '',              
                'archives' => '',                 
                'attributes' => '',               
                'insert_into_item' => '',         
                'uploaded_to_this_item' => '',   
                'featured_image' => '',
                'set_featured_image' => '',      
                'remove_featured_image' => '',   
                'use_featured_image' => '',      
                'filter_items_list' => '',       
                'filter_by_date' => '',           
                'items_list_navigation' => '',    
                'items_list' => '',               
                'item_published' => '',           
                'item_published_privately' => '',
                'item_reverted_to_draft' => '',  
                'item_scheduled' => '',           
                'item_updated' => '',

                'label' => '',
                'description' => '',
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => '',
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => 5,
                'supports' => array( 'title', 'editor', 'author', 'thumbnail' ),
                'taxonomies' => array( 'category', 'post_tag' ),
                'show_in_rest' => true          
            )
        );
    }
   
    public function registerCustomPostType() {
        foreach( $this->custom_post_types as $post_type ){

            register_post_type ( $post_type['post_type'],
                array(
                    'labels' => array(
                        'name' => $post_type['name'],
                        'singular_name' => $post_type['singular_name'],
                        'add_new' => $post_type['add_new'],
                        'add_new_item' => $post_type['add_new_item'],
                        'edit_item' => $post_type['edit_item'],
                        'new_item' => $post_type['new_item'],
                        'view_item' => $post_type['view_item'],
                        'view_items' => $post_type['view_items'],              
                        'search_items' => $post_type['search_items'],
                        'not_found' => $post_type['not_found'],      
                        'not_found_in_trash' => $post_type['not_found_in_trash'],      
                        'parent_item_colon' => $post_type['parent_item_colon'],       
                        'all_items' => $post_type['all_items'],              
                        'archives' => $post_type['archives'],                 
                        'attributes' => $post_type['attributes'],             
                        'insert_into_item' => $post_type['insert_into_item'],          
                        'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],   
                        'featured_image' => $post_type['featured_image'],
                        'set_featured_image' => $post_type['set_featured_image'],      
                        'remove_featured_image' => $post_type['remove_featured_image'],   
                        'use_featured_image' => $post_type['use_featured_image'],      
                        'filter_items_list' => $post_type['filter_items_list'],       
                        'filter_by_date' => $post_type['filter_by_date'],           
                        'items_list_navigation' => $post_type['items_list_navigation'],    
                        'items_list' => $post_type['items_list'],               
                        'item_published' => $post_type['item_published'],           
                        'item_published_privately' => $post_type['item_published_privately'],
                        'item_reverted_to_draft' => $post_type['item_reverted_to_draft'],  
                        'item_scheduled' => $post_type['item_scheduled'],          
                        'item_updated' => $post_type['item_updated']
                    ),
                    'label' => $post_type['label'],
                    'description' => $post_type['description'],
                    'public' => $post_type['public'],
                    'publicly_queryable' => $post_type['publicly_queryable'],
                    'show_ui' => $post_type['show_ui'],
                    'show_in_menu' => $post_type['show_in_menu'],
                    'query_var' => $post_type['query_var'],
                    'rewrite' => $post_type['rewrite'],
                    'capability_type' => $post_type['capability_type'],
                    'has_archive' => $post_type['has_archive'],
                    'hierarchical' => $post_type['hierarchical'],
                    'menu_position' => $post_type['menu_position'],
                    'supports' => $post_type['supports'],
                    'taxonomies' => $post_type['taxonomies'],
                    'show_in_rest' => $post_type['show_in_rest']
                )
            ); 
        } 
    }
}