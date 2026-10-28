<?php
/**
 * Elite Carpentry theme functions.
 *
 * @package Elite_Carpentry
 */

defined( 'ABSPATH' ) || exit;

define( 'ELITE_CARPENTRY_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/images.php';

/**
 * Google Fonts stylesheet URL (Fraunces + Inter).
 *
 * To self-host instead, install both families from Appearance → Editor →
 * Styles → Typography → Manage fonts, then return '' from the
 * `elite_carpentry_fonts_url` filter.
 *
 * @return string
 */
function elite_carpentry_fonts_url() {
	$url = 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap';
	return apply_filters( 'elite_carpentry_fonts_url', $url );
}

/**
 * Theme setup.
 */
function elite_carpentry_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	$editor_styles = array( 'assets/css/theme.css' );
	if ( elite_carpentry_fonts_url() ) {
		$editor_styles[] = elite_carpentry_fonts_url();
	}
	add_editor_style( $editor_styles );

	add_image_size( 'elite-card', 800, 600, true );
}
add_action( 'after_setup_theme', 'elite_carpentry_setup' );

/**
 * Front-end assets.
 */
function elite_carpentry_assets() {
	if ( elite_carpentry_fonts_url() ) {
		wp_enqueue_style( 'elite-carpentry-fonts', elite_carpentry_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	}
	wp_enqueue_style(
		'elite-carpentry',
		get_template_directory_uri() . '/assets/css/theme.css',
		array(),
		ELITE_CARPENTRY_VERSION
	);
	wp_enqueue_script(
		'elite-carpentry',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		ELITE_CARPENTRY_VERSION,
		array( 'strategy' => 'defer', 'in_footer' => true )
	);
}
add_action( 'wp_enqueue_scripts', 'elite_carpentry_assets' );

/**
 * Preconnect to the font and image hosts.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function elite_carpentry_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		if ( elite_carpentry_fonts_url() ) {
			$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		}
		$urls[] = 'https://images.unsplash.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'elite_carpentry_resource_hints', 10, 2 );

/**
 * Pattern categories shown in the inserter.
 */
function elite_carpentry_pattern_categories() {
	register_block_pattern_category( 'elite-carpentry', array(
		'label'       => __( 'Elite Carpentry', 'elite-carpentry' ),
		'description' => __( 'Sections for renovation pages: heroes, services, galleries, process, FAQs.', 'elite-carpentry' ),
	) );
	register_block_pattern_category( 'elite-carpentry-pages', array(
		'label'       => __( 'Elite Carpentry: full pages', 'elite-carpentry' ),
		'description' => __( 'Complete starter pages for Kitchens, Bathrooms, About and Contact.', 'elite-carpentry' ),
	) );
}
add_action( 'init', 'elite_carpentry_pattern_categories' );

/**
 * Block style variations (Styles panel in the block sidebar).
 */
function elite_carpentry_block_styles() {
	register_block_style( 'core/group', array(
		'name'  => 'card',
		'label' => __( 'Card', 'elite-carpentry' ),
	) );
	register_block_style( 'core/group', array(
		'name'  => 'card-hover',
		'label' => __( 'Card (lifts on hover)', 'elite-carpentry' ),
	) );
	register_block_style( 'core/list', array(
		'name'  => 'checklist',
		'label' => __( 'Checklist', 'elite-carpentry' ),
	) );
	register_block_style( 'core/image', array(
		'name'  => 'offset-frame',
		'label' => __( 'Offset frame', 'elite-carpentry' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'outline-light',
		'label' => __( 'Outline (on dark)', 'elite-carpentry' ),
	) );
	register_block_style( 'core/heading', array(
		'name'  => 'eyebrow',
		'label' => __( 'Eyebrow label', 'elite-carpentry' ),
	) );
	register_block_style( 'core/paragraph', array(
		'name'  => 'eyebrow',
		'label' => __( 'Eyebrow label', 'elite-carpentry' ),
	) );
}
add_action( 'init', 'elite_carpentry_block_styles' );

/**
 * Nudge admins toward the companion plugin, which provides Projects,
 * the quote form and editable business details.
 */
function elite_carpentry_plugin_notice() {
	if ( defined( 'ELITE_CARPENTRY_CORE_VERSION' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->id, array( 'themes', 'dashboard', 'plugins' ), true ) ) {
		return;
	}
	printf(
		'<div class="notice notice-info"><p>%s</p></div>',
		esc_html__( 'Elite Carpentry theme: activate the "Elite Carpentry Core" plugin to enable Projects, the quote request form, business details and one-click demo setup.', 'elite-carpentry' )
	);
}
add_action( 'admin_notices', 'elite_carpentry_plugin_notice' );

/**
 * Flag JS support before first paint so scroll-reveal sections don't flash.
 */
function elite_carpentry_js_class() {
	echo "<script>document.documentElement.classList.add('js');</script>\n";
}
add_action( 'wp_head', 'elite_carpentry_js_class', 1 );
