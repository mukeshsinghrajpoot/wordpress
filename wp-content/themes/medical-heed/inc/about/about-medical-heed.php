<?php
/**
 * Add ABout Theme Page
*/
function medical_heed_about_page() {
	add_theme_page( esc_html__( 'About Medical Heed', 'medical-heed' ), esc_html__( 'About Medical Heed', 'medical-heed' ), 'edit_theme_options', 'about-medicalheed', 'medical_heed_about_page_output' );
}
add_action( 'admin_menu', 'medical_heed_about_page' );


/**
 * Render About Themes HTML
*/
function medical_heed_about_page_output() {
	$theme_data	 = wp_get_theme();
?>
	<div class="wrap">
		<h1>
			<?php /* translators: %s theme name */
				printf( esc_html__( 'Welcome to %s', 'medical-heed' ), esc_html( $theme_data->Name ) );
			?>
		</h1>
		<p class="welcome-text">
			<?php /* translators: %s theme name */
					printf( esc_html__( '%s is clean & beautiful free multipurpose medical WordPress theme, This theme well suited for a hospital, general clinics, nursing home, dental, gynecology, veterinary clinics, pediatric and overall medial websites as well as personal portfolio sites for doctors, surgeons, gynecologist, general therapist, and all medical sector people. Medical Heed is one of the most accessible themes which can easily accommodate all type of users with no coding skills to advanced developers. Medical Heed includes excellent features for medical professionals and practices of all kinds, with one click demo data import, customizer based theme options, page builder-friendly design, page &  post layout options. This Free Medical WordPress theme is fully responsive, cross-browser compatible, translation ready, SEO friendly and social media integration.', 'medical-heed' ), esc_html( $theme_data->Name ) );
				?>
				<br><br><a href="<?php echo esc_url('http://demo.sparklewpthemes.com/medicalheed/'); ?>" class="button button-primary button-hero" target="_blank"><?php esc_html_e( 'Theme Demo Preview', 'medical-heed' ); ?></a>
		</p><br>
		<?php
			/**
			 * Active Tab
			*/
			if ( isset($_GET[ 'tab' ]) ) {
				$active_tab = sanitize_key($_GET[ 'tab' ]);
			} else {
				$active_tab = 'medical_heed_tab_1';
			}
		?>
		<div class="nav-tab-wrapper">
			<a href="?page=about-medicalheed&tab=medical_heed_tab_1" class="nav-tab <?php echo $active_tab == 'medical_heed_tab_1' ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Getting Started', 'medical-heed' ); ?>
			</a>
			<a href="?page=about-medicalheed&tab=medical_heed_tab_2" class="nav-tab <?php echo $active_tab == 'medical_heed_tab_2' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-video-alt3"></span><?php esc_html_e( 'Video Tutorials', 'medical-heed' ); ?>
			</a>
			<a href="?page=about-medicalheed&tab=medical_heed_tab_3" class="nav-tab <?php echo $active_tab == 'medical_heed_tab_3' ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Useful Plugins', 'medical-heed' ); ?>
			</a>
			<a href="?page=about-medicalheed&tab=medical_heed_tab_4" class="nav-tab <?php echo $active_tab == 'medical_heed_tab_4' ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Support', 'medical-heed' ); ?>
			</a>
			<a href="?page=about-medicalheed&tab=medical_heed_tab_5" class="nav-tab <?php echo $active_tab == 'medical_heed_tab_5' ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Free vs Pro', 'medical-heed' ); ?>
			</a>
		</div>

		<?php if ( $active_tab == 'medical_heed_tab_1' ) : ?>
			<div class="three-columns-wrap">
				<br>
				<div class="column-width-3">
					<h3><?php esc_html_e( 'Documentation', 'medical-heed' ); ?></h3>
					<p>
						<?php /* translators: %s theme name */
							printf( esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use %s.', 'medical-heed' ), esc_html( $theme_data->Name ) );
						?>
					</p>
					<a target="_blank" href="http://docs.sparklewpthemes.com/medicalheed/" class="button button-primary"><?php esc_html_e( 'Read Full Documentation', 'medical-heed' ); ?></a>
				</div>

				<div class="column-width-3">
					<h3><?php esc_html_e( 'Demo Content', 'medical-heed' ); ?></h3>
					<p>
						<?php esc_html_e( 'Install the Demo Content in 2 clicks. Just click the button below to install demo import plugin and wait a bit to be redirected to the demo import page.', 'medical-heed' ); ?>
					</p>
					<?php if ( is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' ) ) : ?>
						<a href="<?php echo esc_url( admin_url( '/themes.php?page=pt-one-click-demo-import' ) ); ?>" class="button button-primary demo-import"><?php esc_html_e( 'Go to Import page', 'medical-heed' ); ?></a>
					<?php elseif ( medical_heed_check_installed_plugin( 'one-click-demo-import', 'one-click-demo-import' ) ) : ?>
						<button class="button button-primary demo-import" id="medicalheed-demo-content-act"><?php esc_html_e( 'Activate Demo Import Plugin', 'medical-heed' ); ?></button>
					<?php else: ?>
						<button class="button button-primary demo-import" id="medicalheed-demo-content-inst"><?php esc_html_e( 'Install Demo Import Plugin', 'medical-heed' ); ?></button>
					<?php endif; ?>
					<!-- <a href="#" target="_blank" class="button button-primary import-video"><span class="dashicons dashicons-video-alt3"></span><?php esc_html_e( 'Video Tutorial', 'medical-heed' ); ?></a> -->
				</div>

				<div class="column-width-3">
					<h3><?php esc_html_e( 'Theme Customizer', 'medical-heed' ); ?></h3>
					<p>
						<?php /* translators: %s theme name */
							printf( esc_html__( '%s supports the Theme Customizer for all theme settings. Click "Customize" to personalize your site.', 'medical-heed' ), esc_html( $theme_data->Name ) );
						?>
					</p>
					<a target="_blank" href="<?php echo esc_url( wp_customize_url() );?>" class="button button-primary"><?php esc_html_e( 'Start Customizing', 'medical-heed' ); ?></a>
				</div>

			</div>

			<!-- Predefined Styles -->
			<div class="four-columns-wrap">
				<hr>
			
				<h2><?php esc_html_e( 'Medical Heed Pro - Predefined Styles', 'medical-heed' ); ?></h2>
				<p></p>
				<div class="column-width-4">
					<div class="active-style"><?php esc_html_e( 'Active', 'medical-heed' ); ?></div>
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/medicalheedpro.png'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Demo One', 'medical-heed' ); ?></h2>
						<a href="<?php echo esc_url('http://demo.sparklewpthemes.com/medicalheedpro/'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'medical-heed' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/medicalheedpro-two.png'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Demo Two', 'medical-heed' ); ?></h2>
						<a href="<?php echo esc_url('http://demo.sparklewpthemes.com/medicalheedpro/sample-v1/'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'medical-heed' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/medicalheedpro-one.png'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Demo Three', 'medical-heed' ); ?></h2>
						<a href="<?php echo esc_url('http://demo.sparklewpthemes.com/medicalheedpro/sample-v2/'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'medical-heed' ); ?></a>
					</div>
				</div>

			</div>
		
		<?php elseif ( $active_tab == 'medical_heed_tab_2' ) : ?>

			<div class="four-columns-wrap video-tutorials">

				<div class="column-width-4">
					<h3><?php esc_html_e( 'Demo Content', 'medical-heed' ); ?></h3>
					<a class="button button-primary" target="_blank" href="h#"><?php esc_html_e( 'Watch Video', 'medical-heed' ); ?></a>
					<a class="button button-secondary" href="<?php echo esc_url(admin_url('themes.php?page=about-medicalheed&tab=medical_heed_tab_1')); ?>"></span><?php esc_html_e( 'Get Started', 'medical-heed' ); ?></a>
				</div>

			</div>

		<?php elseif ( $active_tab == 'medical_heed_tab_3' ) : ?>
			
			<div class="three-columns-wrap">
				<br><br>
				<?php

					// Contact Form 7
					medical_heed_recommended_plugin( 'contact-form-7', 'wp-contact-form-7' );

					// Ajax Thumbnail Rebuild
					medical_heed_recommended_plugin( 'ajax-thumbnail-rebuild', 'ajax-thumbnail-rebuild' );

				?>
			</div>

		<?php elseif ( $active_tab == 'medical_heed_tab_4' ) : ?>

			<div class="three-columns-wrap">
				<br>
				<div class="column-width-3">
					<h3>
						<span class="dashicons dashicons-sos"></span>
						<?php esc_html_e( 'Forums', 'medical-heed' ); ?>
					</h3>
					<p>
						<?php esc_html_e( 'Before asking a questions it\'s highly recommended to search on forums, but if you can\'t find the solution feel free to create a new topic.', 'medical-heed' ); ?>
						<hr>
						<a target="_blank" href="<?php echo esc_url('https://sparklewpthemes.com/support/forum/wordpress-themes/free-themes/medical-heed/'); ?>"><?php esc_html_e( 'Go to Support Forums', 'medical-heed' ); ?></a>
					</p>
				</div>

				<div class="column-width-3">
					<h3>
						<span class="dashicons dashicons-admin-tools"></span>
						<?php esc_html_e( 'Changelog', 'medical-heed' ); ?>
					</h3>
					<p>
						<?php esc_html_e( 'Want to get the gist on the latest theme changes? Just consult our changelog below to get a taste of the recent fixes and features implemented.', 'medical-heed' ); ?>
						<hr>
						<a target="_blank" href="<?php echo esc_url('https://sparklewpthemes.com/update-logs/medical-heed-update-logs/'); ?>"><?php esc_html_e( 'Changelog', 'medical-heed' ); ?></a>
					</p>
				</div>

			</div>

	    <?php elseif ( $active_tab == 'medical_heed_tab_5' ) : ?>

			<table class="free-vs-pro form-table">
				<thead>
					<tr>
						<th>
							<a href="<?php echo esc_url('https://sparklewpthemes.com/wordpress-themes/medicalheedpro/'); ?>" target="_blank" class="button button-primary button-hero">
								<?php esc_html_e( 'Get Medical Heed Pro', 'medical-heed' ); ?>
							</a>
						</th>
						<th class="compare-icon"><?php esc_html_e( 'Medical Heed', 'medical-heed' ); ?></th>
						<th class="compare-icon"><?php esc_html_e( 'Medical Heed Pro', 'medical-heed' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<h3><?php esc_html_e( 'One Click Demo Import', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Unlimited Colors Options', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Multiple Header Layouts', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><?php esc_html_e('1+','medical-heed'); ?></span></td>
						<td class="compare-icon"><?php esc_html_e('4+','medical-heed'); ?></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Advanced Slider Options', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Reorder All Sections', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Reorder All Sections', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Powerful Option Panel', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Footer Copyrights Editor', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Breadcrumbs Settings', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Pre Loader', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Sticky Navigation', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Sticky Sidebar', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'WooCommerce Support', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Contact Form 7 Plugin Compatible', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Premium Support 24/7', 'medical-heed' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>

					<tr>
						<td colspan="3">
							<a href="<?php echo esc_url('https://sparklewpthemes.com/wordpress-themes/medicalheedpro/'); ?>" target="_blank" class="button button-primary button-hero">
								<strong><?php esc_html_e( 'View Full Feature List', 'medical-heed' ); ?></strong>
							</a>
						</td>
					</tr>
				</tbody>
			</table>

	    <?php endif; ?>

	</div><!-- /.wrap -->
<?php
} // end medical_heed_about_page_output

// Check if plugin is installed
function medical_heed_check_installed_plugin( $slug, $filename ) {
	return file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $filename . '.php' ) ? true : false;
}

// Generate Recommended Plugin HTML
function medical_heed_recommended_plugin( $slug, $filename ) {

	$plugin_info = medical_heed_call_plugin_api( $slug );
	$plugin_desc = $plugin_info->short_description;
	$plugin_img  = ( ! isset($plugin_info->icons['1x']) ) ? $plugin_info->icons['default'] : $plugin_info->icons['1x'];
?>

	<div class="plugin-card">
		<div class="name column-name">
			<h3>
				<?php echo esc_html( $plugin_info->name ); ?>
				<img src="<?php echo esc_url( $plugin_img ); ?>" class="plugin-icon" alt="">
			</h3>
		</div>
		<div class="action-links">
			<?php if ( medical_heed_check_installed_plugin( $slug, $filename ) ) : ?>
			<button type="button" class="button button-disabled" disabled="disabled"><?php esc_html_e( 'Installed', 'medical-heed' ); ?></button>
			<?php else : ?>
			<a class="install-now button-primary" href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin='. $slug ), 'install-plugin_'. $slug ) ); ?>" >
				<?php esc_html_e( 'Install Now', 'medical-heed' ); ?>
			</a>							
			<?php endif; ?>
		</div>
		<div class="desc column-description">
			<p><?php echo esc_html( $plugin_desc ) . esc_html__( '...', 'medical-heed' ); ?></p>
		</div>
	</div>

<?php
}

// Get Plugin Info
function medical_heed_call_plugin_api( $slug ) {

	$call_api = get_transient( 'medical_heed_about_plugin_info_' . $slug );

	if ( false === $call_api ) {

	    if ( ! function_exists( 'plugins_api' ) && file_exists( trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin-install.php' ) ) {
	        require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin-install.php' );
	    }

	    if ( function_exists( 'plugins_api' ) ) {

			$call_api = plugins_api(
				'plugin_information', array(
					'slug'   => $slug,
					'fields' => array(
						'downloaded'        => false,
						'rating'            => false,
						'description'       => false,
						'short_description' => true,
						'donate_link'       => false,
						'tags'              => false,
						'sections'          => true,
						'homepage'          => true,
						'added'             => false,
						'last_updated'      => false,
						'compatibility'     => false,
						'tested'            => false,
						'requires'          => false,
						'downloadlink'      => false,
						'icons'             => true,
					),
				)
			);

			if ( ! is_wp_error( $call_api ) ) {
				set_transient( 'medical_heed_about_plugin_info_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
			}

		}
	}

	return $call_api;
}


// enqueue ui CSS/JS
function medical_heed_enqueue_about_page_scripts($hook) {

	if ( 'appearance_page_about-medicalheed' != $hook ) {
		return;
	}

	wp_enqueue_style( 'craft-blog-about-css', get_theme_file_uri( '/inc/about/css/about-page.css' ), array() );
	wp_enqueue_script( 'plugin-install' );
	wp_enqueue_script( 'updates' );
	wp_enqueue_script( 'craft-blog-about-page-css', get_theme_file_uri( '/inc/about/js/about-medicalheed-page.js' ), array() );

}
add_action( 'admin_enqueue_scripts', 'medical_heed_enqueue_about_page_scripts' );


// Install/Activate Demo Import Plugin 
function medical_heed_plugin_auto_activation() {

	// Get the list of currently active plugins (Most likely an empty array)
	$active_plugins = (array) get_option( 'active_plugins', array() );

	array_push( $active_plugins, 'one-click-demo-import/one-click-demo-import.php' );

	// Set the new plugin list in WordPress
	update_option( 'active_plugins', $active_plugins );

}
add_action( 'wp_ajax_medical_heed_plugin_auto_activation', 'medical_heed_plugin_auto_activation' );


// Import Plugin Data
function medical_heed_import_demo_files() {
	return array(
		array(
			'import_file_name'             => esc_html__( 'Import Demo Data', 'medical-heed' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/about/import/medicalheed-demo.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/about/import/medicalheed-widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/about/import/medicalheed-customizer.dat'
		)
	);
}
add_filter( 'pt-ocdi/import_files', 'medical_heed_import_demo_files' );

// Install Menus after Import
function medical_heed_after_import_setup() {
	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$top_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'menu-1' => $main_menu->term_id,
			'menu-2'  => $top_menu->term_id,
		)
	);
}
add_action( 'pt-ocdi/after_import', 'medical_heed_after_import_setup' );

// Disable PT Branding after Import Notice
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );