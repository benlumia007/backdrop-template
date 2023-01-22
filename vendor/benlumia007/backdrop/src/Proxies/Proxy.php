<?php
/**
 * Proxy class
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Proxies;

use Backdrop\Core\Container;
use ReflectionException;

/**
 * Base static proxy class.
 *
 * @since  2.0.0
 * @access public
 */
class Proxy {

	/**
	 * The container object.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @var    Container
	 */
	protected static $container;

	/**
	 * Returns the name of the accessor for object registered in the container.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @return string
	 */
	protected static function accessor(): string {

		return '';
	}

	/**
	 * Sets the container object.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public static function setContainer( $container ) {

		static::$container = $container;
	}

	/**
	 * Returns the instance from the container.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @throws ReflectionException
	 * @return object
	 */
	protected static function instance() {

		return static::$container->resolve( static::accessor() );
	}

	/**
	 * Calls the requested method from the object registered with the
	 * container statically.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param string $method
	 * @param array $args
	 * @throws ReflectionException
	 * @return mixed
	 */
	public static function __callStatic( string $method, array $args ) {

		$instance = static::instance();

		return $instance->$method(...$args);
	}
}
