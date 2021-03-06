<?php 
/**
 * @package YVicPlugin
 */
namespace Inc\Api\Widgets;

use WP_Widget;


class MediaWidget extends WP_Widget
{
    public $widget_id;
    public $widget_name;
    public $widget_options = array();
    public $control_options = array();
    
    public function __construct() {
        $this->widget_id = 'yvic_media_widget';
        $this->widget_name = 'My Media Widget';
        $this->widget_options = array(
            'classname'                   => $this->widget_id,
            'description'                 => $this->widget_name,
            'customize_selective_refresh' => true
        );
        $this->control_options = array(
            'width'  => 400,
            'height' => 350
        );
    }

    public function register() {
        parent::__construct( $this->widget_id, $this->widget_name, 
        $this->widget_options, $this->control_options );

        add_action( 'widgets_init', array( $this, 'widgetInit' ) );

    }

    public function widgetInit() {
        register_widget( $this );
    }

    //widget()
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        if( !empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title']  ) . $args['after_title'];
        }
        if( !empty( $instance['image'] ) ) {
            echo '<img src="'. esc_url( $instance['image'] ) .'" alt="">';
        }

        echo $args['after_widget'];
    }

    //form()
    public function form( $instance ) {
        $title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Custom Text', 
        'yvic_plugin' );

        $titleID = esc_attr( $this->get_field_id( 'title' ) );

        $input_name = esc_attr( $this->get_field_name( 'title' ) );

        $image = !empty( $instance['image'] ) ? $instance['image'] : '';

        $imageID = esc_attr( $this->get_field_id( 'image' ) );

        $image_name = esc_attr( $this->get_field_name( 'image' ) );

        ?>
        <p>
            <label for="<?php echo $titleID ?>">Title</label>
            <input type="text" class="widefat" id="<?php echo $titleID ?>" name="<?php echo $input_name?>"
            value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $imageID ?>">Upload Image</label>
            <input type="text" class="widefat image-upload" id="<?php echo $imageID ?>" name="<?php echo $image_name?>"
            value="<?php echo esc_url($image); ?>">
            <button type="button" class="button primary-button js-image-upload">Upload Image</button>
        </p>

        <?php


    }

    //update()
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance; 
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['image'] = !empty( $new_instance['image'] ) ? $new_instance['image'] : '';
        return $instance;
    }

}