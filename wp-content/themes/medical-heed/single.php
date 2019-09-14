<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Medical_Heed
 */

get_header();

    $sidebar = get_theme_mod('medical_heed_sidebar_options','right');

    if ($sidebar == 'no' ) { 

        $colid = 12;

    } elseif ($sidebar == 'right' || $sidebar == 'left'){

        $colid = 8;

    } 
?>

<div class="container">

    <div class="row">

        <?php  if ($sidebar == 'left') { get_sidebar(); } ?>

        <div id="primary" class="col-lg-<?php echo intval ( $colid ); ?> col-md-<?php echo intval ( $colid ); ?> col-sm-12 content-area">
            
            <main id="main" class="site-main">
                <?php
                    if ( have_posts() ) :

                        while ( have_posts() ) :
                            the_post();

                            /*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
                            
                        endwhile; // End of the loop.
                ?>
                	<div class="prevNextArticle box">
						<div class="row">
							<div class="col-xs-6">
								<?php previous_post_link( '%link', '<div class="hoverExtend active"><span>'.esc_html__('Previous','medical-heed').'</span></div><div class="title">%title</div>' ); ?>
							</div>

							<div class="col-xs-6">
								<?php next_post_link( '%link', '<div class="hoverExtend active"><span>'.esc_html__('Next','medical-heed').'</span></div><div class="title">%title</div>' ); ?>
							</div>
						</div>
					</div><!-- Previous / next article -->
                <?php
                	// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :

						comments_template();

					endif;

                    else :

                       get_template_part( 'template-parts/content', 'none' );

                    endif;
                ?>
            </main><!-- #main -->

        </div><!-- #primary -->

        <?php if ($sidebar == 'right') { get_sidebar(); } ?> 
          
    </div>

</div>

<?php get_footer();