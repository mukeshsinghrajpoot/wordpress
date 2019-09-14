<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Medical_Heed
 */

$post_content_type 	= apply_filters( 'medical_heed_post_content_type', 'excerpt' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="medical-post-wrap">

		<?php medical_heed_post_thumbnail(); ?>

		<div class="entry-header">
			<?php
				if ( is_singular() ) :
					the_title( '<h2 class="entry-title">', '</h2>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

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

		<div class="entry-content">
			<?php
				if( is_single( ) ){

					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'medical-heed' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );

				}else{

					if ( 'excerpt' === $post_content_type ) {

						the_excerpt();

					} elseif ( 'content' === $post_content_type ) {

						the_content( sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'medical-heed' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						) );
					}
				}
			?>
		</div>
		
		<?php if( ! is_single( ) ){ ?>
		    <div class="btns">
				<a href="<?php the_permalink(); ?>" class="btn btn-primary">
					<span><?php esc_html_e('Read More','medical-heed'); ?></span>
				</a>
			</div>
		<?php } ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
