<?php
/**
 * Quote request form: block, shortcode, submission handler and admin screens.
 *
 * Submissions are stored as private "ec_lead" posts (so nothing is lost if
 * email delivery fails) and emailed to the address in Settings → Business Details.
 * Tip: install an SMTP plugin (e.g. WP Mail SMTP) so those emails reliably arrive.
 *
 * @package Elite_Carpentry_Core
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
	register_block_type( ELITE_CARPENTRY_CORE_DIR . 'blocks/quote-form' );
} );

/**
 * [elite_quote_form compact="0" button="Request my free estimate"]
 */
add_shortcode( 'elite_quote_form', function ( $atts ) {
	$atts = shortcode_atts( array( 'compact' => '0', 'button' => '' ), $atts, 'elite_quote_form' );
	wp_enqueue_style( 'elite-carpentry-quote-form-style' ); // Handle WordPress generates from block.json "style".
	$attributes = array( 'compact' => (bool) $atts['compact'] );
	if ( $atts['button'] ) {
		$attributes['buttonText'] = $atts['button'];
	}
	return elite_carpentry_quote_form_html( $attributes, 'class="ec-quote-form"' );
} );


/**
 * URL of the page being rendered, used to send visitors back after submitting.
 *
 * @return string
 */
function elite_carpentry_current_url() {
	if ( wp_is_serving_rest_request() || empty( $_SERVER['HTTP_HOST'] ) || empty( $_SERVER['REQUEST_URI'] ) ) {
		return home_url( '/' );
	}
	$url = set_url_scheme( 'http://' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
	return remove_query_arg( 'ec_quote', $url );
}

/**
 * Select options for the full form.
 *
 * @return array<string, array<string,string>>
 */
function elite_carpentry_quote_options() {
	return array(
		'project'  => array(
			''          => __( 'Choose one…', 'elite-carpentry-core' ),
			'kitchen'   => __( 'Kitchen renovation', 'elite-carpentry-core' ),
			'bathroom'  => __( 'Bathroom renovation', 'elite-carpentry-core' ),
			'basement'  => __( 'Basement finishing', 'elite-carpentry-core' ),
			'addition'  => __( 'Addition or deck', 'elite-carpentry-core' ),
			'carpentry' => __( 'Custom carpentry / trim', 'elite-carpentry-core' ),
			'other'     => __( 'Something else', 'elite-carpentry-core' ),
		),
		'budget'   => array(
			''        => __( 'Not sure yet', 'elite-carpentry-core' ),
			'u25'     => __( 'Under $25,000', 'elite-carpentry-core' ),
			'25-50'   => __( '$25,000 – $50,000', 'elite-carpentry-core' ),
			'50-100'  => __( '$50,000 – $100,000', 'elite-carpentry-core' ),
			'100plus' => __( '$100,000+', 'elite-carpentry-core' ),
		),
		'timeline' => array(
			''         => __( 'Flexible', 'elite-carpentry-core' ),
			'asap'     => __( 'As soon as possible', 'elite-carpentry-core' ),
			'3months'  => __( 'Within 3 months', 'elite-carpentry-core' ),
			'6months'  => __( '3–6 months', 'elite-carpentry-core' ),
			'planning' => __( 'Just planning / budgeting', 'elite-carpentry-core' ),
		),
	);
}

/**
 * Build the form markup.
 *
 * @param array  $attributes         Block attributes.
 * @param string $wrapper_attributes Pre-escaped wrapper attributes string.
 * @return string
 */
function elite_carpentry_quote_form_html( $attributes, $wrapper_attributes ) {
	static $instance = 0;
	++$instance;

	$attributes = wp_parse_args( $attributes, array(
		'compact'        => false,
		'buttonText'     => __( 'Request my free estimate', 'elite-carpentry-core' ),
		'successMessage' => __( "Thanks! Your request is in. We'll be in touch within one business day.", 'elite-carpentry-core' ),
	) );

	$id      = 'ec-qf-' . $instance;
	$status  = isset( $_GET['ec_quote'] ) ? sanitize_key( $_GET['ec_quote'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$options = elite_carpentry_quote_options();
	$time    = time();

	$field = function ( $name, $label, $type = 'text', $required = false, $full = false, $extra = '' ) use ( $id ) {
		return sprintf(
			'<p class="ec-field%6$s"><label for="%1$s-%2$s">%3$s%4$s</label><input type="%5$s" id="%1$s-%2$s" name="ec_%2$s"%7$s%8$s></p>',
			esc_attr( $id ),
			esc_attr( $name ),
			esc_html( $label ),
			$required ? ' <span class="ec-req" aria-hidden="true">*</span>' : '',
			esc_attr( $type ),
			$full ? ' ec-field--full' : '',
			$required ? ' required' : '',
			$extra
		);
	};
	$select = function ( $name, $label ) use ( $id, $options ) {
		$html = '';
		foreach ( $options[ $name ] as $value => $text ) {
			$html .= sprintf( '<option value="%s">%s</option>', esc_attr( $value ), esc_html( $text ) );
		}
		return sprintf(
			'<p class="ec-field"><label for="%1$s-%2$s">%3$s</label><select id="%1$s-%2$s" name="ec_%2$s">%4$s</select></p>',
			esc_attr( $id ),
			esc_attr( $name ),
			esc_html( $label ),
			$html
		);
	};

	ob_start();
	?>
	<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
		<?php if ( 'sent' === $status ) : ?>
			<p class="ec-notice ec-notice--success" role="status"><?php echo esc_html( $attributes['successMessage'] ); ?></p>
		<?php elseif ( 'error' === $status ) : ?>
			<p class="ec-notice ec-notice--error" role="alert"><?php esc_html_e( 'Sorry, something went wrong sending your request. Please check the required fields and try again, or give us a call.', 'elite-carpentry-core' ); ?></p>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="elite_quote">
			<input type="hidden" name="ec_return" value="<?php echo esc_url( elite_carpentry_current_url() ); ?>">
			<input type="hidden" name="ec_ts" value="<?php echo esc_attr( $time . '.' . wp_hash( 'ec_quote_' . $time ) ); ?>">
			<p class="ec-hp" aria-hidden="true"><label for="<?php echo esc_attr( $id ); ?>-website">Website</label><input type="text" id="<?php echo esc_attr( $id ); ?>-website" name="ec_website" tabindex="-1" autocomplete="off"></p>
			<?php
			// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- closures escape.
			echo $field( 'name', __( 'Your name', 'elite-carpentry-core' ), 'text', true, false, ' autocomplete="name"' );
			echo $field( 'email', __( 'Email', 'elite-carpentry-core' ), 'email', true, false, ' autocomplete="email"' );
			echo $field( 'phone', __( 'Phone', 'elite-carpentry-core' ), 'tel', false, false, ' autocomplete="tel"' );
			if ( $attributes['compact'] ) {
				echo $select( 'project', __( 'Project type', 'elite-carpentry-core' ) );
			} else {
				echo $field( 'city', __( 'City / neighbourhood', 'elite-carpentry-core' ), 'text', false, false, ' autocomplete="address-level2"' );
				echo $select( 'project', __( 'Project type', 'elite-carpentry-core' ) );
				echo $select( 'budget', __( 'Approximate budget', 'elite-carpentry-core' ) );
				echo $select( 'timeline', __( 'Ideal start', 'elite-carpentry-core' ) );
			}
			// phpcs:enable
			?>
			<p class="ec-field ec-field--full">
				<label for="<?php echo esc_attr( $id ); ?>-message"><?php esc_html_e( 'Tell us about your project', 'elite-carpentry-core' ); ?> <span class="ec-req" aria-hidden="true">*</span></label>
				<textarea id="<?php echo esc_attr( $id ); ?>-message" name="ec_message" rows="<?php echo $attributes['compact'] ? 3 : 5; ?>" required></textarea>
			</p>
			<div class="ec-submit wp-block-button">
				<button type="submit" class="wp-block-button__link wp-element-button"><?php echo esc_html( $attributes['buttonText'] ); ?></button>
				<p class="ec-privacy"><?php esc_html_e( 'We only use your details to reply to this request.', 'elite-carpentry-core' ); ?></p>
			</div>
		</form>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Handle a submission (logged-in and logged-out visitors).
 */
function elite_carpentry_handle_quote() {
	// phpcs:disable WordPress.Security.NonceVerification.Missing -- public form; protected by honeypot, signed timestamp and rate limit so it keeps working behind page caches.
	$return = isset( $_POST['ec_return'] ) ? esc_url_raw( wp_unslash( $_POST['ec_return'] ) ) : '';
	$return = remove_query_arg( 'ec_quote', wp_validate_redirect( $return, home_url( '/' ) ) );
	$fail   = function () use ( $return ) {
		wp_safe_redirect( add_query_arg( 'ec_quote', 'error', $return ) . '#quote' );
		exit;
	};
	$done   = function () use ( $return ) {
		wp_safe_redirect( add_query_arg( 'ec_quote', 'sent', $return ) . '#quote' );
		exit;
	};

	// Honeypot: bots fill it, people never see it. Pretend success.
	if ( ! empty( $_POST['ec_website'] ) ) {
		$done();
	}

	// Signed render timestamp; real people take more than 3 seconds.
	$ts    = isset( $_POST['ec_ts'] ) ? sanitize_text_field( wp_unslash( $_POST['ec_ts'] ) ) : '';
	$parts = explode( '.', $ts, 2 );
	if ( 2 !== count( $parts ) || ! hash_equals( wp_hash( 'ec_quote_' . $parts[0] ), $parts[1] ) || time() - (int) $parts[0] < 3 ) {
		$fail();
	}

	// Rate limit: 5 submissions per IP per hour.
	$ip_key = 'ec_quote_' . md5( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '' );
	$count  = (int) get_transient( $ip_key );
	if ( $count >= 5 ) {
		$fail();
	}
	set_transient( $ip_key, $count + 1, HOUR_IN_SECONDS );

	$options = elite_carpentry_quote_options();
	$get     = function ( $key, $type = 'text' ) {
		$value = isset( $_POST[ 'ec_' . $key ] ) ? wp_unslash( $_POST[ 'ec_' . $key ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized below.
		if ( 'email' === $type ) {
			return sanitize_email( $value );
		}
		return 'textarea' === $type ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );
	};
	$lead = array(
		'name'     => $get( 'name' ),
		'email'    => $get( 'email', 'email' ),
		'phone'    => $get( 'phone' ),
		'city'     => $get( 'city' ),
		'project'  => $get( 'project' ),
		'budget'   => $get( 'budget' ),
		'timeline' => $get( 'timeline' ),
		'message'  => $get( 'message', 'textarea' ),
	);
	// phpcs:enable

	if ( '' === $lead['name'] || ! is_email( $lead['email'] ) || '' === $lead['message'] ) {
		$fail();
	}
	foreach ( array( 'project', 'budget', 'timeline' ) as $key ) {
		$lead[ $key ] = isset( $options[ $key ][ $lead[ $key ] ] ) && '' !== $lead[ $key ] ? $options[ $key ][ $lead[ $key ] ] : '';
	}

	$title   = $lead['name'] . ( $lead['project'] ? ' – ' . $lead['project'] : '' );
	$post_id = wp_insert_post( array(
		'post_type'   => 'ec_lead',
		'post_status' => 'private',
		'post_title'  => $title,
	), true );
	if ( is_wp_error( $post_id ) ) {
		$fail();
	}
	foreach ( $lead as $key => $value ) {
		update_post_meta( $post_id, '_ec_' . $key, $value );
	}
	update_post_meta( $post_id, '_ec_source', $return );

	$to = elite_carpentry_business( 'notify_email' );
	$to = is_email( $to ) ? $to : get_option( 'admin_email' );

	$lines = array();
	foreach ( elite_carpentry_lead_labels() as $key => $label ) {
		if ( '' !== $lead[ $key ] ) {
			$lines[] = $label . ': ' . $lead[ $key ];
		}
	}
	$lines[] = '';
	$lines[] = __( 'View in dashboard:', 'elite-carpentry-core' ) . ' ' . admin_url( 'post.php?post=' . $post_id . '&action=edit' );

	wp_mail(
		$to,
		/* translators: %s: lead title */
		sprintf( __( 'New quote request: %s', 'elite-carpentry-core' ), $title ),
		implode( "\n", $lines ),
		array( 'Reply-To: ' . $lead['name'] . ' <' . $lead['email'] . '>' )
	);

	/**
	 * Fires after a quote request is stored. Hook in to push leads to a CRM.
	 *
	 * @param int   $post_id Lead post ID.
	 * @param array $lead    Sanitized lead fields.
	 */
	do_action( 'elite_carpentry_quote_received', $post_id, $lead );

	$done();
}
add_action( 'admin_post_nopriv_elite_quote', 'elite_carpentry_handle_quote' );
add_action( 'admin_post_elite_quote', 'elite_carpentry_handle_quote' );

/**
 * Lead field labels.
 *
 * @return array<string,string>
 */
function elite_carpentry_lead_labels() {
	return array(
		'name'     => __( 'Name', 'elite-carpentry-core' ),
		'email'    => __( 'Email', 'elite-carpentry-core' ),
		'phone'    => __( 'Phone', 'elite-carpentry-core' ),
		'city'     => __( 'City', 'elite-carpentry-core' ),
		'project'  => __( 'Project', 'elite-carpentry-core' ),
		'budget'   => __( 'Budget', 'elite-carpentry-core' ),
		'timeline' => __( 'Timeline', 'elite-carpentry-core' ),
		'message'  => __( 'Message', 'elite-carpentry-core' ),
	);
}

// Admin list columns.
add_filter( 'manage_ec_lead_posts_columns', function ( $columns ) {
	return array(
		'cb'         => $columns['cb'],
		'title'      => __( 'Request', 'elite-carpentry-core' ),
		'ec_contact' => __( 'Contact', 'elite-carpentry-core' ),
		'ec_budget'  => __( 'Budget / timeline', 'elite-carpentry-core' ),
		'date'       => $columns['date'],
	);
} );
add_action( 'manage_ec_lead_posts_custom_column', function ( $column, $post_id ) {
	if ( 'ec_contact' === $column ) {
		$email = get_post_meta( $post_id, '_ec_email', true );
		printf(
			'<a href="mailto:%1$s">%1$s</a><br>%2$s',
			esc_attr( $email ),
			esc_html( get_post_meta( $post_id, '_ec_phone', true ) )
		);
	} elseif ( 'ec_budget' === $column ) {
		echo esc_html( trim( get_post_meta( $post_id, '_ec_budget', true ) . ' · ' . get_post_meta( $post_id, '_ec_timeline', true ), ' ·' ) );
	}
}, 10, 2 );

// Read-only detail view on the lead edit screen.
add_action( 'add_meta_boxes_ec_lead', function () {
	add_meta_box( 'ec-lead-details', __( 'Request details', 'elite-carpentry-core' ), function ( $post ) {
		echo '<table class="widefat striped"><tbody>';
		foreach ( elite_carpentry_lead_labels() as $key => $label ) {
			$value = get_post_meta( $post->ID, '_ec_' . $key, true );
			if ( '' === $value ) {
				continue;
			}
			printf( '<tr><th style="width:140px">%s</th><td>%s</td></tr>', esc_html( $label ), nl2br( esc_html( $value ) ) );
		}
		echo '</tbody></table>';
	}, 'ec_lead', 'normal', 'high' );
} );
