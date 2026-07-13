<?php
namespace Wp\ReactWidget\Support;
defined( 'ABSPATH' ) || exit;
final class Activator {
	public static function activate() { flush_rewrite_rules(); }
	public static function deactivate() { flush_rewrite_rules(); }
}
