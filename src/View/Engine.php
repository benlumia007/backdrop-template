<?php
/**
 * Engine class.
 *
 * A wrapper around the `View` class with methods for quickly working with views
 * without having to manually instantiate a view object.  It's also useful
 * because it passes an `$engine` variable to all views.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-template
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Backdrop\Template\View;

use Backdrop\Proxies\App;

/**
 * Engine class
 *
 * @since  1.0.0
 * @access public
 */
class Engine {

	/**
	 * Returns a View object.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string            $name
	 * @param  array|string      $slugs
	 * @return View
	 */
	public function view( string $name, array $slugs = [] ): View {

		return App::resolve( View::class, compact( 'name', 'slugs' ) );
	}

	/**
	 * Outputs a view template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string           $name
	 * @param  array|string     $slugs
	 * @return void
	 */
	public function display( string $name, array $slugs = [] ) {

		$this->view( $name, $slugs )->display();
	}

	/**
	 * Returns a view template as a string.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string            $name
	 * @param  array|string      $slugs
	 * @return string
	 */
	public function render( string $name, array $slugs = [] ): string {

		return $this->view( $name, $slugs )->render();
	}
}
