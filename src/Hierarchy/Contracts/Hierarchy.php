<?php
/**
 * Template hierarchy contract.
 *
 * Defines the interface that template hierarchy classes must use.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-template-hierarchy
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Template\Hierarchy\Contracts;

use Backdrop\Contracts\Bootable;

/**
 * Template hierarchy interface.
 *
 * @since  1.0.0
 * @access public
 */
interface Hierarchy extends Bootable {

	/**
	 * Should return an array of template file names without the file
	 * extension (`.php`).
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function hierarchy(): array;
}
