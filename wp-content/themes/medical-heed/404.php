<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Medical_Heed
 */

get_header(); ?>
<div class="error-page">
    <div class="container">
        <div class="col-lg-12">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">

					<section class="error-404 not-found">

						<header class="page-header">
							<h1><?php esc_html_e('404','medical-heed'); ?></h1>
							<h4 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'medical-heed' ); ?></h4>
						</header><!-- .page-header -->

						<div class="page-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'medical-heed' ); ?></p>
						</div><!-- .page-content -->
						
						<div class="btns">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
								<span><?php esc_html_e('Back To Home','medical-heed'); ?></span>
							</a>
						</div>

					</section><!-- .error-404 -->

				</main><!-- #main -->
			</div><!-- #primary -->
	    </div>
    </div>
</div>

<?php get_footer();