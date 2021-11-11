<?php
/**
 * Template Name: Pages Archive
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

get_header(); ?>

<?php if ( is_page( 'pages-archive' ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : ?>

		<?php the_post(); ?>

		<div class="entry-content">

			<p><strong>Recent Posts:</strong></p>
			<ul class="archives">
				<?php wp_get_archives( 'type=postbypost&limit=10' ); ?>
			</ul>

			<div class="clear"></div>

			<p><strong>Pages:</strong></p>
			<ul class="archives">
				<?php wp_list_pages( 'title_li=' ); ?>
			</ul>

			<div class="clear"></div>

			<p><strong>Categories:</strong></p>
			<ul class="archives">
				<?php wp_list_categories( 'title_li=' ); ?>
			</ul>

			<div class="clear"></div>

		</div><!-- .entry-content -->

	<?php endwhile; ?>

	<?php wp_reset_postdata(); ?>

<?php else : ?>

	<?php get_template_part( 'template-parts/content/content-none' ); // If no content, include the "No posts found" template. ?>

<?php endif; ?>

<?php get_footer(); ?>
