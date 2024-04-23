<?php
/**
 * Plugin class to load plugin.
 *
 * @package WpDev
 */

declare(strict_types=1);

namespace WpDev;

use WpDev\Core\Service;

/**
 * Plugin class
 *
 * @since 1.0.0
 */
class Plugin {
	/**
	 * Plugin instance.
	 *
	 * @since 1.0.0
	 *
	 * @var Plugin
	 */
	private static $instance;

	/**
	 * Get the plugin instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Plugin
	 */
	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException If the file is not found.
	 */
	public function init(): void {
		if ( wp_installing() ) {
			return;
		}

		// Spin up the service config and container.
		add_action(
			'wp_loaded',
			function () {
				$config_dir  = apply_filters( 'wp_dev_config_dir', WP_CONTENT_DIR . '/config' );
				$config_file = apply_filters( 'wp_dev_config_file', 'services.yaml' );

				// Set config service.
				Service::instance()
					->set_config(
						$config_dir,
						$config_file
					)
					->set_services();
			}
		);
	}
}
