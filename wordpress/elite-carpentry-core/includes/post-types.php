<?php
/**
 * Projects (portfolio) and Quote Requests post types.
 *
 * @package Elite_Carpentry_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register post types, taxonomy and project meta.
 */
function elite_carpentry_register_post_types() {
	register_post_type( 'ec_project', array(
		'labels'        => array(
			'name'               => __( 'Projects', 'elite-carpentry-core' ),
			'singular_name'      => __( 'Project', 'elite-carpentry-core' ),
			'add_new_item'       => __( 'Add New Project', 'elite-carpentry-core' ),
			'edit_item'          => __( 'Edit Project', 'elite-carpentry-core' ),
			'view_item'          => __( 'View Project', 'elite-carpentry-core' ),
			'all_items'          => __( 'All Projects', 'elite-carpentry-core' ),
			'search_items'       => __( 'Search Projects', 'elite-carpentry-core' ),
			'not_found'          => __( 'No projects found.', 'elite-carpentry-core' ),
			'featured_image'     => __( 'Project photo', 'elite-carpentry-core' ),
			'set_featured_image' => __( 'Set project photo', 'elite-carpentry-core' ),
		),
		'public'        => true,
		'has_archive'   => 'projects',
		'rewrite'       => array( 'slug' => 'projects', 'with_front' => false ),
		'menu_icon'     => 'dashicons-hammer',
		'menu_position' => 20,
		'show_in_rest'  => true,
		'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
		'template'      => array(
			array( 'core/paragraph', array( 'placeholder' => __( 'Describe the project: what the client wanted, what you built, and the details you are proud of…', 'elite-carpentry-core' ) ) ),
			array( 'core/gallery', array( 'linkTo' => 'none' ) ),
		),
	) );

	register_taxonomy( 'ec_project_type', 'ec_project', array(
		'labels'            => array(
			'name'          => __( 'Project Types', 'elite-carpentry-core' ),
			'singular_name' => __( 'Project Type', 'elite-carpentry-core' ),
			'add_new_item'  => __( 'Add New Project Type', 'elite-carpentry-core' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'project-type', 'with_front' => false ),
	) );

	foreach ( elite_carpentry_project_meta_fields() as $key => $label ) {
		register_post_meta( 'ec_project', $key, array(
			'type'              => 'string',
			'label'             => $label,
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
	}

	register_post_type( 'ec_lead', array(
		'labels'          => array(
			'name'          => __( 'Quote Requests', 'elite-carpentry-core' ),
			'singular_name' => __( 'Quote Request', 'elite-carpentry-core' ),
			'edit_item'     => __( 'Quote Request', 'elite-carpentry-core' ),
			'all_items'     => __( 'Quote Requests', 'elite-carpentry-core' ),
			'not_found'     => __( 'No quote requests yet.', 'elite-carpentry-core' ),
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_icon'       => 'dashicons-email-alt',
		'menu_position'   => 21,
		'supports'        => array( 'title' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
}
add_action( 'init', 'elite_carpentry_register_post_types' );

/**
 * Project detail fields: meta key => label.
 *
 * @return array<string,string>
 */
function elite_carpentry_project_meta_fields() {
	return array(
		'ec_location' => __( 'Location', 'elite-carpentry-core' ),
		'ec_duration' => __( 'Timeline', 'elite-carpentry-core' ),
		'ec_scope'    => __( 'Scope', 'elite-carpentry-core' ),
	);
}

/**
 * Project details meta box (the block editor also exposes these via Custom Fields).
 */
function elite_carpentry_project_meta_box() {
	add_meta_box( 'ec-project-details', __( 'Project details', 'elite-carpentry-core' ), 'elite_carpentry_render_project_meta_box', 'ec_project', 'side' );
}
add_action( 'add_meta_boxes', 'elite_carpentry_project_meta_box' );

/**
 * Render the project details meta box.
 *
 * @param WP_Post $post Current post.
 */
function elite_carpentry_render_project_meta_box( $post ) {
	wp_nonce_field( 'ec_project_meta', 'ec_project_meta_nonce' );
	$placeholders = array(
		'ec_location' => 'Waterloo, ON',
		'ec_duration' => '4 weeks',
		'ec_scope'    => 'Full gut renovation',
	);
	foreach ( elite_carpentry_project_meta_fields() as $key => $label ) {
		printf(
			'<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="text" class="widefat" id="%1$s" name="%1$s" value="%3$s" placeholder="%4$s"></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( get_post_meta( $post->ID, $key, true ) ),
			esc_attr( $placeholders[ $key ] )
		);
	}
}

/**
 * Save the project details meta box.
 *
 * @param int $post_id Post ID.
 */
function elite_carpentry_save_project_meta( $post_id ) {
	if ( ! isset( $_POST['ec_project_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ec_project_meta_nonce'] ), 'ec_project_meta' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array_keys( elite_carpentry_project_meta_fields() ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post_ec_project', 'elite_carpentry_save_project_meta' );

/**
 * Block bindings source for project details: renders "Label: value", or nothing when empty.
 */
function elite_carpentry_register_project_binding() {
	register_block_bindings_source( 'elite-carpentry/project', array(
		'label'              => __( 'Project details', 'elite-carpentry-core' ),
		'uses_context'       => array( 'postId' ),
		'get_value_callback' => function ( $args, $block ) {
			$fields = elite_carpentry_project_meta_fields();
			$key    = isset( $args['key'] ) ? 'ec_' . sanitize_key( $args['key'] ) : '';
			if ( ! isset( $fields[ $key ] ) ) {
				return null;
			}
			$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
			$value   = $post_id ? get_post_meta( $post_id, $key, true ) : '';
			if ( '' === $value ) {
				return '';
			}
			return sprintf( '<strong>%s:</strong> %s', esc_html( $fields[ $key ] ), esc_html( $value ) );
		},
	) );
}
add_action( 'init', 'elite_carpentry_register_project_binding' );

/**
 * Drop paragraphs whose binding resolved to nothing, so empty fields leave no gap.
 *
 * @param string $content Rendered block.
 * @param array  $block   Parsed block.
 * @return string
 */
function elite_carpentry_hide_empty_bound_paragraphs( $content, $block ) {
	if ( empty( $block['attrs']['metadata']['bindings'] ) ) {
		return $content;
	}
	if ( '' === trim( wp_strip_all_tags( $content ) ) ) {
		return '';
	}
	return $content;
}
add_filter( 'render_block_core/paragraph', 'elite_carpentry_hide_empty_bound_paragraphs', 10, 2 );

/**
 * Remote featured image fallback.
 *
 * The demo importer stores the original photo URL in `_ec_remote_thumbnail`
 * when it can't copy the photo into the Media Library (e.g. the server blocks
 * outbound requests). These filters let the theme still show that photo.
 */
function elite_carpentry_remote_thumbnail_url( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || get_post_thumbnail_id( $post ) ) {
		return '';
	}
	return (string) get_post_meta( $post->ID, '_ec_remote_thumbnail', true );
}

add_filter( 'has_post_thumbnail', function ( $has, $post ) {
	return $has || '' !== elite_carpentry_remote_thumbnail_url( $post );
}, 10, 2 );

add_filter( 'post_thumbnail_url', function ( $url, $post ) {
	$remote = elite_carpentry_remote_thumbnail_url( $post );
	return $remote ? $remote : $url;
}, 10, 2 );

add_filter( 'post_thumbnail_html', function ( $html, $post_id, $thumbnail_id, $size, $attr ) {
	if ( $html ) {
		return $html;
	}
	$remote = elite_carpentry_remote_thumbnail_url( $post_id );
	if ( ! $remote ) {
		return $html;
	}
	// Mirror wp_get_attachment_image(): keep the classes/styles blocks pass in (e.g. the Cover block's background class).
	$attr = wp_parse_args( is_array( $attr ) ? $attr : array(), array(
		'alt'      => get_the_title( $post_id ),
		'loading'  => 'lazy',
		'decoding' => 'async',
	) );
	$attr['class'] = trim( 'wp-post-image ' . ( isset( $attr['class'] ) ? $attr['class'] : '' ) );
	$html          = '<img src="' . esc_url( $remote ) . '"';
	foreach ( $attr as $name => $value ) {
		if ( is_scalar( $value ) && '' !== (string) $value ) {
			$html .= ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}
	}
	return $html . '>';
}, 10, 5 );

/**
 * [elite_project_filter] – pill links for each Project Type, plus "All".
 * (The core Categories block can't list custom taxonomies before WordPress 6.7.)
 *
 * @return string
 */
function elite_carpentry_project_filter() {
	$terms = get_terms( array( 'taxonomy' => 'ec_project_type', 'hide_empty' => true ) );
	if ( is_wp_error( $terms ) || ! $terms ) {
		return '';
	}
	$current = is_tax( 'ec_project_type' ) ? get_queried_object_id() : 0;
	$links   = array(
		sprintf(
			'<a class="ec-pill%s" href="%s">%s</a>',
			$current ? '' : ' is-active',
			esc_url( get_post_type_archive_link( 'ec_project' ) ),
			esc_html__( 'All', 'elite-carpentry-core' )
		),
	);
	foreach ( $terms as $term ) {
		$links[] = sprintf(
			'<a class="ec-pill%s" href="%s">%s</a>',
			$current === $term->term_id ? ' is-active' : '',
			esc_url( get_term_link( $term ) ),
			esc_html( $term->name )
		);
	}
	return '<nav class="ec-project-filter" aria-label="' . esc_attr__( 'Filter projects', 'elite-carpentry-core' ) . '">' . implode( '', $links ) . '</nav>';
}
add_shortcode( 'elite_project_filter', 'elite_carpentry_project_filter' );
