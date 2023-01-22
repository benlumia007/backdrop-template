<?php
/**
 * Base service provider.
 *
 * This is the base service provider class. This is an abstract class that must
 * be extended to create new service providers for the application.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Core;

use Backdrop\Contracts\Bootable;

abstract class ServiceProvider implements Bootable {

	/**
	 * Application instance. Subclasses should use this property to access
	 * the application (container) to add, remove, or resolve bindings.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @var    Container
	 */
	protected $app;

	/**
	 * Accepts the application and sets it to the `$app` property.
	 *
	 * @param Container $app
	 * @return void
	 *@since  2.0.0
	 * @access public
	 */
	public function __construct( Container $app ) {

		$this->app = $app;
	}

	/**
	 * Callback executed when the `Application` class registers providers.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function register() {}

	/**
	 * Callback executed after all the service providers have been registered.
	 * This is particularly useful for single-instance container objects that
	 * only need to be loaded once per page and need to be resolved early.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {}
}
