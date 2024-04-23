<?php
/**
 * Container class to implement symfony/dependency-injection.
 *
 * @package WpDev\Core
 */

declare(strict_types=1);

namespace WpDev\Core;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Container class
 *
 * @since 1.0.0
 */
class Container {
	/**
	 * Container instance.
	 *
	 * @since 1.0.0
	 *
	 * @var Container
	 */
	private static $instance;

	/**
	 * Get the container instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Container
	 */
	public static function instance(): Container {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Container builder instance.
	 *
	 * @since 1.0.0
	 *
	 * @var ContainerBuilder
	 */
	private static $builder;

	/**
	 * Register a given service in the container.
	 *
	 * @since 1.0.0
	 *
	 * @param string $service_alias The service alias to register.
	 * @param string $service The service to register.
	 *
	 * @return Definition
	 */
	public function register( string $service_alias, string $service ): Definition {
		return self::builder()->register( $service_alias, $service );
	}

	/**
	 * Get a service from the container.
	 *
	 * @since 1.0.0
	 *
	 * @param string $service The service to get.
	 *
	 * @return object
	 */
	public function get( string $service ): object {
		return self::builder()->get( $service );
	}

	/**
	 * Get ContainerBuilder instance
	 *
	 * @since 1.0.0
	 *
	 * @return ContainerBuilder
	 */
	public function get_container_builder(): ContainerBuilder {
		return self::builder();
	}

	/**
	 * Get the container builder instance.
	 *
	 * @since 1.0.0
	 *
	 * @return ContainerBuilder
	 */
	private static function builder(): ContainerBuilder {
		if ( null === self::$builder ) {
			self::$builder = new ContainerBuilder();
		}

		return self::$builder;
	}
}
