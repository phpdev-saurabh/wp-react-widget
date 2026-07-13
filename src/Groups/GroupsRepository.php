<?php
namespace Wp\ReactWidget\Groups;
defined( 'ABSPATH' ) || exit;
final class GroupsRepository {
	public function get_groups( $type, $per_page ) {
		$user_id = get_current_user_id();
		if ( $user_id && 0 === (int) bp_get_total_group_count_for_user( $user_id ) ) { $user_id = 0; }
		$result = groups_get_groups( array( 'type' => $type, 'per_page' => $per_page, 'page' => 1, 'user_id' => $user_id, 'show_hidden' => false ) );
		return array( 'groups' => array_map( array( $this, 'format_group' ), $result['groups'] ), 'total' => (int) $result['total'] );
	}
	private function format_group( $group ) {
		return array( 'id' => (int) $group->id, 'name' => $group->name, 'permalink' => bp_get_group_permalink( $group ), 'avatarUrl' => bp_get_group_avatar_url( $group, 'thumb' ), 'lastActive' => bp_get_group_last_active( $group ), 'memberCount' => (int) ( $group->total_member_count ?? 0 ), 'dateCreated' => $group->date_created ?? '' );
	}
}
