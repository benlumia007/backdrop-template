<?php
/**
 * Renderable contract.
 *
 * Renderable classes should implement a `render()` method that
 * returns an HTML string ready for output to the screen. While
 * there is no way to ensure this via the contract, the intent
 * here is for anything that is renderable to already be escaped.
 * For clarity in the code, when returning raw data, it is recommended
 * to use an alternative method name, such as `get()` and not use
 * this contract.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-contracts
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Contracts;

/**
 * Renderable interface
 *
 * @since  1.0.0
 * @access public
 */
interface Renderable {

    /**
	 * Return an HTML string for output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function render(): string;
}
