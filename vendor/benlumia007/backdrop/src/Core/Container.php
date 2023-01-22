<?php
/**
 * Container class.
 *
 * The `Container` class handles storing objects for later use and
 * handles single instances to avoid globals or singleton.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Core;

use ArrayAccess;
use Closure;
use ReflectionClass;
use ReflectionException;

/**
 * A simple container for objects.
 *
 * @since  2.0.0
 * @access public
 */
class Container implements ArrayAccess {

	/**
	 * Stored definitions of objects.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @var    array
	 */
	protected $bindings = [];

	/**
	 * Array of aliases for bindings.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @var    array
	 */
	protected $aliases = [];

	/**
	 * Array of single instance objects.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @var    array
	 */
	protected $instances = [];

	/**
	 * Array of object extensions.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @var    array
	 */
	protected $extensions = [];

	/**
	 * Set up a new container.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  array  $definitions
	 * @return void
	 */
	public function __construct( array $definitions = [] ) {

		foreach ( $definitions as $abstract => $concrete ) {

			$this->add( $abstract, $concrete );
		}
	}

	/**
	 * Add a binding. The abstract should be a key, abstract class name, or
	 * interface name. The concrete should be the concrete implementation of
	 * the abstract.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string $abstract
	 * @param  mixed  $concrete
	 * @param  bool   $shared
	 * @return void
	 */
	public function bind( string $abstract, $concrete = null, bool $shared = false ) {

		// Drop all the stale instances and aliases
		unset( $this->instances[ $abstract ] );

		/**
		 * If no concrete type was given, we will simply set the concrete type to the
		 * abstract type. After, the concrete type to be registered as shared without
		 * be forced to state their classes in both  of the parameters
		 */
		if ( is_null( $concrete ) ) {
			$concrete = $abstract;
		}

		$this->bindings[ $abstract ]   = compact( 'concrete', 'shared' );
		$this->extensions[ $abstract ] = [];
	}

	/**
	 * Alias for `bind()`.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  mixed   $concrete
	 * @param  bool    $shared
	 * @return void
	 */
	public function add( string $abstract, $concrete = null, bool $shared = false ) {

		if ( ! $this->bound( $abstract ) ) {

			$this->bind( $abstract, $concrete, $shared );
		}
	}

	/**
	 * Remove a binding.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $abstract
	 * @return void
	 */
	public function remove( string $abstract ) {

		if ( $this->bound( $abstract ) ) {

			unset( $this->bindings[ $abstract ], $this->instances[ $abstract ] );
		}
	}

	/**
	 * Resolve and return the binding.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param string $abstract
	 * @param array $parameters
	 * @return mixed
	 * @throws ReflectionException
	 */
	public function resolve( string $abstract, array $parameters = [] ) {

		// Let's grab the true abstract name.
		$abstract = $this->getAlias( $abstract );

		/**
		 * if an instance of the type is currently being managed as a singleton
		 * we'll just return an existing instance instead of instantiating a new
		 * instance so the developer can keep using the same objects instance
		 * every time.
		 */
		if ( isset( $this->instances[ $abstract ] ) ) {
			return $this->instances[ $abstract ];
		}

		// Get the concrete implementation.
		$concrete = $this->getConcrete( $abstract );

		// If we can't build an object, assume we should return the value.
		if ( ! $this->isBuildable( $concrete ) ) {

			// If we don't actually have this, return false.
			if ( ! $this->bound( $abstract ) ) {
				return false;
			}

			return $concrete;
		}

		// Build the object.
		$object = $this->build( $concrete, $parameters );

		if ( ! $this->bound( $abstract ) ) {
			return $object;
		}

		// If shared instance, make sure to store it in the instances
		// array so that we're not creating new objects later.
		if ( $this->bindings[ $abstract ]['shared'] && ! isset( $this->instances[ $abstract ] ) ) {

			$this->instances[ $abstract ] = $object;
		}

		// Run through each of the extensions for the object.
		foreach ( $this->extensions[ $abstract ] as $extension ) {

			$object = new $extension( $object, $this );
		}

		// Return the object.
		return $object;
	}

	/**
	 * Alias for `resolve()`.
	 *
	 * Follows the PSR-11 standard. Do not alter.
	 * @link https://www.php-fig.org/psr/psr-11/
	 *
	 * @since  2.0.0
	 * @access public
	 * @param string $abstract
	 * @return object
	 * @throws ReflectionException
	 */
	public function get( string $abstract ) {

		return $this->resolve( $abstract );
	}

	/**
	 * Check if a binding exists.
	 *
	 * Follows the PSR-11 standard. Do not alter.
	 * @link https://www.php-fig.org/psr/psr-11/
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $abstract
	 * @return bool
	 */
	public function bound( string $abstract ): bool {

		return isset( $this->bindings[ $abstract ] ) || isset( $this->instances[ $abstract ] );
	}

	/**
	 * Add a shared binding.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  object  $concrete
	 * @return void
	 */
	public function singleton( string $abstract, $concrete = null ) {

		$this->add( $abstract, $concrete, true );
	}

