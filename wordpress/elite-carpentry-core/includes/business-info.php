<?php
/**
 * Business details: one settings screen feeds the header, footer, contact page
 * and CTAs through the Block Bindings API (and a shortcode for classic content).
 *
 * @package Elite_Carpentry_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Field definitions: key => [ label, type, placeholder ].
 *
 * @return array<string, array{0:string,1:string,2:string}>
 */
function elite_carpentry_business_fields() {
	return array(
		'phone'        => array( __( 'Phone', 'elite-carpentry-core' ), 'tel', '(519) 555-0100' ),
		'email'        => array( __( 'Email', 'elite-carpentry-core' ), 'email', 'info@yourdomain.ca' ),
		'address'      => array( __( 'Address / city', 'elite-carpentry-core' ), 'text', 'Kitchener, ON' ),
		'hours'        => array( __( 'Hours', 'elite-carpentry-core' ), 'text', 'Mon–Fri 7:30am–5:00pm' ),
		'service_area' => array( __( 'Service area line', 'elite-carpentry-core' ), 'text', 'Serving Kitchener, Waterloo, Cambridge & Guelph' ),
		'notify_email' => array( __( 'Send quote requests to', 'elite-carpentry-core' ), 'email', get_option( 'admin_email' ) ),
	);
}

/**
 * Get one business detail (raw, unescaped). Empty string when unset.
 *
 * @param string $key Field key.
 * @return string
 */
function elite_carpentry_business( $key ) {
	$options = get_option( 'elite_carpentry_business', array() );
	return isset( $options[ $key ] ) ? trim( (string) $options[ $key ] ) : '';
}

/**
 * Formatted values used by the bindings source and shortcode.
 * Returns null when the underlying field is empty so the block keeps its own text.
 *
 * @param string $key Value key.
 * @return string|null
 */
function elite_carpentry_business_value( $key ) {
	$phone = elite_carpentry_business( 'phone' );
	$email = elite_carpentry_business( 'email' );
	$tel   = 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );

	switch ( $key ) {
		case 'phone':
			return $phone ? esc_html( $phone ) : null;
		case 'phone_url':
			return $phone ? esc_url( $tel, array( 'tel' ) ) : null;
		case 'phone_link':
			return $phone ? sprintf( '📞 <a href="%s">%s</a>', esc_url( $tel, array( 'tel' ) ), esc_html( $phone ) ) : null;
		case 'phone_cta':
			/* translators: %s: phone link */
			return $phone ? sprintf( __( 'Prefer to talk? Call %s', 'elite-carpentry-core' ), sprintf( '<a href="%s">%s</a>', esc_url( $tel, array( 'tel' ) ), esc_html( $phone ) ) ) : null;
		case 'email':
			return $email ? esc_html( $email ) : null;
		case 'email_link':
			return $email ? sprintf( '✉ <a href="mailto:%1$s">%1$s</a>', esc_attr( antispambot( $email ) ) ) : null;
		case 'address':
			$address = elite_carpentry_business( 'address' );
			return $address ? '📍 ' . esc_html( $address ) : null;
		case 'hours':
		case 'service_area':
			$value = elite_carpentry_business( $key );
			return $value ? esc_html( $value ) : null;
		case 'copyright':
			/* translators: 1: year, 2: site name */
			return sprintf( esc_html__( '© %1$s %2$s. All rights reserved.', 'elite-carpentry-core' ), esc_html( wp_date( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) );
		case 'year':
			return esc_html( wp_date( 'Y' ) );
	}
	return null;
}

/**
 * Register the "elite-carpentry/business" block bindings source.
 *
 * Usage in block markup:
 * <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"elite-carpentry/business","args":{"key":"phone_link"}}}}} -->
 */
