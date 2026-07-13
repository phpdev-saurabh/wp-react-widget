<?php
namespace Wp\ReactWidget\Support;
use Wp\ReactWidget\Support\Contracts\Registerable;
defined( 'ABSPATH' ) || exit;
final class DependencyChecker implements Registerable {
	public function register() { add_action( 'admin_notices', array( $this, 'render_notice' ) ); }
	public static function is_available() { return function_exists( 'bp_is_active' ) && bp_is_active( 'groups' ); }
	public function render_notice() {
		if ( self::is_available() || ! current_user_can( 'activate_plugins' ) ) { return; }
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'WP React Widget requires BuddyBoss Platform with the Social Groups component enabled.', 'wp-react-widget' ) . '</p></div>';
	}
}
