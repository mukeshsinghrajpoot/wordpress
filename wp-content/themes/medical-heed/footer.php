<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Medical_Heed
 */

?>
    </div><!-- #content -->

	<footer id="colophon" class="site-footer">
        
        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
    		
            <div class="upper-footer">
                <div class="container">
                    <?php

                        $widget_count = 0;

                        for ( $i = 1; $i <= 3; $i++ ) {
                            if ( is_active_sidebar( 'footer-' . $i ) ) {
                                $widget_count++;
                            }
                        }

                        $widget_count   = 12 / $widget_count;

                        $widget_class   = 'col-md-' . absint( $widget_count );

                        for ( $i = 1; $i <= 3 ; $i++ ) {

                            if ( is_active_sidebar( 'footer-' . $i ) ) { ?>

                            <div class="<?php echo esc_attr( $widget_class ); ?> col-sm-6 col-xs-12">

                                <?php dynamic_sidebar( 'footer-' . $i ); ?>

                            </div>

                    <?php } } ?>
                </div>
            </div><!-- upper-footer -->

        <?php endif; 

            medical_heed_copyright();
        ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
