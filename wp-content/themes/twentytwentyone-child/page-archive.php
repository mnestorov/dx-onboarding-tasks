<?php
/**
 * Template Name: Archives
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 */

get_header(); ?>

<div id="primary" class="entry-content">
    <main class="site-main" role="main">

    <?php while ( have_posts() ) : ?>

        <?php the_post(); ?>
        
        <h1 class="entry-title"><?php the_title(); ?></h1>

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

    </main>
</div><!-- #primary -->


<?php get_footer(); ?>
