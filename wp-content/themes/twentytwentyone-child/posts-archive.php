<?php
/**
 * Template Name: Posts Archive
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

get_header();

?>

<section>
	<header class="page-header alignwide">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : ?>

				<?php the_post(); ?>

				<h1 class="entry-title"><?php echo esc_html( get_the_title() ); ?></h1>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>

			<?php endwhile; ?>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>
	</header>
</section>

<section class="entry-content">

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

		<div>
			<?php while ( $posts_query->have_posts() ) : ?>

				<?php $posts_query->the_post(); ?>

				<div>

					<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
						<div>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</div>
					<?php endif; ?>

					<div class="entry-title">
						<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
					</div>

				</div><!-- archive-item -->

			<?php endwhile; ?>
		</div>

		<?php $total_pages = $posts_query->max_num_pages; ?>

		<?php if ( $total_pages > 1 ) : ?>

			<?php $current_page = max( 1, get_query_var( 'paged' ) ); ?>

			<div class="pagination">
				<?php echo paginate_links(
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

		<?php echo esc_html__( 'No posts matching the query were found.', 'twentytwentyone' ); ?>

	<?php endif; ?>
</section>

<?php get_footer(); ?>
