<?php
namespace Wp\ReactWidget\Support;

use Wp\ReactWidget\Support\Contracts\Registerable;

defined( 'ABSPATH' ) || exit;

final class ServiceRegistry {
	/** @var Registerable[] */
	private $services;

	public function __construct( array $services ) {
		$this->services = $services;
	}

	public function register() {
		foreach ( $this->services as $service ) {
			$service->register();
		}
	}
}
