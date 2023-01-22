<?php
/**
 * Helper functions
 *
 * Helpers are functions designed for quickly accessing data from the container
 * that we need throughout the framework.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop;

use Backdrop\Proxies\App;

if ( ! function_exists(__NAMESPACE__ . '\\booted' ) ) {

	/**
	 * Conditional function for checking whether the application has been
	 * booted. Use before launching a new application. If booted, reference
	 * the `app()` instance directly.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return bool
	 */
	function booted(): bool {

		return defined('BACKDROP_BOOTED') && true === BACKDROP_BOOTED;
	}
}

if ( ! function_exists(__NAMESPACE__ . '\\app' ) ) {

	/**
	 * The single instance of the app. Use this function for quickly working
	 * with data.  Returns an instance of the `Backdrop\Core\Application`
	 * class. If the `$abstract` parameter is passed in, it'll resolve and
	 * return the value from the container.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param string $abstract
	 * @param array $params
	 * @return mixed
	 */
	function app( string $abstract = '', array $params = [] ) {

		return App::resolve( $abstract ?: 'app', $params );
	}
}
