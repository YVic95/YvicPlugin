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
        return $input;
    }

    public function textField( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        $value = $input[$name];

        echo '<input type="text" class="regular-text" id="'. $name .'" name="'. 
        $option_name.'['.$name.']" value="'. $value .'" placeholder="'. $args['placeholder'] .'"/>';
    }


    public function checkboxField( $args ) {
        $name = $args[ 'label_for' ];
        $classes = $args[ 'class' ];
        $option_name = $args['option_name'];
        $checkbox = get_option( $option_name );

        $checked = isset( $checkbox[$name] ) ? ( $checkbox[$name] ? true : false ) : false;
    

        echo '<div class="'.$classes.'"><input type="checkbox" id="'.$name.'" name="'.
            $option_name.'['.$name.']" value="1" class="'.$classes.'" '.( $checked ? 'checked' : '' ).'>
            <label for="'.$name.'"><div></div></label></div>';
    }
}