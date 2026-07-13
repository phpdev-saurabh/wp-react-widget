<?php
namespace Wp\ReactWidget\Assets;
defined( 'ABSPATH' ) || exit;
final class FrontendAssets {
	private const HANDLE = 'wprw-react-bb-groups';
	public static function enqueue() {
		$file = WPRW_PATH . 'build/index.asset.php';
		$asset = file_exists( $file ) ? require $file : array( 'dependencies' => array( 'wp-api-fetch', 'wp-element', 'wp-i18n' ), 'version' => WPRW_VERSION );
		wp_enqueue_script( self::HANDLE, WPRW_URL . 'build/index.js', $asset['dependencies'], $asset['version'], true );
		if ( file_exists( WPRW_PATH . 'build/index.css' ) ) { wp_enqueue_style( self::HANDLE, WPRW_URL . 'build/index.css', array(), $asset['version'] ); }
	}
}
