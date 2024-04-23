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

