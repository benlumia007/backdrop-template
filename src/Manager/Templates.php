<?php
/**
 * Templates manager.
 *
 * This class is just a wrapper around the `Collection` class for adding a
 * specific type of data.  Essentially, we make sure that anything added to the
 * collection is in fact a `Template`.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/benlumia007/backdrop-template-manager
 */

/**
 * Define namespace
 */
namespace Backdrop\Template\Manager;

use Backdrop\Tools\Collection;
use function Backdrop\Template\Helpers\path;

/**
 * Template collection class.
 *
 * @since  1.0.0
 * @access public
 */
class Templates extends Collection {

	/**
	 * Add a new custom template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	public function add( string $name, $value ) {

		$path = ltrim( trailingslashit( path( 'templates' ) ) );

		$name = $path . $name;

		parent::add( $name, new Template( $name, $value ) );
	}
}
