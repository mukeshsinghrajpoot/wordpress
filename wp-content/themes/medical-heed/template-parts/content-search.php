<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Medical_Heed
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="medical-post-wrap">

		<?php medical_heed_post_thumbnail(); ?>

		<div class="entry-header">
			<?php

				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

			if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
						medical_heed_posted_by();
		                medical_heed_posted_on();
		                medical_heed_comments();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</div><!-- .entry-header -->

		<?php the_excerpt(); ?>
		
	    <div class="btns">
			<a href="<?php the_permalink(); ?>" class="btn btn-primary">
				<span><?php esc_html_e('Read More','medical-heed'); ?></span>
			</a>
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->