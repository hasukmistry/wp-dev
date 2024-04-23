<?php
/**
 * Service class to register services.
 *
 * @package WpDev\Core
 */

declare(strict_types=1);

namespace WpDev\Core;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use WpDev\Core\Config;
use WpDev\Core\Container;
use WpDev\Core\Contracts\ConfigInterface;

/**
 * Service class
 *
 * @since 1.0.0
 */
class Service {
	/**
	 * Service instance.
	 *
	 * @since 1.0.0
	 *
	 * @var Service
	 */
	private static $instance;

	/**
	 * Get the service instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Service
	 */
	public static function instance(): Service {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register and Load a config file.
	 *
	 * @since 1.0.0
	 *
	 * @param string $path The plugin path.
	 * @param string $file The config file to load.
	 *
	 * @return Service
	 *
	 * @throws InvalidArgumentException If the file is not found.
	 */
	public function set_config( string $path, string $file ): Service {
		self::instance()
			->register_config( $path )
			->load( $file );

		return $this;
	}

	/**
	 * Register WordPress classes
	 *
	 * @since 1.0.0
	 *
	 * @return Service
	 */
	public function set_services(): Service {
		$container = Container::instance();

		$services = apply_filters(
			'wp_dev_service_aliases',
			array()
		);

		foreach ( $services as $service ) {
			// Call the __invoke() method of the class.
			$container->get( $service )();
		}

		return $this;
	}

	/**
	 * Register default config service.
	 *
	 * Keep in mind that,
	 * ContainerBuilder is available without loaded config file.
	 *
	 * @since 1.0.0
	 *
	 * @param string $path The plugin path.
	 *
	 * @return ConfigInterface
	 */
	private function register_config( string $path ): ConfigInterface {
		$container = Container::instance();

		$container
			->register( 'fileLocator', FileLocator::class )
			->addArgument( $path );

		$container
			->register( 'yamlFileLoader', YamlFileLoader::class )
			->addArgument( $container->get_container_builder() )
			->addArgument( new Reference( 'fileLocator' ) );

		$container
			->register( 'config', Config::class )
			->addArgument( new Reference( 'yamlFileLoader' ) );

		return $container->get( 'config' );
	}
}
