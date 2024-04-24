# Wp Dev: Empower Your WordPress Development

Wp Dev is a versatile WordPress plugin designed to streamline and enhance the capabilities of developers. By leveraging the DependencyInjection Component, it offers a standardized and centralized approach to object construction within WordPress. Inspired by Symfony's DependencyInjection Component, this plugin equips developers with powerful tools to optimize their workflow.

Features:

- The DependencyInjection Component For WordPress

    - Standardize and centralize object construction.

    - Inspired by [The DependencyInjection Component](https://symfony.com/doc/current/components/dependency_injection.html) from **Symfony**.

## Table of content
- [Building WordPress Plugin Archive](#building-wordpress-plugin-archive)
    - [Prerequisites](#prerequisites)
    - [Make Commands](#make-commands)
        - [Build](#build)
- [Creating a Yaml File](#creating-a-yaml-file)
    - [Changing a Config Dir](#changing-a-config-dir)
    - [Changing a Config File](#changing-a-config-file)
    - [Using an Environment Variables](#using-an-environment-variables)
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

Ensure that `./bin/wp.sh` is executable before using the `make build` command: 

```
chmod +x ./bin/wp.sh
```

To build the WordPress plugin archive, run the following command:

```
make build
```

This command generates `wp-dev.zip`, a self-contained archive ready for WordPress installation.

## Creating a Yaml File

Wp Dev utilizes YAML for service definitions, promoting organization and scalability in applications. By default, it searches for **services.yaml** in `/wp-content/config`.

**services.yaml** follows the convention of the [Configuration Files](https://symfony.com/doc/current/components/dependency_injection.html#setting-up-the-container-with-configuration-files) defined in the documentation.

### Changing a Config Dir

Modify the configuration directory using the `wp_dev_config_dir` filter,

```php
add_filter( 'wp_dev_config_dir', function( string $config_dir ): string {
	return WP_CONTENT_DIR . '/custom-config';
});
```

### Changing a Config File

Alter the configuration file name with the `wp_dev_config_file` filter,

```php
add_filter( 'wp_dev_config_file', function( string $config_file ): string {
	return 'custom.yaml';
});
```

### Using an Environment Variables

Wp Dev supports WordPress environment variables via configuration files. Default supported variables include,

- WP_ENVIRONMENT_TYPE
- DB_NAME
- DB_USER
- DB_PASSWORD 
- DB_HOST
- DB_CHARSET
- DB_COLLATE 
- WP_CONTENT_DIR
- WP_CONTENT_URL
- WP_PLUGIN_DIR
- WP_PLUGIN_URL
- WP_UPLOAD_DIR
- WP_UPLOAD_URL
- WP_SITE_URL
- WP_HOME_URL

Referencing these variables in YAML is straightforward:

```yaml
services:
    myService:
        class: MyService
        arguments:
            db: '%wp_env(DB_NAME)%'
```

## Registering Services

To register a service, ensure your service class defines the **__invoke()** method. Then, add it to services.yaml:

```php
class MyService {
    public function __invoke() {
        // Do WordPress stuff
    }
}
```

```yaml
services:
    myService:
        class: MyService
```

To load services from the container, use the wp_dev_load_services filter:

```php
add_filter( 'wp_dev_load_services', function( array $service_aliases ): array {
	return array_merge( $service_aliases, array( 'myService' ) );
});
```

## Examples

Explore this [GitHub repository](https://github.com/hasukmistry/wp-dev-examples) for usage examples.

## License

Wp Dev is free software released under the GNU General Public License version 2 or any later version. Refer to [LICENSE](./LICENSE) for details.
