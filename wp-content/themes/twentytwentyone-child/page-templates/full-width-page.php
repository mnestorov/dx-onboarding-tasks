<?php
/**
 * Template Name: Full Width Page
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>

<div class="entry-content">
	<main class="site-main" role="main">

	<?php if ( has_post_thumbnail() ) : ?>

		<?php the_post_thumbnail(); ?>

	<?php else : ?>

		<!-- Dixy image -->
		<div class="centered-image">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/dixy.png'; ?>" title="Dixy" alt="image" width="250">
		</div>

	<?php endif; ?>

	<?php the_content(); ?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
