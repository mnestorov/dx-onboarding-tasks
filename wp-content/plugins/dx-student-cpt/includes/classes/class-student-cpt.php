<?php

if ( ! class_exists( 'StudentCPT' ) ) {
	/**
	 * Class StudentCPT
	 * Asana task: https://app.asana.com/0/1201345304239951/1201345347126925/f
	 *
	 * @package    StudentCPT
	 * @author     Martin Nestorov
	 */
	class StudentCPT {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'dx_register_student_type' ) );
			add_action( 'add_meta_boxes', array( $this, 'dx_add_student_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'dx_save_meta_boxes' ) );
			add_action( 'manage_student_posts_custom_column', array( $this, 'dx_student_columns_content' ), 10, 2 );
			add_filter( 'manage_student_posts_columns', array( $this, 'dx_student_add_default_column' ) );
			add_shortcode( 'student', array( $this, 'dx_display_student_shortcode' ) );
			add_shortcode( 'students-list', array( $this, 'dx_students_listing_shortcode' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'dx_student_cpt_load_javascript' ) );
			add_action( 'wp_ajax_toggle_student_activated', array( $this, 'dx_toggle_student_activated' ) );
			add_action( 'widgets_init', array( $this, 'dx_student_load_widget' ) );
		}

		/**
		 * Register the Students CPT
		 */
		public function dx_register_student_type() {
			$labels = array(
				'name'               => _x( 'Students', 'Post type general name', 'studentsctp' ),
				'singular_name'      => _x( 'Student', 'Post type singular name', 'studentsctp' ),
				'menu_name'          => _x( 'Students', 'Admin Menu text', 'studentsctp' ),
				'name_admin_bar'     => _x( 'Student', 'Add New on Toolbar', 'studentsctp' ),
				'add_new'            => __( 'Add New', 'studentsctp' ),
				'add_new_item'       => __( 'Add New Student', 'studentsctp' ),
				'new_item'           => __( 'New Student', 'studentsctp' ),
				'edit_item'          => __( 'Edit Student', 'studentsctp' ),
				'view_item'          => __( 'View Student', 'studentsctp' ),
				'all_items'          => __( 'All Students', 'studentsctp' ),
				'search_items'       => __( 'Search Students', 'studentsctp' ),
				'parent_item_colon'  => __( 'Parent Students:', 'studentsctp' ),
				'not_found'          => __( 'No stundets found.', 'studentsctp' ),
				'not_found_in_trash' => __( 'No students found in Trash.', 'studentsctp' ),
			);
			$args = array(
				'label'             => 'student',
				'labels'            => $labels,
				'description'       => 'A student from some school.',
				'public'            => true,
				//'menu_position'     => 3,
				'menu_icon'           => 'dashicons-businessperson',
				'supports'          => array( 'title', 'thumbnail', 'excerpt', 'category', 'editor' ),
				'has_archive'       => true,
				'show_in_admin_bar' => true,
				'show_in_rest'      => true,
				'taxonomies'        => array( 'category' ),
			);
			register_post_type( 'student', $args );
		}

		/**
		 * The callback which displays the input box for the city meta
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229531039/f
		 *
		 * @param student $post is provided, because the ID is needed for the get_post_meta().
		 */
		public function dx_city_meta_box( $post ) {
			$value = get_post_meta( $post->ID, 'student_city', true );
			?>
				<label for="city"> City: </label>
				<input type="text" name="city" value=" <?php echo ( esc_html( isset( $value ) ? $value : '' ) ); // Asana task: https://app.asana.com/0/1201345304239951/1201345229572231/f ?>">
			<?php
		}

		/**
		 * The callback which displays the input box for the address meta
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229531039/f
		 *
		 *  @param student $post is provided, because the ID is needed for the get_post_meta().
		 */
		public function dx_address_meta_box( $post ) {
			$value = get_post_meta( $post->ID, 'student_address', true );
			?>
				<label for="address"> Address: </label>
				<input type="text" name="address" style="width:60%;" value="<?php echo ( esc_html( isset( $value ) ? $value : '' ) ); // Asana task: https://app.asana.com/0/1201345304239951/1201345229572231/f ?>">
			<?php
		}

		/**
		 * The callback which displays the input box for the city meta
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229531039/f
		 *
		 *  @param student $post is provided, because the ID is needed for the get_post_meta().
		 */
		public function dx_birthdate_meta_box( $post ) {
			$value = get_post_meta( $post->ID, 'student_birthdate', true );
			?>
				<label for="birthdate"> Birth Date: </label>
				<input type="date" name="birthdate" style="width:60%;" value="<?php echo ( esc_html( isset( $value ) ? $value : '' ) ); // Asana task: https://app.asana.com/0/1201345304239951/1201345229572231/f ?>">
			<?php
		}

		/**
		 * The callback which displays the input box for the student grade meta
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229531039/f
		 *
		 *  @param student $post is provided, because the ID is needed for the get_post_meta().
		 */
		public function dx_student_grade_meta_box( $post ) {
			$value = get_post_meta( $post->ID, 'student_grade', true );
			?>
				<label for="grade">Grade:</label>
				<select name="grade">
					<option value="">-- Please Select --</option>
					<option value="8"  <?php selected( $value, '8' ); ?>>8</option>
					<option value="9"  <?php selected( $value, '9' ); ?>>9</option>
					<option value="10" <?php selected( $value, '10' ); ?>>10</option>
					<option value="11" <?php selected( $value, '11' ); ?>>11</option>
					<option value="12" <?php selected( $value, '12' ); ?>>12</option>
				</select>
			<?php
		}

		/**
		 * Adds all student meta boxes
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229531039/f
		 */
		public function dx_add_student_meta_boxes() {
			add_meta_box(
				'student_city',
				'City',
				array( $this, 'dx_city_meta_box' ),
				'student'
			);
			add_meta_box(
				'student_address',
				'Address',
				array( $this, 'dx_address_meta_box' ),
				'student'
			);
			add_meta_box(
				'student_birthdate',
				'Birth Date',
				array( $this, 'dx_birthdate_meta_box' ),
				'student'
			);
			add_meta_box(
				'student_grade',
				'Grade',
				array( $this, 'dx_student_grade_meta_box' ),
				'student'
			);
		}

		/**
		 * Describes how the meta data from the meta boxes will be saved
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229531039/f
		 *
		 * @param number $post_id specifies the ID of the post that is being saved.
		 */
		public function dx_save_meta_boxes( $post_id ) {
			if ( array_key_exists( 'city', $_POST ) ) {
				update_post_meta(
					$post_id,
					'student_city',
					/**
					 * Asana task: https://app.asana.com/0/1201345304239951/1201345229572231/f
					 */
					sanitize_text_field( $_POST['city'] ),
				);
			}
			if ( array_key_exists( 'address', $_POST ) ) {
				update_post_meta(
					$post_id,
					'student_address',
					/**
					 * Asana task: https://app.asana.com/0/1201345304239951/1201345229572231/f
					 */
					sanitize_text_field( $_POST['address'] ),
				);
			}
			if ( array_key_exists( 'birthdate', $_POST ) ) {
				update_post_meta(
					$post_id,
					'student_birthdate',
					/**
					 * Asana task: https://app.asana.com/0/1201345304239951/1201345229572231/f
					 */
					sanitize_text_field( $_POST['birthdate'] ),
				);
			}
			if ( array_key_exists( 'grade', $_POST ) ) {
				update_post_meta(
					$post_id,
					'student_grade',
					/**
					 * Asana task: https://app.asana.com/0/1201345304239951/1201345229572231/f
					 */
					sanitize_text_field( $_POST['grade'] ),
				);
			}
		}
		/**
		 * Adds the Active checkbox to the student CPT admin panel
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345347042607/f
		 *
		 * @param array $defaults an array containing the default admin panel columns
		 */
		public function dx_student_add_default_column( $defaults ) {
			$defaults['active'] = 'Active';
			return $defaults;
		}

		/**
		 * The callback for the Active checkbox
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345347042607/f
		 */
		public function dx_student_columns_content( $column_name, $post_ID ) {
			if ( 'active' == $column_name ) {
				?>
				<input type="checkbox" name="active_student_checkbox" class="active_student_checkbox" id="<?php echo $post_ID; ?>" <?php checked( get_post_meta( $post_ID, 'student_active', true ), 'active' ); ?>>
				<?php
			}
		}

		/**
		 * Loads scripts
		 */
		public function dx_student_cpt_load_javascript() {
			wp_register_script( 'student_ajax_calls', SCPT_URL_PATH . './includes/assets/js/ajax.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'student_ajax_calls' );
		}

		/**
		 * Student CPT shortcode
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229477769/f
		 *
		 * @param array $atts practically accepts only one attribute and it is a Student's ID
		 */
		public function dx_display_student_shortcode( $atts ) {
			$student_display = '';

			$student = shortcode_atts(
				array( 'student_id' => null ),
				$atts
			);

			$query_args = array(
				'post_type' => 'student',
				'p'         => $student['student_id'],
			);

			$get_single = new \WP_Query( $query_args );

			if ( get_option( 'is_checked' ) ) {

				ob_start();

				if ( $get_single->have_posts() ) {
					while ( $get_single->have_posts() ) {
						$get_single->the_post();
						?>
						<div style="padding: 15px; border: 2px solid black;" class="<?php echo get_post_meta( get_the_ID(), 'student_active', true ); ?>">
						<h2><?php echo get_the_title(); ?> </h2>
						<h3>Grade: <?php echo get_post_meta( get_the_ID(), $key = 'student_grade', true ); ?></h3>
						<h3>Status: <?php echo get_post_meta( get_the_ID(), $key = 'student_active', true ); ?></h3>
						<?php
					}
				} else {
					/**
					 * Asana task: https://app.asana.com/0/1201345304239951/1201345229500262/f
					 */
					echo '<h2>Students with the specified ID were not found.</h2>';
				}

				echo '</div>';

				$student_display = ob_get_contents();
				ob_end_clean();
				return $student_display;

			} else {
				echo '<h2>Silence is golden.</h2>';
			}
		}

		/**
		 * Create Shortcode to display list of students
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229500262/f
		 */
		public function dx_students_listing_shortcode( $atts ) {
			$listing_display = '';

			$student = shortcode_atts(
				array(
					'posts_per_page' => 5,
				),
				$atts
			);

			$query_args = array(
				'post_type'      => 'student',
				'posts_per_page' => $student['posts_per_page'],
				'publish_status' => 'published',
			);

			$get_listing = new \WP_Query( $query_args );

			if ( $get_listing->have_posts() ) {
				while ( $get_listing->have_posts() ) {
					$get_listing->the_post();
					$listing_display .= '<div style="padding: 15px; border: 2px solid black;">';
					$listing_display .= '<h2>' . get_the_title() . '</h2>';
					$listing_display .= '<div style="margin-bottom: 15px; border: 5px solid white; text-align: center;">' . get_the_post_thumbnail() . '</div>';
					$listing_display .= '<h3> Grade: ' . get_post_meta( get_the_ID(), $key = 'student_grade', true ) . '</h3>';
					$listing_display .= '<h3> Status: ' . get_post_meta( get_the_ID(), $key = 'student_active', true ) . '</h3>';
					$listing_display .= '</div>';
				}

				wp_reset_postdata();
			}

			return $listing_display;
		}

		/**
		 * Changes the Students CPT meta from active to inactive
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345347042607/f
		 */
		public function dx_toggle_student_activated() {
			if ( isset( $_POST['student_id'] ) ) {
				$student_id = $_POST['student_id'];
			}

			$is_active = get_post_meta( $student_id, 'student_active', true );

			if ( 'active' === $is_active ) {
				update_post_meta( $student_id, 'student_active', 'no' );
			} else {
				update_post_meta( $student_id, 'student_active', 'active' );
			}

			wp_die();
		}

		/**
		 * Registers the student widget
		 * Asana task: https://app.asana.com/0/1201345304239951/1201345229251143/f
		 */
		public function dx_student_load_widget() {
			register_widget( 'StudentWidget' );
		}
	}
}
