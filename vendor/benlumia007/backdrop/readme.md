# Backdrop: Themes & Plugins Framework
Backdrop is a framework for developing themes & plugins for ClassicPress and WordPress.

Backdrop is the core application layer that consists of a service container and it can be use alone or alongside with Backdrop's available packages.

## Requirements
- [ClassicPress](https://www.classicpress.net/) 1.4+
- [WordPress](https://wordpress.org) 4.9+
- [PHP](https://www.php.net/releases/7_0_33.php) 7.0+
- [Composer](https://getcomposer.org) 2.2.18

## Installation
Use the following command from your preferred command line utility to install Backdrop.

<pre>
composer require benlumia007/backdrop
</pre>

## Themes
if bundling this directly in your theme, add the following code.
<pre>
if ( file_exists( get_parent_theme_file_path( 'vendor/autoload.php' ) ) ) {
	require_once( get_parent_theme_file_path( 'vendor/autoload.php' ) );
}
</pre>

## Plugins
if bundling this directly in your plugin, add the following code.
<pre>
if ( file_exists( plugin_dir_path( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
}
</pre>

## Registering and Booting Backdrop.
Please note that the Backdrop isn't launched until an instance of its `Backdrop\Core\Application` class is created and its `boot()` check the Backdrop\booted() function before attempting to create a new app. If one exists, then it should use the existing instance via the `Backdrop\app()` helper function.
<pre>
// Create a new application
$slug = Backdrop\booted ? Backdrop\app() : new Backdrop\Core\Application();

// Add service provider
$slug->provider( YourProject\Provider::class );

// Create and action hook for child themes or plugins
do_action( "$slug/child/theme", $slug );

// Boot the application
$slug->boot();
</pre>

## Copyright and Licenses
This project is licensed under the GNU GPL, version 2 or later.

2019–2023 © Benjamin Lu
