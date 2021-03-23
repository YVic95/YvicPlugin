<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Api\Callbacks;

class CptCallbacks
{
    public function cptSectionManager() {
        echo 'Lets Add Some Custom Post Types!  ';
    }

    public function cptSanitize( $input ) {

        $output = get_option('yvic_plugin_cpt');

        if( isset( $_POST["remove"] ) ) {
            unset( $output[$_POST["remove"]] );
            return $output;  
        }
   
        $output[$input['post_type']] = $input;
        // var_dump($output);
        // die();
        return $output;

    }

    public function textField( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        $disabled = $name == 'post_type' && isset( $_POST['edit_post'] ) ? 'disabled' : '';

        if( isset( $_POST['edit_post'] ) ){
            $input = get_option( $option_name );

            $value = $input[$_POST['edit_post']][$name];  
        }

        echo '<input '.$disabled.' type="text" class="regular-text" id="'. $name .'" name="'.$option_name.'['.$name.']" value="'. $value .'" placeholder="'. $args['placeholder'] .'" required/>';
    }


    public function checkboxField( $args ) {
        $name = $args[ 'label_for' ];
        $classes = $args[ 'class' ];
        $option_name = $args['option_name'];
        $checked = false;

        if( isset( $_POST['edit_post'] ) ){
            $checkbox = get_option( $option_name );
            $checked = isset( $checkbox[$_POST['edit_post']][$name] ) ?: false;
        }

        echo '<div class="'.$classes.'"><input type="checkbox" id="'.$name.'" name="'.
            $option_name.'['.$name.']" value="1" class="" '.( $checked ? 'checked' : '' ).'>
            <label for="'.$name.'"><div></div></label></div>';
    }
}