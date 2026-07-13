<?php
namespace Wp\ReactWidget\Widget;
use Wp\ReactWidget\Support\Contracts\Registerable;
use Wp\ReactWidget\Support\DependencyChecker;
defined( 'ABSPATH' ) || exit;
final class WidgetRegistrar implements Registerable {
	public function register() { add_action( 'widgets_init', array( $this, 'register_widget' ) ); }
	public function register_widget() { if ( DependencyChecker::is_available() ) { register_widget( ReactBbGroupsWidget::class ); } }
}
