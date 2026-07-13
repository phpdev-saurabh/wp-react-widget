<?php
namespace Wp\ReactWidget\Rest;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use Wp\ReactWidget\Groups\GroupsRepository;
use Wp\ReactWidget\Support\DependencyChecker;
defined( 'ABSPATH' ) || exit;
final class GroupsController {
	public function index( WP_REST_Request $request ) {
		if ( ! DependencyChecker::is_available() || ! function_exists( 'groups_get_groups' ) ) { return new WP_Error( 'wprw_groups_unavailable', __( 'BuddyBoss groups are unavailable.', 'wp-react-widget' ), array( 'status' => 503 ) ); }
		return new WP_REST_Response( ( new GroupsRepository() )->get_groups( $request['type'], $request['per_page'] ), 200 );
	}
}
