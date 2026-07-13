<?php
namespace Wp\ReactWidget\Rest;
use Wp\ReactWidget\Support\Contracts\Registerable;
defined( 'ABSPATH' ) || exit;
final class RestRegistrar implements Registerable {
	public function register() { add_action( 'rest_api_init', array( $this, 'register_routes' ) ); }
	public function register_routes() {
		$controller = new GroupsController();
		register_rest_route( 'wp-react-widget/v1', '/groups', array( 'methods' => 'GET', 'callback' => array( $controller, 'index' ), 'permission_callback' => '__return_true', 'args' => array(
			'type' => array( 'default' => 'active', 'sanitize_callback' => 'sanitize_key', 'validate_callback' => static function ( $value ) { return in_array( $value, array( 'newest', 'active', 'popular' ), true ); } ),
			'per_page' => array( 'default' => 5, 'sanitize_callback' => 'absint', 'validate_callback' => static function ( $value ) { return $value >= 1 && $value <= 50; } ),
		) ) );
	}
}
