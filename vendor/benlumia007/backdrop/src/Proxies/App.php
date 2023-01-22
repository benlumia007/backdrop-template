<?php
/**
 * App static proxy class.
 *
 * Static proxy for the application instance.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Proxies;

/**
 * App static proxy class.
 *
 * @since  2.0.0
 * @access public
 */
class App extends Proxy {

	/**
	 * Returns the name of the accessor for object registered in the container.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @return string
	 */
	protected static function accessor(): string {

		return 'app';
	}
}
