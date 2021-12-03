<?php // Template name: Students Filter Widget

get_header(); ?>

<div class="entry-content">
	<?php if ( is_active_sidebar( 'students_sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'students_sidebar' ); ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
