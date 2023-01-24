<?php
/**
 * Engine contract.
 *
 * Engine classes are wrappers around the View system.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-template
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Template\Contracts;

use Backdrop\Template\View\View;

/**
 * View interface.
 *
 * @since  1.0.0
 * @access public
 */
interface Engine {

	/**
	 * Returns a View object.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string            $name
	 * @param  array|string      $slugs
	 * @param  array|Collection  $data
	 * @return View
	 */
	public function view( string $name, $slugs = [], $data = [] ): View;

	/**
	 * Outputs a view template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string            $name
	 * @param  array|string      $slugs
	 * @param  array|Collection  $data
	 * @return void
	 */
	public function display( string $name, $slugs = [], $data = [] );

	/**
	 * Returns a view template as a string.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string            $name
	 * @param  array|string      $slugs
	 * @param  array|Collection  $data
	 * @return string
	 */
	function render( string $name, $slugs = [], $data = [] ): string;
}
