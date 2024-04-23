<?php
/**
 * Config class to load configs.
 *
 * @package WpDev\Core
 */

declare(strict_types=1);

namespace WpDev\Core;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use WpDev\Core\Contracts\ConfigInterface;

/**
 * Config class
 *
 * @since 1.0.0
 */
class Config implements ConfigInterface {
	/**
	 * Config constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param YamlFileLoader $loader The YAML file loader.
	 *
	 * @return void
	 */
	public function __construct( protected YamlFileLoader $loader ) {
	}

	/**
	 * Load a config file.
	 *
	 * @since 1.0.0
	 *
	 * @param string $file The config file to load.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException If the file is not found.
	 */
	public function load( string $file ): void {
		$this->loader->load( $file );
	}
}
