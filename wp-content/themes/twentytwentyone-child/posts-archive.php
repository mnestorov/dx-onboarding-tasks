<?php
/**
 * Template Name: Posts Archive
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

get_header(); ?>

<?php if ( is_page( 'posts-archive' ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<?php
$posts_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 5,
		'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
	)
);
?>

<?php if ( $posts_query->have_posts() ) : ?>

	<?php
	// Load posts loop.
	while ( $posts_query->have_posts() ) {
		$posts_query->the_post();
		get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) );
	}
	?>

	<?php $total_pages = $posts_query->max_num_pages; // Load More posts button. ?>

	<?php if ( $total_pages > 1 ) : ?>

		<?php $current_page = max( 1, get_query_var( 'paged' ) );  ?>

		<div class="pagination">
			<?php
			echo paginate_links(
				array(
					'base'    => get_pagenum_link( 1 ) . '%_%',
					'format'  => 'page/%#%',
					'current' => $current_page,
					'total'   => $total_pages,
				)
			);
			?>
		</div>

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

<?php else : ?>

	<?php get_template_part( 'template-parts/content/content-none' ); // If no content, include the "No posts found" template. ?>

<?php endif; ?>

<?php get_footer(); ?>
