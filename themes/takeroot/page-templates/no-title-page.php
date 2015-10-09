<?php
/**
 * Template Name: No Title
 *
 * A Template for when you don't want to show the title of the page.
 *
 * @package osteo
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main row" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'no-title' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
