<?php
/**
 * Appearance → Elite Carpentry Setup: one click to build the starter site.
 *
 * Creates the Kitchens / Bathrooms / Services / About / Contact pages from the
 * theme's full-page patterns, adds sample Projects with photos, sets pretty
 * permalinks and fills in the site title. Safe to run more than once: existing
 * pages and projects (matched by slug) are left alone.
 *
 * @package Elite_Carpentry_Core
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', function () {
	add_theme_page(
		__( 'Elite Carpentry Setup', 'elite-carpentry-core' ),
		__( 'Elite Carpentry Setup', 'elite-carpentry-core' ),
		'manage_options',
		'elite-carpentry-setup',
		'elite_carpentry_render_setup_page'
	);
} );

/**
 * Pages to create: slug => [ title, pattern slug ].
 *
 * @return array<string, array{0:string,1:string}>
 */
function elite_carpentry_setup_pages() {
	return array(
		'kitchens'  => array( __( 'Kitchen Renovations', 'elite-carpentry-core' ), 'elite-carpentry/page-kitchens' ),
		'bathrooms' => array( __( 'Bathroom Renovations', 'elite-carpentry-core' ), 'elite-carpentry/page-bathrooms' ),
		'services'  => array( __( 'Services', 'elite-carpentry-core' ), 'elite-carpentry/page-services' ),
		'about'     => array( __( 'About Us', 'elite-carpentry-core' ), 'elite-carpentry/page-about' ),
		'contact'   => array( __( 'Contact', 'elite-carpentry-core' ), 'elite-carpentry/page-contact' ),
	);
}

/**
 * Sample projects: slug => [ title, type, image key, location, timeline, scope, description ].
 *
 * @return array<string, array>
 */
function elite_carpentry_setup_projects() {
	return array(
		'white-shaker-kitchen'    => array( 'White Shaker Kitchen with Walnut Island', 'Kitchen', 'kitchen-hero', 'Kitchener, ON', '6 weeks', 'Full kitchen renovation', 'Sample project: replace with your own photos and story. A dated galley kitchen opened up into a bright family kitchen with custom shaker cabinetry, a walnut-topped island and quartz perimeter counters.' ),
		'modern-open-kitchen'     => array( 'Modern Open-Concept Kitchen', 'Kitchen', 'kitchen-modern', 'Waterloo, ON', '7 weeks', 'Wall removal + kitchen', 'Sample project: replace with your own photos and story. A load-bearing wall came out to join the kitchen and family room, with flat-panel cabinetry and an integrated pantry wall.' ),
		'farmhouse-kitchen'       => array( 'Farmhouse Kitchen Refresh', 'Kitchen', 'kitchen-white', 'Elmira, ON', '4 weeks', 'Cabinets, counters, open shelving', 'Sample project: replace with your own photos and story. Open shelving, butcher block and a deep apron-front sink gave this century home a kitchen that fits its character.' ),
		'spa-ensuite'             => array( 'Spa Ensuite with Freestanding Tub', 'Bathroom', 'bath-tub', 'Waterloo, ON', '4 weeks', 'Primary ensuite renovation', 'Sample project: replace with your own photos and story. A cramped ensuite became a calm retreat with a freestanding soaker, heated floors and a custom double vanity.' ),
		'curbless-shower'         => array( 'Curbless Walk-in Shower Conversion', 'Bathroom', 'bath-modern', 'Cambridge, ON', '3 weeks', 'Tub-to-shower conversion', 'Sample project: replace with your own photos and story. An unused tub was replaced by a curbless walk-in shower with a linear drain, bench and frameless glass.' ),
		'basement-family-room'    => array( 'Basement Family Room &amp; Media Wall', 'Basement', 'basement', 'Guelph, ON', '8 weeks', 'Basement finishing', 'Sample project: replace with your own photos and story. A bare basement turned into a family room with a built-in media wall, guest bedroom and three-piece bath.' ),
	);
}

/**
 * Render the setup screen and run the import when submitted.
 */
