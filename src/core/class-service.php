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
	 * Container instance.
	 *
	 * @since 1.0.1
	 *
	 * @var Container
	 *
	 * @access protected
	 */
	protected Container $container;

	/**
	 * Service constructor.
	 *
	 * @since 1.0.1
	 */
	public function __construct() {
		$this->container = Container::instance();
	}

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
	 * @since 1.0.1 Refactored container and container builder usage.
	 *
	 * @return Service
	 */
	public function set_services(): Service {
		$services = apply_filters(
			'wp_dev_load_services',
			array()
		);

		foreach ( $services as $service ) {
			// Call the __invoke() method of the class.
			$this->container->get( $service )();
		}

		return $this;
	}

	/**
	 * Set environment variables from WordPress.
	 *
	 * @since 1.0.1 Added support for WordPress environment variables.
	 *
	 * @return Service
	 */
	public function set_wp_envs(): Service {
		$builder    = $this->container->get_container_builder();
		$upload_dir = wp_upload_dir();

		$builder->setParameter( 'wp_env(WP_ENVIRONMENT_TYPE)', WP_ENVIRONMENT_TYPE );

		$builder->setParameter( 'wp_env(DB_NAME)', DB_NAME );
		$builder->setParameter( 'wp_env(DB_USER)', DB_USER );
		$builder->setParameter( 'wp_env(DB_PASSWORD)', DB_PASSWORD );
		$builder->setParameter( 'wp_env(DB_HOST)', DB_HOST );
		$builder->setParameter( 'wp_env(DB_CHARSET)', DB_CHARSET );
		$builder->setParameter( 'wp_env(DB_COLLATE)', DB_COLLATE );

		$builder->setParameter( 'wp_env(WP_CONTENT_DIR)', WP_CONTENT_DIR );
		$builder->setParameter( 'wp_env(WP_CONTENT_URL)', content_url() );

		$builder->setParameter( 'wp_env(WP_PLUGIN_DIR)', WP_PLUGIN_DIR );
		$builder->setParameter( 'wp_env(WP_PLUGIN_URL)', plugins_url() );

		$builder->setParameter( 'wp_env(WP_UPLOAD_DIR)', $upload_dir['basedir'] );
		$builder->setParameter( 'wp_env(WP_UPLOAD_URL)', $upload_dir['baseurl'] );

		$builder->setParameter( 'wp_env(WP_SITE_URL)', site_url() );
		$builder->setParameter( 'wp_env(WP_HOME_URL)', home_url() );

		return $this;
	}

	/**
	 * Register default config service.
	 *
	 * Keep in mind that,
	 * ContainerBuilder is available without loaded config file.
	 *
	 * @since 1.0.0
	 * @since 1.0.1 Refactored container and container builder usage.
	 *
	 * @param string $path The plugin path.
	 *
	 * @return ConfigInterface
	 */
	private function register_config( string $path ): ConfigInterface {
		$builder = $this->container->get_container_builder();

		$this->container
			->register( 'fileLocator', FileLocator::class )
			->addArgument( $path );

		$this->container
			->register( 'yamlFileLoader', YamlFileLoader::class )
			->addArgument( $builder )
			->addArgument( new Reference( 'fileLocator' ) );

		$this->container
			->register( 'config', Config::class )
			->addArgument( new Reference( 'yamlFileLoader' ) );

		return $this->container->get( 'config' );
	}
}
