<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Medical_Heed
 */

if ( ! function_exists( 'medical_heed_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function medical_heed_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'on %s', 'post date', 'medical-heed' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'medical_heed_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function medical_heed_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'medical-heed' ),
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
		);

		echo '<span class="byline author vcard"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'medical_heed_comments' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function medical_heed_comments() {

		echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
			
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'medical-heed' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

		echo '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'medical_heed_category' ) ) :

	function medical_heed_category() {
	/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'medical-heed' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( 'Category : %1$s', 'medical-heed' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'medical_heed_tags' ) ) :
	function medical_heed_tags() {
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'medical-heed' ) );
	if ( $tags_list ) {
		/* translators: 1: list of tags. */
		printf( '<span class="tags-links">' . esc_html__( 'Tagged : %1$s', 'medical-heed' ) . '</span>', $tags_list ); // WPCS: XSS OK.
	}
	}
endif;

if ( ! function_exists( 'medical_heed_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function medical_heed_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'medical-heed' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'medical-heed' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'medical-heed' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'medical-heed' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'medical-heed' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'medical-heed' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'medical_heed_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function medical_heed_post_thumbnail() {
		$sidebar = get_theme_mod('medical_heed_sidebar_options','right');
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) : ?>
			<div class="post-thumbnail">
				<?php 
					if ($sidebar == 'no' ){
						the_post_thumbnail( 'medical-head-image-size' );
					}else{
						the_post_thumbnail( 'medical-head-single-image' );
					}
				?>
			</div><!-- .post-thumbnail -->
		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
				if ($sidebar == 'no' ){
					the_post_thumbnail( 'medical-head-image-size' );
				}
				else{
					the_post_thumbnail( 'medical-head-single-image' );
				}
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;


if ( ! function_exists( 'medical_heed_section_title' ) ) :
  /**
   * All Section Main Title & Sub Title
   *
   * @since 1.0.0
  */
  function medical_heed_section_title( $title, $subtitle ) { 
  
   if( !empty( $title ) || !empty( $subtitle ) ){ ?>
	    <div class="row">
			<div class="col-lg-12">
		        <h2><?php echo esc_html( $title ); ?></h2>
		        <p><?php echo esc_html( $subtitle ); ?></p>
	        </div>
	    </div>
    
    <?php }

  }
endif;

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function medical_heed_excerpt_length( $length ) {

  if( is_admin() ){

    return $length;
    
  }else{
  	
  	if( is_front_page() ){

    	return 25;

  	}else{

  		return 45;

  	}

  }

}
add_filter( 'excerpt_length', 'medical_heed_excerpt_length', 999 );


/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function medical_heed_excerpt_more($text){

    if( is_admin() ){

        return $text;
    }

    return '&hellip;';
}
add_filter( 'excerpt_more', 'medical_heed_excerpt_more' );


if (! function_exists( 'medical_heed_social' ) ) :
	/**
	 * Header Social Links 
	*/
	function medical_heed_social(){
	  
		$facebook  = get_theme_mod('medical_heed_facebook');
		$twitter   = get_theme_mod('medical_heed_twitter');
		$instagram = get_theme_mod('medical_heed_instagram');
		$youtube   = get_theme_mod('medical_heed_youtube');
	?>
		<?php if (!empty ($facebook)) { ?>
			<li>
				<a href="<?php echo esc_url($facebook); ?>">
					<i class="fab fa-facebook"></i>
				</a>
			</li>
		<?php } if (!empty ($twitter)) { ?>
			<li>
				<a href="<?php echo esc_url($twitter); ?>">
					<i class="fab fa-twitter"></i>
				</a>
			</li>
		<?php } if (!empty ($instagram)) { ?>
			<li>
				<a href="<?php echo esc_url($instagram); ?>">
					<i class="fab fa-instagram"></i>
				</a>
			</li>
		<?php } if (!empty ($youtube)) { ?>
			<li>
				<a href="<?php echo esc_url($youtube); ?>">
					<i class="fab fa-youtube"></i>
				</a>
			</li>
		<?php } ?>
	<?php }
	
endif;


if(! function_exists( 'medical_heed_info' ) ) :
	/**
	 * Header Information.  
	*/
	function medical_heed_info(){
		$location      = get_theme_mod('medical_heed_location');
	    $opening_time  = get_theme_mod('medical_heed_time');
	    $contact       = get_theme_mod('medical_heed_contact');
	    $contact_num   = preg_replace('/\D+/','', $contact );
	    $email         = get_theme_mod('medical_heed_email');
	?>
		<?php
		    if (!empty ( $location ) ): ?>

		        <li>
		            <i class="fas fa-map-marker-alt"></i>
		            <?php echo esc_html( $location ); ?>
		        </li>

			<?php endif; if (!empty( $opening_time )): ?>

			    <li>
			        <i class="far fa-clock"></i>
			        <?php echo esc_html( $opening_time ); ?>
			    </li>

			<?php endif; if (!empty ( $contact_num ) ) : ?>

			    <li>
			    	<a href="<?php echo esc_attr( $contact_num ); ?>"><i class="fas fa-mobile-alt"></i> <?php echo esc_html( $contact_num ); ?> </a>
			    </li>

			<?php endif; if (!empty ( $email ) ) : ?>

			    <li>
			    	<i class="fas fa-envelope"></i>
	                <a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>" class="email">
	                    <?php echo esc_attr( antispambot( $email ) ); ?>
	                </a>
			    </li>
		<?php endif; ?>
	<?php  }

endif;


if(! function_exists( 'medical_heed_copyright' ) ) :
	/**
	 * Sub Footer Area  
	*/
	function medical_heed_copyright(){ ?>
	    <div class="copyright">
	        <div class="container">

	        	<div class="col-lg-6 col-md-6 col-sm-12">
		        	<p>
			            <?php 
			            	$copyright =  get_theme_mod('medical_heed_footer_content');

			            	if( !empty( $copyright ) ) { 

					            echo esc_html( apply_filters( 'medical_heed_copyright_text', $copyright ) ); 

					        } else { 

					            echo esc_html( apply_filters( 'medical_heed_copyright_text', $content = esc_html__('Copyright  &copy; ','medical-heed') . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) .' - ' ) );
					        }

							/* translators: %s: CMS name, i.e. WordPress. */
							printf( ' WordPress Theme : By %1$s', '<a href=" ' . esc_url('https://sparklewpthemes.com/') . ' " rel="designer" target="_blank">'.esc_html__('Sparkle Themes','medical-heed').'</a>' ); 
						?>
					</p>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-12">
					<?php
		                wp_nav_menu( array( 'theme_location' => 'menu-2', 'depth' => 1 ) );
		            ?>
	            </div>
	        </div><!-- container -->
	    </div><!-- copyright -->
	<?php }
endif;



/**
 * Notice after Theme Activation.
*/
function medical_heed_activation_notice() {
	$theme_data	 = wp_get_theme();
	echo '<div class="notice notice-success is-dismissible medicalheed-activation-notice">';
		
		echo '<h1>';
			/* translators: %s theme name */
			printf( esc_html__( 'Welcome to %s', 'medical-heed' ), esc_html( $theme_data->Name ) );
		echo '</h1>';

		echo '<p>';
			/* translators: %1$s: theme name, %2$s link */
			printf( __( 'Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'medical-heed' ), esc_html( $theme_data->Name ), esc_url( admin_url( 'themes.php?page=about-medicalheed' ) ) );
		echo '</p>';

		echo '<p><a href="'. esc_url( admin_url( 'themes.php?page=about-medicalheed' ) ) .'" class="button button-primary button-hero">';
		
			/* translators: %s theme name */
			printf( esc_html__( 'Get started with %s', 'medical-heed' ), esc_html( $theme_data->Name ) );
		echo '</a></p>';

	echo '</div>';
}