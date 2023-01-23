<?php
/**
 * View service provider.
 *
 * This is the service provider for the view system. The primary purpose of
 * this is to use the container as a factory for creating views. By adding this
 * to the container, it also allows the view implementation to be overwritten.
 * That way, any custom functions will utilize the new class.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-template-view
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Template;

use Backdrop\Core\ServiceProvider;
use Backdrop\Template\Hierarchy\Component as Hierarchy;
use Backdrop\Template\Hierarchy\Contracts\Hierarchy as HierarchyContracts;
use Backdrop\Template\View\Engine;

/**
 * View provider class.
 *
 * @since  1.0.0
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Binds the implementation of the view contract to the container.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		// Bind a single instance of the engine contract.
		$this->app->singleton( HierarchyContracts::class, Hierarchy::class );
		$this->app->singleton( Engine::class );
	}

	/**
	 * Boots the hierarchy by firing its hooks in the `boot()` method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		$this->app->resolve( Hierarchy::class )->boot();
	}
}
