# Wp Dev

A simple yet powerful WordPress plugin that enhances the developer's capability.

This plugin introduces following features:

- The DependencyInjection Component For WordPress

    - It allows you to standardize and centralize the way objects are constructed in WordPress.

    - It is heavily inspired by [The DependencyInjection Component](https://symfony.com/doc/current/components/dependency_injection.html) from **Symfony**.

## Table of content
- [Building WordPress Plugin Archive](#building-wordpress-plugin-archive)
    - [Prerequisites](#prerequisites)
    - [Make Commands](#make-commands)
        - [Build](#build)
- [Creating a Yaml File](#creating-a-yaml-file)
    - [Changing a Config Dir](#changing-a-config-dir)
    - [Changing a Config File](#changing-a-config-file)
- [Registering Services](#registering-services)
- [Examples](#examples)
- [License](#license)

## Building WordPress Plugin Archive

### Prerequisites

Before you begin, ensure you have met the following requirements:

- You have installed Docker and added support for Docker Compose commands. Instructions are available [here](https://docs.docker.com/compose/install/).

- You have installed GNU Make utility, which is commonly used to automate the build process of software projects. Make is often pre-installed if you're using a Unix-like system (such as Linux or macOS). Run this command to verify the installation:
`make --version`

### Make Commands

#### Build

Before using the `make build` command, Make sure that `./bin/wp.sh` is executable. 

`chmod +x ./bin/wp.sh` should do the job.

To build the WordPress plugin archive, run the following command:

```
make build
```

This command will create a new file called `wp-dev.zip` in the current directory, which includes all the necessary files and directories for the plugin.

The `wp-dev.zip` file is a self-contained archive that can be easily installed on a WordPress site.

## Creating a Yaml File

This plugin uses a YAML to write the definitions for the services. In anything but the smallest applications it makes sense to organize the service definitions by moving them into one or more configuration files. 

By default, the plugin will look for a file called **services.yaml** in the **`/wp-content/config`** directory.

**services.yaml** follows the convention of the [Configuration Files](https://symfony.com/doc/current/components/dependency_injection.html#setting-up-the-container-with-configuration-files) defined in the documentation.

### Changing a Config Dir

By default, the plugin will look for the configuration file in the **`/wp-content/config`** directory. However, you can change the location of the configuration directory by using the following filter,

```php
add_filter( 'wp_dev_config_dir', function( string $config_dir ): string {
	return WP_CONTENT_DIR . '/custom-config';
});
```

### Changing a Config File

By default, the plugin will look for the **services.yaml** in the **`/wp-content/config`** directory. However, you can change the name of the configuration file by using the following filter,

```php
add_filter( 'wp_dev_config_file', function( string $config_file ): string {
	return 'custom.yaml';
});
```

## Registering Services

To register a service in the container make sure your service class has **__invoke()** method defined.

```php
class MyService {
    public function __invoke() {
        // Do WordPress stuff
    }
}
```

As a second step, you need to register the service in the configuration file (`services.yaml`).

```yaml
services:
    myService:
        class: MyService
```

Once the service is defined in the configuration file (`services.yaml`), the Dependency Injection Component for WordPress will take place. By default, no services are loaded from the container. You can load services by using the following filter,

```php
add_filter( 'wp_dev_load_services', function( array $service_aliases ): array {
	return array_merge( $service_aliases, array( 'myService' ) );
});
```

## Examples

Check out the [examples](https://github.com/hasukmistry/wp-dev-examples) repo to understand the plugin usage.

## License

This repository is a free software, and is released under the terms of the GNU General Public License version 2 or (at your option) any later version. See [LICENSE](./LICENSE) for complete license.