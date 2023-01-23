<?php
/**
 * Object template class.
 *
 * This class allows for templates for any object type, which includes `post`,
 * `term`, and `user`.  When viewing a particular single post, term archive, or
 * user/author archive page, the template can be used.
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
use Backdrop\Template\Manager\Contracts\Template as TemplateContract;

/**
 * Creates a new object template.
 *
 * @since  1.0.0
 * @access public
 */
class Template implements TemplateContract {

	/**
	 * Type of template. By default, we'll assume this is a post template,
	 * but theme authors can extend this to term or user templates, for
	 * example.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 */
	protected $type = 'post';

	/**
	 * Array of subtypes template works with.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array
	 */
	protected $subtype = [];

	/**
	 * Filename of the template.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 */
	protected $filename = '';

	/**
	 * Internationalized text label.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 */
	protected $label = '';

	/**
	 * Magic method to use in case someone tries to output the object as a
	 * string. We'll just return the name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function __toString() {

		return $this->filename();
	}

	/**
	 * Register a new template object.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $filename
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( string $filename, array $args = [] ) {

		foreach ( array_keys( get_object_vars( $this ) ) as $key ) {

			if ( isset( $args[ $key ] ) ) {
				$this->$key = $args[ $key ];
			}
		}

		// Allow `post_types` as an alias for `subtype`.
		if ( isset( $args['post_types'] ) ) {
			$this->subtype = (array) $args['post_types'];
		}

		$this->filename = $filename;
	}

	/**
	 * Returns the filename relative to the templates location.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function filename(): string {

		return $this->filename;
	}

	/**
	 * Returns the internationalized text label for the template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function label(): string {

		return $this->label;
	}

	/**
	 * Conditional function to check what type of template this is.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function isType( $type ): bool {

		return $type === $this->type;
	}

	/**
	 * Conditional function to check if the template has a specific subtype.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function hasSubtype( $subtype ): bool {

		return ! $this->subtype || in_array( $subtype, (array) $this->subtype );
	}

	/**
	 * Conditional function to check if the template is for a post type.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function forPostType( $type ): bool {

		return $this->isType( 'post' ) && $this->hasSubtype( $type );
	}
}
