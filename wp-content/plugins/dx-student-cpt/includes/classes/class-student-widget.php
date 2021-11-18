<?php

if ( ! class_exists( 'StudentWidget' ) ) {
	/**
	 * Class StudentWidget
	 *
	 * @package    StudentCPT
	 * @author     Martin Nestorov
	 */
	class StudentWidget extends \WP_Widget {
		/**
		 * Constructor
		 */
		public function __construct() {
			parent::__construct(
				false,
				__( 'Student Widget', 'studentcpt' ),
				array( 'description' => __( 'This widget is for the student post type.', 'studentcpt' ) )
			);
		}

		/**
		 * Adding widget elements
		 * Important: Output cannot be scaped!
		 */
		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			$html_form = wp_remote_get( SCPT_URL_PATH . './includes/templates/widget_form.html', __FILE__ );
			echo wp_remote_retrieve_body( $html_form );
			echo $args['after_widget'];
		}

		/**
		 * Creates widget backend
		 */
		public function form( $instance ) {
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = __( 'Title', 'studentcpt' );
			}
			?>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php
		}
		
		/**
		 * Overrides the wp update function
		 */
		public function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
			return $instance;
		}
	}
}
