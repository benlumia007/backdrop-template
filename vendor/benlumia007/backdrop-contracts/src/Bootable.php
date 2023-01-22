<?php
/**
 * Bootable interface.
 *
 * Defines the contract that bootable classes should utilize. The Bootable
 * classes should have a `boot()` method with the singular purpose of
 * "booting" the action and filter hooks for that class.This keeps the
 * action/filters out of the class constructor. Most bootable classes
 * are meant to be single-instance classes that get loaded once per page request.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-contracts
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Contracts;

/**
 * Bootable interface.
 *
 * @since  1.0.0
 * @access public
 */
interface Bootable {

    /**
     * Boots the class by running `add_action()` and `add_filter()` calls.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
	public function boot();
}
