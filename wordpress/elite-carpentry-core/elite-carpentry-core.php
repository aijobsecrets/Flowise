<?php
/**
 * Plugin Name:       Elite Carpentry Core
 * Description:       Projects portfolio, quote request form block, editable business details (phone, email, hours) and one-click demo setup for the Elite Carpentry theme. Works with any block theme.
 * Version:           1.0.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            Elite Carpentry
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       elite-carpentry-core
 *
 * @package Elite_Carpentry_Core
 */

defined( 'ABSPATH' ) || exit;

define( 'ELITE_CARPENTRY_CORE_VERSION', '1.0.0' );
define( 'ELITE_CARPENTRY_CORE_FILE', __FILE__ );
define( 'ELITE_CARPENTRY_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'ELITE_CARPENTRY_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once ELITE_CARPENTRY_CORE_DIR . 'includes/post-types.php';
require_once ELITE_CARPENTRY_CORE_DIR . 'includes/business-info.php';
require_once ELITE_CARPENTRY_CORE_DIR . 'includes/quote-form.php';
require_once ELITE_CARPENTRY_CORE_DIR . 'includes/setup.php';

/**
 * Register post types and flush rewrites so /projects/ works straight away.
 */
function elite_carpentry_core_activate() {
	elite_carpentry_register_post_types();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'elite_carpentry_core_activate' );

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
