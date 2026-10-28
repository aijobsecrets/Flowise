<?php
/**
 * Demo photography.
 *
 * Every photo used by the patterns is listed here once, so swapping a picture
 * means editing a single URL. All photos are from Unsplash (free to use under
 * the Unsplash License, https://unsplash.com/license). For production, upload
 * your own project photos to the Media Library and swap them in the editor –
 * the Elite Carpentry Core plugin's setup tool can also copy these into the
 * Media Library for you.
 *
 * @package Elite_Carpentry
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registry of demo images: key => [ Unsplash photo id, alt text ].
 *
 * @return array<string, array{0:string,1:string}>
 */
function elite_carpentry_image_registry() {
	$images = array(
		// Kitchens.
		'kitchen-hero'     => array( '1556909114-f6e7ad7d3136', 'Bright renovated kitchen with white shaker cabinets and a large island' ),
		'kitchen-island'   => array( '1556912173-3bb406ef7e77', 'Custom kitchen island with quartz counter and pendant lighting' ),
		'kitchen-white'    => array( '1484154218962-a197022b5858', 'White kitchen with wood accents and open shelving' ),
		'kitchen-modern'   => array( '1600585154526-990dced4db0d', 'Modern open-concept kitchen with flat-panel cabinetry' ),
		'kitchen-detail'   => array( '1565538810643-b5bdb714032a', 'Kitchen cabinetry and backsplash detail' ),
		'kitchen-open'     => array( '1600489000022-c2086d79f9d4', 'Open kitchen and dining space after renovation' ),
		// Bathrooms.
		'bath-hero'        => array( '1552321554-5fefe8c9ef14', 'Renovated bathroom with freestanding tub and tiled walls' ),
		'bath-vanity'      => array( '1584622650111-993a426fbf0a', 'Custom bathroom vanity with vessel sink' ),
		'bath-modern'      => array( '1620626011761-996317b8d101', 'Modern bathroom with walk-in glass shower' ),
		'bath-tub'         => array( '1507652313519-d4e9174996dd', 'Spa-style ensuite with soaker tub' ),
		'bath-ensuite'     => array( '1600566753086-00f18fb6b3ea', 'Luxury ensuite bathroom with double vanity' ),
		// Carpentry, basements, additions.
		'carpentry-tools'  => array( '1504148455328-c376907d081c', 'Carpentry tools laid out on a timber workbench' ),
		'plans'            => array( '1503387762-592deb58ef4e', 'Renovation plans and drawings on a desk' ),
		'exterior'         => array( '1600585154340-be6161a56a0c', 'Modern home exterior with a new addition' ),
		'living'           => array( '1600607687939-ce8a6c25118c', 'Finished living space with custom built-ins' ),
		'living-2'         => array( '1600210492486-724fe5c67fb0', 'Bright family room after renovation' ),
		'basement'         => array( '1600573472550-8090b5e0745e', 'Finished lower level with warm lighting' ),
	);

	/**
	 * Filter the demo image registry. Return your own URLs to re-skin every pattern at once.
	 *
	 * @param array $images key => [ unsplash id or absolute URL, alt ].
	 */
	return apply_filters( 'elite_carpentry_images', $images );
}

/**
 * URL for a demo image.
 *
 * @param string $key   Image key from the registry.
 * @param int    $width Requested width in px.
 * @return string
 */
function elite_carpentry_img( $key, $width = 1600 ) {
	$images = elite_carpentry_image_registry();
	if ( empty( $images[ $key ] ) ) {
		return '';
	}
	$src = $images[ $key ][0];
	if ( 0 === strpos( $src, 'http' ) ) {
		return esc_url( $src );
	}
	return esc_url( sprintf( 'https://images.unsplash.com/photo-%s?auto=format&fit=crop&w=%d&q=80', $src, (int) $width ) );
}

/**
 * Alt text for a demo image.
 *
 * @param string $key Image key from the registry.
 * @return string
 */
function elite_carpentry_alt( $key ) {
	$images = elite_carpentry_image_registry();
	return isset( $images[ $key ][1] ) ? esc_attr( $images[ $key ][1] ) : '';
}