	/**
	 * Add an existing instance. This can be an instance of an object or a
	 * single value that should be stored.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  mixed   $instance
	 * @return mixed
	 */
	public function instance( string $abstract, $instance ) {

		$this->instances[ $abstract ] = $instance;

		return $instance;
	}

	/**
	 * Extend a binding with something like a decorator class. Cannot
	 * extend resolved instances.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  Closure $closure
	 * @return void
	 */
	public function extend( string $abstract, Closure $closure ) {

		$abstract = $this->getAlias( $abstract );

		$this->extensions[ $abstract ][] = $closure;
	}


	/**
	 * Creates an alias for an abstract type. This allows you to add alias
	 * names that are easier to remember rather than using full class names.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $abstract
	 * @param  string  $alias
	 * @return void
	 */
	public function alias( string $abstract, string $alias ) {

		$this->aliases[ $alias ] = $abstract;
	}

	/**
	 * Checks if a property exists via `ArrayAccess`.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  mixed  $offset
	 * @return bool
	 */
	public function offsetExists( $offset ): bool {

		return $this->bound( $offset );
	}

	/**
	 * Returns a property via `ArrayAccess`.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param mixed $offset
	 * @return false|object
	 * @throws ReflectionException
	 */
	public function offsetGet( $offset ) {

		return $this->get( $offset );
	}

	/**
	 * Sets a property via `ArrayAccess`.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  mixed  $offset
	 * @param  mixed   $value
	 * @return void
	 */
	public function offsetSet( $offset, $value ) {

		$this->add( $offset, $value );
	}

	/**
	 * Unsets a property via `ArrayAccess`.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  mixed  $offset
	 * @return void
	 */
	public function offsetUnset( $offset ) {

		$this->remove( $offset );
	}

	/**
	 * Checks if we're dealing with an alias and returns the abstract. If
	 * not an alias, return the abstract passed in.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @param  string    $abstract
	 * @return string
	 */
	protected function getAlias( string $abstract ) : string {

		if ( isset( $this->aliases[ $abstract ] ) ) {

			return $this->aliases[ $abstract ];
		}

		return $abstract;
	}

	/**
	 * Gets the concrete of an abstract.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @param  string    $abstract
	 * @return mixed
	 */
	protected function getConcrete( string $abstract ) {

		$concrete = false;
		$abstract = $this->getAlias( $abstract );

		if ( $this->bound( $abstract ) ) {
			$concrete = $this->bindings[ $abstract ]['concrete'];
		}

		return $concrete ?: $abstract;
	}

	/**
	 * Determines if a concrete is buildable. It should either be a closure
	 * or a concrete class.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @param  mixed    $concrete
	 * @return bool
	 */
	protected function isBuildable( $concrete ): bool {

		return $concrete instanceof Closure || ( is_string( $concrete ) && class_exists( $concrete ) );
	}

	/**
	 * Builds the concrete implementation. If a closure, we'll simply return
	 * the closure and pass the included parameters. Otherwise, we'll resolve
	 * the dependencies for the class and return a new object.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @param mixed $concrete
	 * @param array $parameters
	 * @return object
	 * @throws ReflectionException
	 */
	protected function build( $concrete, array $parameters = [] ) {

		if ( $concrete instanceof Closure ) {
			return $concrete( $this, $parameters );
		}

		$reflect = new ReflectionClass( $concrete );

		$constructor = $reflect->getConstructor();

		if ( ! $constructor ) {
			return new $concrete();
		}

		return $reflect->newInstanceArgs(
			$this->resolveDependencies( $constructor->getParameters(), $parameters )
		);
	}

	/**
	 * Resolves the dependencies for a method's parameters.
	 *
	 * @todo Handle errors when we can't solve a dependency.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @param array $dependencies
	 * @param array $parameters
	 * @return array
	 * @throws ReflectionException
	 */
	protected function resolveDependencies( array $dependencies, array $parameters ): array {

		$args = [];

		foreach ( $dependencies as $dependency ) {

			// If a dependency is set via the parameters passed in, use it.
			if ( isset( $parameters[ $dependency->getName() ] ) ) {

				$args[] = $parameters[ $dependency->getName() ];

				// If the parameter is a class, resolve it.
			} elseif ( ! is_null( $dependency->getClass() ) ) {

				$args[] = $this->resolve( $dependency->getClass()->getName() );

				// Else, use the default parameter value.
			} elseif ( $dependency->isDefaultValueAvailable() ) {

				$args[] = $dependency->getDefaultValue();
			}
		}

		return $args;
	}

	/**
	 * Magic method when trying to set a property.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set( string $name, $value ) {

		$this->add( $name, $value );
	}

	/**
	 * Magic method when trying to unset a property.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $name
	 * @return void
	 */
	public function __unset( string $name ) {

		$this->remove( $name );
	}

	/**
	 * Magic method when trying to check if a property exists.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $name
	 * @return bool
	 */
	public function __isset( string $name ): bool {

		return $this->bound( $name );
	}

	/**
	 * Magic method when trying to get a property.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param string $name
	 * @throws ReflectionException
	 * @return false|object
	 */
	public function __get( string $name ) {

		return $this->get( $name );
	}
}
