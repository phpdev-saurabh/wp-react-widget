<?php
namespace Wp\ReactWidget;
use Wp\ReactWidget\Support\Activator;
use Wp\ReactWidget\Support\DependencyChecker;
use Wp\ReactWidget\Support\ServiceRegistry;
use Wp\ReactWidget\Widget\WidgetRegistrar;
defined( 'ABSPATH' ) || exit;
final class Plugin {
	private static $instance;
	public static function instance() {
		if ( null === self::$instance ) { self::$instance = new self(); }
		return self::$instance;
	}
	public function register() {
		load_plugin_textdomain( 'wp-react-widget', false, dirname( WPRW_BASENAME ) . '/languages' );
		( new ServiceRegistry( array( new DependencyChecker(), new WidgetRegistrar() ) ) )->register();
	}
	public static function activate() { Activator::activate(); }
	public static function deactivate() { Activator::deactivate(); }
	private function __construct() {}
}
