<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Api\Callbacks;

class TaxonomyCallbacks 
{
    public function taxSectionManager() {
        echo 'Lets Create some Custom Taxonomies!';
    }

    public function taxSanitize( $input ) {

        $output = get_option('yvic_plugin_tax');

        if( isset( $_POST["remove"] ) ) {
            unset( $output[$_POST["remove"]] );
            return $output;  
        }
   
        $output[$input['taxonomy']] = $input;
        //var_dump($input);
       // die();
        return $output;

    }

    public function textField( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        $hidden = $name == 'taxonomy' && isset( $_POST['edit_taxonomy'] ) ? 'hidden' : 'text';
        $edit_text = $name == 'taxonomy' && isset( $_POST['edit_taxonomy'] ) ? $_POST['edit_taxonomy'] : ' ';
        

        if( isset( $_POST['edit_taxonomy'] ) ){
            $input = get_option( $option_name );

            $value = $input[$_POST['edit_taxonomy']][$name];  
        }
        echo $edit_text;
        echo '<input type="'.$hidden.'" class="regular-text" id="'. $name .'" name="'.$option_name.'['.$name.']" value="'. $value .'" placeholder="'. $args['placeholder'] .'" required/>';
    }

    public function checkboxField( $args ) {
        $name = $args[ 'label_for' ];
        $classes = $args[ 'class' ];
        $option_name = $args['option_name'];
        $checked = false;

        if( isset( $_POST['edit_taxonomy'] ) ){
            $checkbox = get_option( $option_name );
            $checked = isset( $checkbox[$_POST['edit_taxonomy']][$name] ) ?: false;
        }

        echo '<div class="'.$classes.'"><input type="checkbox" id="'.$name.'" name="'.
            $option_name.'['.$name.']" value="1" class="" '.( $checked ? 'checked' : '' ).'>
            <label for="'.$name.'"><div></div></label></div>';
    }

}