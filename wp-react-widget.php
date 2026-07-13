<?php
/**
 * Plugin Name: WP React Widget
 * Description: Adds a React-powered BuddyBoss groups widget with native WordPress widget settings.
 * Version: 1.0.0
 * Author: WP
 * Text Domain: wp-react-widget
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package Wp\ReactWidget
 */

defined( 'ABSPATH' ) || exit;

define( 'WPRW_VERSION', '1.0.0' );
define( 'WPRW_FILE', __FILE__ );
define( 'WPRW_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPRW_URL', plugin_dir_url( __FILE__ ) );
define( 'WPRW_BASENAME', plugin_basename( __FILE__ ) );

$wprw_autoload = WPRW_PATH . 'vendor/autoload.php';

if ( file_exists( $wprw_autoload ) ) {
	require_once $wprw_autoload;
}

register_activation_hook( __FILE__, array( \Wp\ReactWidget\Plugin::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( \Wp\ReactWidget\Plugin::class, 'deactivate' ) );

add_action( 'plugins_loaded', 'wprw_bootstrap' );

/**
 * Start the plugin after all dependencies have loaded.
 *
 * @return void
 */
function wprw_bootstrap() {
	if ( class_exists( \Wp\ReactWidget\Plugin::class ) ) {
		\Wp\ReactWidget\Plugin::instance()->register();
	}
}
