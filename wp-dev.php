<?php
/**
 * Plugin Name: Wp-Dev
 * Plugin URI:
 * Description: A simple yet powerful WordPress plugin that enhances the developer's capability.
 * Version: 1.0.1
 * Author: Hasmukh Mistry
 * Author URI:
 * License: GPL-2.0+
 */

declare(strict_types=1);

use WpDev\Plugin;

if ( ! class_exists( Plugin::class ) && is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	/** @noinspection PhpIncludeInspection */
	require_once __DIR__ . '/vendor/autoload.php';
}

class_exists( Plugin::class ) && Plugin::instance()->init();
