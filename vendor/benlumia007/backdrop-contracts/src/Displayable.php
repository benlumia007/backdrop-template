<?php
/**
 * Displayable contract.
 *
 * Displayable classes should implement a `display()` method.
 * The intent of this method is to output an HTML string to the
 * screen. This data should already be escaped prior to be output.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-contracts
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Contracts;

/**
 * Displayable interface
 *
 * @since  1.0.0
 * @access public
 */
interface Displayable {

    /**
	 * Prints the HTML string.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function display();
}
