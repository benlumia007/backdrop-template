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
use ReflectionException;
use Backdrop\Template\Hierarchy\Component as Hierarchy;
use Backdrop\Template\Contracts\Hierarchy as HierarchyContracts;
use Backdrop\Template\Manager\Component as Manager;
use Backdrop\Template\Contracts\Engine as EngineContract;
use Backdrop\Template\Contracts\View as ViewContract;
use Backdrop\Template\View\Engine;
use Backdrop\Template\View\View;

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

		// a single instance of the Hierarchy
		$this->app->singleton( HierarchyContracts::class, Hierarchy::class );

		// Bind a single instance of the Manager.
		$this->app->singleton( Manager::class );

		// Bind a single instance of the engine contract.
		$this->app->singleton(  Engine::class );

		// Bind the view contract
		$this->app->bind(  View::class );
	}

	/**
	 * Boots the hierarchy by firing its hooks in the `boot()` method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @throws ReflectionException
	 * @return void
	 */
	public function boot() {

		$this->app->resolve( Hierarchy::class )->boot();
		$this->app->resolve( Manager::class )->boot();
	}
}