function elite_carpentry_render_setup_page() {
	$log = array();
	if ( isset( $_POST['ec_run_setup'] ) && check_admin_referer( 'ec_run_setup' ) && current_user_can( 'manage_options' ) ) {
		$log = elite_carpentry_run_setup( array(
			'pages'      => ! empty( $_POST['ec_pages'] ),
			'projects'   => ! empty( $_POST['ec_projects'] ),
			'media'      => ! empty( $_POST['ec_media'] ),
			'permalinks' => ! empty( $_POST['ec_permalinks'] ),
			'identity'   => ! empty( $_POST['ec_identity'] ),
		) );
	}
	$theme_ok = function_exists( 'elite_carpentry_image_registry' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Elite Carpentry Setup', 'elite-carpentry-core' ); ?></h1>
		<?php if ( ! $theme_ok ) : ?>
			<div class="notice notice-warning"><p><?php esc_html_e( 'Activate the Elite Carpentry theme first — the pages are built from its patterns.', 'elite-carpentry-core' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $log ) : ?>
			<div class="notice notice-success"><ul style="list-style:disc;padding-left:1.5em">
				<?php foreach ( $log as $line ) : ?>
					<li><?php echo wp_kses_post( $line ); ?></li>
				<?php endforeach; ?>
			</ul></div>
		<?php endif; ?>
		<p><?php esc_html_e( 'Builds the starter site in one go. Anything that already exists (matched by its URL slug) is skipped, so this is safe to run again.', 'elite-carpentry-core' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'ec_run_setup' ); ?>
			<fieldset style="margin:1em 0;line-height:2">
				<label><input type="checkbox" name="ec_pages" value="1" checked> <?php esc_html_e( 'Create Kitchens, Bathrooms, Services, About and Contact pages', 'elite-carpentry-core' ); ?></label><br>
				<label><input type="checkbox" name="ec_projects" value="1" checked> <?php esc_html_e( 'Add 6 sample Projects (clearly marked as samples)', 'elite-carpentry-core' ); ?></label><br>
				<label><input type="checkbox" name="ec_media" value="1" checked> <?php esc_html_e( 'Copy the demo photos into the Media Library (needs outbound internet on your server)', 'elite-carpentry-core' ); ?></label><br>
				<label><input type="checkbox" name="ec_permalinks" value="1" checked> <?php esc_html_e( 'Use “Post name” permalinks (needed for /kitchens/, /projects/ …)', 'elite-carpentry-core' ); ?></label><br>
				<label><input type="checkbox" name="ec_identity" value="1" checked> <?php esc_html_e( 'Set site title and tagline if they are still the WordPress defaults', 'elite-carpentry-core' ); ?></label>
			</fieldset>
			<p><button class="button button-primary button-hero" name="ec_run_setup" value="1" <?php disabled( ! $theme_ok ); ?>><?php esc_html_e( 'Build my site', 'elite-carpentry-core' ); ?></button></p>
		</form>
		<h2><?php esc_html_e( 'Next steps', 'elite-carpentry-core' ); ?></h2>
		<ol>
			<li><?php printf( wp_kses_post( __( 'Enter your phone, email and hours in <a href="%s">Settings → Business Details</a>.', 'elite-carpentry-core' ) ), esc_url( admin_url( 'options-general.php?page=elite-carpentry-business' ) ) ); ?></li>
			<li><?php printf( wp_kses_post( __( 'Upload your logo and adjust colours and fonts in <a href="%s">Appearance → Editor</a>.', 'elite-carpentry-core' ) ), esc_url( admin_url( 'site-editor.php' ) ) ); ?></li>
			<li><?php esc_html_e( 'Replace the sample projects and placeholder testimonials with your real work and real reviews.', 'elite-carpentry-core' ); ?></li>
		</ol>
	</div>
	<?php
}

/**
 * Run the selected setup steps.
 *
 * @param array<string,bool> $steps Steps to run.
 * @return string[] Log lines (may contain safe HTML).
 */
function elite_carpentry_run_setup( $steps ) {
	$log = array();

	if ( $steps['identity'] ) {
		if ( in_array( get_option( 'blogname' ), array( '', 'My WordPress Website', 'My Blog', 'WordPress' ), true ) ) {
			update_option( 'blogname', 'Elite Carpentry' );
			$log[] = __( 'Site title set to “Elite Carpentry”.', 'elite-carpentry-core' );
		}
		if ( in_array( get_option( 'blogdescription' ), array( '', 'Just another WordPress site' ), true ) ) {
			update_option( 'blogdescription', 'Kitchens · Bathrooms · Custom Carpentry' );
			$log[] = __( 'Tagline set.', 'elite-carpentry-core' );
		}
	}

	if ( $steps['permalinks'] && '' === get_option( 'permalink_structure' ) ) {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		$log[] = __( 'Permalinks switched to “Post name”.', 'elite-carpentry-core' );
	}

	if ( $steps['pages'] ) {
		$registry = WP_Block_Patterns_Registry::get_instance();
		foreach ( elite_carpentry_setup_pages() as $slug => $page ) {
			if ( get_page_by_path( $slug ) ) {
				/* translators: %s: page slug */
				$log[] = sprintf( __( 'Page /%s/ already exists — skipped.', 'elite-carpentry-core' ), $slug );
				continue;
			}
			$pattern = $registry->get_registered( $page[1] );
			if ( ! $pattern ) {
				continue;
			}
			$id = wp_insert_post( array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => $page[0],
				'post_content' => $pattern['content'],
				'meta_input'   => array( '_wp_page_template' => 'page-landing' ),
			) );
			if ( $id && ! is_wp_error( $id ) ) {
				/* translators: 1: edit link, 2: page title */
				$log[] = sprintf( __( 'Created page <a href="%1$s">%2$s</a>.', 'elite-carpentry-core' ), esc_url( get_edit_post_link( $id ) ), esc_html( $page[0] ) );
			}
		}
	}

	if ( $steps['projects'] && function_exists( 'elite_carpentry_image_registry' ) ) {
		$media_ok = true;
		foreach ( elite_carpentry_setup_projects() as $slug => $project ) {
			if ( get_page_by_path( $slug, OBJECT, 'ec_project' ) ) {
				continue;
			}
			list( $title, $type, $image, $location, $duration, $scope, $text ) = $project;

			$term = term_exists( $type, 'ec_project_type' );
			if ( ! $term ) {
				$term = wp_insert_term( $type, 'ec_project_type' );
			}

			$id = wp_insert_post( array(
				'post_type'    => 'ec_project',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => wp_specialchars_decode( $title ),
				'post_excerpt' => wp_trim_words( $text, 22 ),
				'post_content' => "<!-- wp:paragraph -->\n<p>" . esc_html( $text ) . "</p>\n<!-- /wp:paragraph -->",
				'meta_input'   => array(
					'ec_location'          => $location,
					'ec_duration'          => $duration,
					'ec_scope'             => $scope,
					'_ec_remote_thumbnail' => elite_carpentry_img( $image, 1600 ),
				),
			) );
			if ( ! $id || is_wp_error( $id ) ) {
				continue;
			}
			if ( ! is_wp_error( $term ) ) {
				wp_set_object_terms( $id, (int) $term['term_id'], 'ec_project_type' );
			}
			if ( $steps['media'] && $media_ok ) {
				$attachment = elite_carpentry_sideload( $image, $id, wp_specialchars_decode( $title ) );
				if ( $attachment ) {
					set_post_thumbnail( $id, $attachment );
					delete_post_meta( $id, '_ec_remote_thumbnail' );
				} else {
					$media_ok = false; // Don't hammer a server that has no outbound access.
				}
			}
			/* translators: %s: project title */
			$log[] = sprintf( __( 'Added sample project “%s”.', 'elite-carpentry-core' ), esc_html( wp_specialchars_decode( $title ) ) );
		}
		if ( $steps['media'] && ! $media_ok ) {
			$log[] = __( 'Could not download demo photos to the Media Library, so projects show the photos from Unsplash directly. Set your own featured images when ready.', 'elite-carpentry-core' );
		}
	}

	flush_rewrite_rules();
	$log[] = sprintf(
		/* translators: %s: home URL */
		__( 'Done! <a href="%s" target="_blank">View your site →</a>', 'elite-carpentry-core' ),
		esc_url( home_url( '/' ) )
	);
	return $log;
}

/**
 * Copy one demo photo into the Media Library.
 *
 * @param string $key     Image registry key.
 * @param int    $post_id Parent post.
 * @param string $title   Attachment title / alt.
 * @return int Attachment ID or 0.
 */
function elite_carpentry_sideload( $key, $post_id, $title ) {
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$url = elite_carpentry_img( $key, 1800 );
	$tmp = download_url( $url, 20 );
	if ( is_wp_error( $tmp ) ) {
		return 0;
	}
	$file = array(
		'name'     => sanitize_file_name( $key ) . '.jpg',
		'tmp_name' => $tmp,
	);
	$id = media_handle_sideload( $file, $post_id, $title );
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', elite_carpentry_alt( $key ) );
	return (int) $id;
}
