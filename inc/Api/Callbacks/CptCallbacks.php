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
   
        $output[$input['post_type']] = $input;
        // var_dump($output);
        // die();
        return $output;

    }

    public function textField( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );

        echo '<input type="text" class="regular-text" id="'. $name .'" name="'. 
        $option_name.'['.$name.']" value="" placeholder="'. $args['placeholder'] .'"/>';
    }


    public function checkboxField( $args ) {
        $name = $args[ 'label_for' ];
        $classes = $args[ 'class' ];
        $option_name = $args['option_name'];
        $checkbox = get_option( $option_name );

        echo '<div class="'.$classes.'"><input type="checkbox" id="'.$name.'" name="'.
            $option_name.'['.$name.']" value="1" class="">
            <label for="'.$name.'"><div></div></label></div>';
    }
}