<?php
namespace Wp\ReactWidget\Widget;
use Wp\ReactWidget\Assets\FrontendAssets;
use Wp\ReactWidget\Groups\GroupsRepository;
defined( 'ABSPATH' ) || exit;
final class ReactBbGroupsWidget extends \WP_Widget {
	public function __construct() {
		parent::__construct( 'wprw_react_bb_groups', __( 'React BB Groups Widget', 'wp-react-widget' ), array( 'classname' => 'widget_wprw_react_bb_groups buddypress widget', 'description' => __( 'A React-powered list of BuddyBoss groups.', 'wp-react-widget' ), 'customize_selective_refresh' => true ) );
	}
	public function widget( $args, $instance ) {
		$settings = $this->normalize( $instance );
		$initial_data = ( new GroupsRepository() )->get_groups( $settings['group_default'], $settings['max_groups'] );
		FrontendAssets::enqueue();
		$config = array(
			'title' => apply_filters( 'widget_title', $settings['title'], $instance, $this->id_base ),
			'linkTitle' => $settings['link_title'], 'maxGroups' => $settings['max_groups'], 'defaultGroup' => $settings['group_default'],
			'initialData' => $initial_data,
			'restUrl' => rest_url( 'wp-react-widget/v1/groups' ), 'restNonce' => wp_create_nonce( 'wp_rest' ),
			'groupsDirectoryUrl' => bp_get_groups_directory_permalink(),
		);
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		printf( '<div class="wprw-react-bb-groups" data-wprw-config="%s"></div>', esc_attr( wp_json_encode( $config ) ) );
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	public function update( $new, $old ) {
		$type = isset( $new['group_default'] ) ? sanitize_key( $new['group_default'] ) : 'active';
		return array( 'title' => sanitize_text_field( $new['title'] ?? '' ), 'link_title' => ! empty( $new['link_title'] ), 'max_groups' => min( 50, max( 1, absint( $new['max_groups'] ?? 5 ) ) ), 'group_default' => in_array( $type, array( 'newest', 'active', 'popular' ), true ) ? $type : 'active' );
	}
	public function form( $instance ) {
		$i = $this->normalize( $instance ); ?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wp-react-widget' ); ?></label><input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $i['title'] ); ?>"></p>
		<p><label><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'link_title' ) ); ?>" value="1" <?php checked( $i['link_title'] ); ?>> <?php esc_html_e( 'Link widget title to Groups directory', 'wp-react-widget' ); ?></label></p>
		<p><label><?php esc_html_e( 'Max groups to show:', 'wp-react-widget' ); ?> <input type="number" min="1" max="50" name="<?php echo esc_attr( $this->get_field_name( 'max_groups' ) ); ?>" value="<?php echo esc_attr( $i['max_groups'] ); ?>"></label></p>
		<p><label><?php esc_html_e( 'Default groups to show:', 'wp-react-widget' ); ?> <select name="<?php echo esc_attr( $this->get_field_name( 'group_default' ) ); ?>"><option value="newest" <?php selected( $i['group_default'], 'newest' ); ?>><?php esc_html_e( 'Newest', 'wp-react-widget' ); ?></option><option value="active" <?php selected( $i['group_default'], 'active' ); ?>><?php esc_html_e( 'Active', 'wp-react-widget' ); ?></option><option value="popular" <?php selected( $i['group_default'], 'popular' ); ?>><?php esc_html_e( 'Popular', 'wp-react-widget' ); ?></option></select></label></p><?php
	}
	private function normalize( $instance ) {
		$i = wp_parse_args( (array) $instance, array( 'title' => __( 'Groups', 'wp-react-widget' ), 'link_title' => false, 'max_groups' => 5, 'group_default' => 'active' ) );
		$i['link_title'] = (bool) $i['link_title']; $i['max_groups'] = min( 50, max( 1, absint( $i['max_groups'] ) ) ); return $i;
	}
}
