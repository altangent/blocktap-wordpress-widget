<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.blocktap.io
 * @since             1.0.0
 * @package           Blocktap
 *
 * @wordpress-plugin
 * Plugin Name:       Blocktap
 * Plugin URI:        http://www.blocktap.io/
 * Description:       Cryptocurrency price data
 * Version:           1.0.0
 * Author:            Altangent
 * Author URI:        http://www.altangent.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       blocktap
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// register My_Widget
add_action( 'widgets_init', function(){
	register_widget( 'Blocktap_Widget' );
});

class Blocktap_Widget extends WP_Widget {
	// class constructor
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'blocktap_widget',
			'description' => 'A plugin to display cryptocurrency prices',
		);
		parent::__construct( 'blocktap_widget', 'Blocktap', $widget_ops );
	}
	
	// output the widget content on the front-end
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		
		$base = empty($instance['base']) ? 'BTC' : $instance['base'];
		$quote = empty($instance['quote']) ? 'USDT' : $instance['quote'];
		echo '<div class="blocktap-widget"
							data-base="'.$base.'"
							data-quote='.$quote.'>
					</div>';

		// This is where the magic happens
		echo '<script type="text/javascript" src="https://www.blocktap.io/public/js/blocktap-widget.min.js"></script>';

		echo $args['after_widget'];
	}

	// output the option form field in admin Widgets screen
	public function form( $instance ) {
		$base = ! empty( $instance['base'] ) ? $instance['base'] : esc_html__( 'BTC', 'text_domain' );
		$quote = ! empty( $instance['quote'] ) ? $instance['quote'] : esc_html__( 'USDT', 'text_domain' );
		?>
		<p>
		
		<label for="<?php echo esc_attr( $this->get_field_id( 'base' ) ); ?>">
			<?php esc_attr_e( 'Base:', 'text_domain' ); ?>
		</label> 
		<input
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'base' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'base' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $base ); ?>">

		<label for="<?php echo esc_attr( $this->get_field_id( 'quote' ) ); ?>">
			<?php esc_attr_e( 'Quote:', 'text_domain' ); ?>
		</label> 
		<input
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'quote' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'quote' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $quote ); ?>">
		</p>
		<?php
	}

	// save options
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['base'] = (!empty($new_instance['base'])) ? strip_tags($new_instance['base']) : '';
		$instance['quote'] = (!empty($new_instance['quote'])) ? strip_tags($new_instance['quote']) : '';

		return $instance;
	}
}
