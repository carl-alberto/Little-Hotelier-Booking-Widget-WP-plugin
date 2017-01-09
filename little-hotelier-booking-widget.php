<?php
/**
 * Plugin Name: LH Booking Widget
 * Version: 1.1
 * Plugin URI: https://carl.alber2.com/
 * Description: This is a Booking Widget used for Little Hotelier. Please get your channel code from the official site: http://www.littlehotelier.com/
 * Author: Carl Alberto
 * Author URI: https://carl.alber2.com/
 * Requires at least: 4.0
 * Tested up to: 4.5.2
 *
 * Text Domain: little-hotelier-booking-widget
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'widgets_init', 'lhw_register_widget' );

/**
 * Function that registers the LH Booking Widget.
 *
 * @version	1.0.0
 * @since 1.0.0
 * @package	LH Booking Widget
 * @author Carl Alberto
 */
function lhw_register_widget() {
	register_widget( 'lhw_widget' );
}

/**
 * Main LH Booking Widget Class.
 *
 * @class HelpHub_Post_Types
 * @version	1.0.0
 * @since 1.0.0
 * @package	LH_Booking_Widget
 * @author Carl Alberto
 */
class Lhw_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @version	1.0.0
	 * @since 1.0.0
	 * @package	LH Booking Widget
	 * @author Carl Alberto
	 */
	public function __construct() {

		parent::__construct(
			'lhw_widget',
			__( 'Little Hotelier Booking Widget', 'little-hotelier-booking-widget' ),
			array(
				'classname'   => 'lhw_widget widget_recent_entries',
				'description' => __( 'This will list post by ', 'little-hotelier-booking-widget' ),
			)
		);

	}

	/**
	 * Widget Constructor
	 *
	 * @version	1.0.0
	 * @since	1.0.0
	 * @param	array $instance form instance.
	 * @package	LH Booking Widget
	 * @author	Carl Alberto
	 */
	public function form( $instance ) {
		$defaults  = array(
			'title' => '',
			'mychannelcode' => '',
			'height' => 5,
			'width' => '',
			'frameborder' => '',
			'scrolling' => 'no',
			'allowtransparency' => 'true',
		);
		$instance  = wp_parse_args( (array) $instance, $defaults );

		$title     			= $instance['title'];
		$mychannelcode  = $instance['mychannelcode'];
		$gridmode  			= $instance['gridmode'];
		$number    			= $instance['number'];
		$height 				= $instance['height'];
		$width 					= $instance['width'];
		$frameborder 		= $instance['frameborder'];
		$scrolling 			= $instance['scrolling'];
		$allowtransparency = $instance['allowtransparency'];
		?>

		<p>
			<label for="lhw_widget_title"><?php esc_html_e( 'Title' ); ?>:</label>
			<input type="text" class="widefat" id="lhw_widget_title" name="<?php echo esc_html_e( 'widget-lhw_widget[2][title]' ) ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<input type="radio" name="<?php echo esc_html_e( 'widget-lhw_widget[2][gridmode]' ) ?>" value="simple" <?php echo ( 'simple' === $gridmode ) ? 'checked' : '' ?> > Simple
			<input type="radio" name="<?php echo esc_html_e( 'widget-lhw_widget[2][gridmode]' ) ?>" value="availabilitygrid" <?php echo ( 'availabilitygrid' === $gridmode ) ? 'checked' : '' ?> > Availability Grid<br>
		</p>

		<p>
			<label for="lhw_widget_title"><?php echo esc_html_e( 'MYCHANNELCODE' ); ?>:</label>
			<input type="text" class="lhw_channel" id="lhw_widget_mychannelcode" name="<?php echo esc_html_e( 'widget-lhw_widget[2][mychannelcode]' ) ?>" value="<?php echo esc_attr( $mychannelcode ); ?>" />
		</p>

		<?php

	}

	/**
	 * Outputs the widget in the frontend.
	 *
	 * @version	1.0.0
	 * @since	1.0.0
	 * @param	array $args args for the instance.
	 * @param	array $instance form instance.
	 */
	public function widget( $args, $instance ) {
		$title     = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$mychannelcode     = apply_filters( 'widget_title', $instance['mychannelcode'], $instance, $this->id_base );
		$gridmode     = apply_filters( 'widget_title', $instance['gridmode'], $instance, $this->id_base );
		if ( 'simple' === $gridmode ) {
			echo '<iframe src="https://app.littlehotelier.com/properties/' . esc_html( $mychannelcode ) . '/booking_widget" height="200" width="210" frameborder="0" scrolling="no" allowtransparency="true"></iframe>';
		} else {
			echo '<iframe src="https://app.littlehotelier.com/properties/' . esc_html( $mychannelcode ) . '/widget?number_of_days=14" height="300" width="720" frameborder="0" scrolling="no" allowtransparency="true"></iframe>';
		}
	}

	/**
	 * Widget update function.
	 *
	 * @version	1.0.0
	 * @since	1.0.0
	 * @param	array $new_instance 	array of the new values for update usage.
	 * @param	array $old_instance	array of the old values.
	 * @return	array of the updated widget values.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance              = $old_instance;
		$instance['title']     = wp_strip_all_tags( $new_instance['title'] );
		$instance['mychannelcode']  = wp_strip_all_tags( $new_instance['mychannelcode'] );
		$instance['gridmode']     = wp_strip_all_tags( $new_instance['gridmode'] );

		return $instance;
	}

}

?>