function elite_carpentry_register_business_binding() {
	register_block_bindings_source( 'elite-carpentry/business', array(
		'label'              => __( 'Business details', 'elite-carpentry-core' ),
		'get_value_callback' => function ( $args, $block, $attribute ) {
			$key = isset( $args['key'] ) ? sanitize_key( $args['key'] ) : '';
			// A button's URL binding gets the bare URL version of the key.
			if ( 'url' === $attribute && 'phone' === $key ) {
				$key = 'phone_url';
			}
			return elite_carpentry_business_value( $key );
		},
	) );
}
add_action( 'init', 'elite_carpentry_register_business_binding' );

/**
 * [elite_info key="phone_link"] for classic content, widgets and page builders.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function elite_carpentry_info_shortcode( $atts ) {
	$atts  = shortcode_atts( array( 'key' => 'phone' ), $atts, 'elite_info' );
	$value = elite_carpentry_business_value( sanitize_key( $atts['key'] ) );
	return null === $value ? '' : $value;
}
add_shortcode( 'elite_info', 'elite_carpentry_info_shortcode' );

/**
 * Settings → Business Details.
 */
function elite_carpentry_business_settings() {
	register_setting( 'elite_carpentry_business', 'elite_carpentry_business', array(
		'type'              => 'array',
		'sanitize_callback' => function ( $input ) {
			$clean = array();
			foreach ( elite_carpentry_business_fields() as $key => $field ) {
				$value         = isset( $input[ $key ] ) ? wp_unslash( $input[ $key ] ) : '';
				$clean[ $key ] = 'email' === $field[1] ? sanitize_email( $value ) : sanitize_text_field( $value );
			}
			return $clean;
		},
		'default'           => array(),
	) );
}
add_action( 'admin_init', 'elite_carpentry_business_settings' );

add_action( 'admin_menu', function () {
	add_options_page(
		__( 'Business Details', 'elite-carpentry-core' ),
		__( 'Business Details', 'elite-carpentry-core' ),
		'manage_options',
		'elite-carpentry-business',
		'elite_carpentry_render_business_settings'
	);
} );

/**
 * Render the settings screen.
 */
function elite_carpentry_render_business_settings() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Business Details', 'elite-carpentry-core' ); ?></h1>
		<p><?php esc_html_e( 'These details appear in the header top bar, footer, contact page and call-to-action sections. Leave a field empty to keep the text written in the block itself.', 'elite-carpentry-core' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'elite_carpentry_business' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( elite_carpentry_business_fields() as $key => $field ) : ?>
					<tr>
						<th scope="row"><label for="ec-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field[0] ); ?></label></th>
						<td>
							<input class="regular-text" type="<?php echo esc_attr( $field[1] ); ?>" id="ec-<?php echo esc_attr( $key ); ?>"
								name="elite_carpentry_business[<?php echo esc_attr( $key ); ?>]"
								value="<?php echo esc_attr( elite_carpentry_business( $key ) ); ?>"
								placeholder="<?php echo esc_attr( $field[2] ); ?>">
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<p class="description">
				<?php
				printf(
					/* translators: %s: shortcode example */
					esc_html__( 'Need these somewhere else? Use the shortcode %s (keys: phone, phone_link, email, email_link, address, hours, service_area, copyright).', 'elite-carpentry-core' ),
					'<code>[elite_info key="phone_link"]</code>'
				);
				?>
			</p>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * LocalBusiness structured data (schema.org) in the <head> for local SEO.
 */
function elite_carpentry_local_business_schema() {
	if ( ! is_front_page() ) {
		return;
	}
	$data = array(
		'@context' => 'https://schema.org',
		'@type'    => 'HomeAndConstructionBusiness',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
	);
	if ( elite_carpentry_business( 'phone' ) ) {
		$data['telephone'] = elite_carpentry_business( 'phone' );
	}
	if ( elite_carpentry_business( 'email' ) ) {
		$data['email'] = elite_carpentry_business( 'email' );
	}
	if ( elite_carpentry_business( 'address' ) ) {
		$data['address'] = elite_carpentry_business( 'address' );
	}
	if ( has_custom_logo() ) {
		$data['logo'] = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
	}
	printf( "<script type=\"application/ld+json\">%s</script>\n", wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
}
add_action( 'wp_head', 'elite_carpentry_local_business_schema' );
