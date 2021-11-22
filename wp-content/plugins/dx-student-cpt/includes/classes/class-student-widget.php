<?php

if ( ! class_exists( 'StudentWidget' ) ) {
	/**
	 * Class StudentWidget
	 * Asana task: https://app.asana.com/0/1201345304239951/1201345229251143/f
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
			$template_path = __DIR__ . '../../templates/form.php';
			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( ! is_readable( $template_path ) ) {
				return sprintf( '<!-- Could not read "%s" file -->', $template_path );
			}

			ob_start();

			include $template_path;
			$content = ob_get_clean();

			echo $content;

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
