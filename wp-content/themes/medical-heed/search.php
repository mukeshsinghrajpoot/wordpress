<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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

                            /**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );
                            
                        endwhile; // End of the loop.

                        the_posts_pagination( 
                          array(
                                'prev_text' => esc_html__( 'Prev', 'medical-heed' ),
                                'next_text' => esc_html__( 'Next', 'medical-heed' ),
                            )
                        );

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