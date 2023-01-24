<?php
/**
 * View class.
 *
 * This file maintains the `View` class.  It's used for setting up and rendering
 * theme template files.  Views are a bit like a suped-up version of the core
 * WordPress `get_template_part()` function.  However, it allows you to build a
 * hierarchy of potential templates as well as pass in any arbitrary data to your
 * templates for use.
 *
 * Every effort has been made to make this compliant with WordPress.org theme
 * directory guidelines by providing compatible action hooks with WordPress core
 * `get_template_part()` and other `get_*()` functions for templates.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @link      https://github.com/benlumia007/backdrop-template-view
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Define namespace
 */
namespace Backdrop\Template\View;

use function Backdrop\Template\Helpers\locate as locate_template;
use Backdrop\Tools\Collection;

/**
 * View class.
 *
 * @since  1.0.0
 * @access public
 */
class View {

	/**
	 * Name of the view. This is primarily used as the folder name. However,
	 * it can also be the filename as the final fallback if no folder exists.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 */
	protected $name = '';

	/**
	 * Array of slugs to look for. This creates the hierarchy based on the
	 * `$name` property (e.g., `{$name}/{$slug}.php`). Slugs are used in
	 * the order that they are set.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string|array
	 */
	protected $slugs = [];

	/**
	 * An array of data that is passed into the view template.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array
	 */
	protected $data = [];

	/**
	 * The template filename.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    ?string
	 */
	protected $template = null;

	/**
	 * Sets up the view properties.
	 *
	 * @param string $name
	 * @param string|array $slugs
	 * @param Collection|null $data
	 * @since    1.0.0
	 * @access    public
	 */
	public function __construct( string $name, $slugs = [], Collection $data = null ) {

		$this->name  = $name;
		$this->slugs = ( array ) $slugs;
		$this->data = $data;

		// Apply filters after all the properties have been assigned.
		// This way, the full object is available to filters.
		$this->slugs = apply_filters( "backdrop/template/view/{$this->name}/slugs", $this->slugs, $this );
		$this->data  = apply_filters( "backdrop/template/view/{$this->name}/data",  $this->data,  $this );
	}

	/**
	 * When attempting to use the object as a string, return the template output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function __toString() {

		return $this->render();
	}

	/**
	 * Returns the array of slugs.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function slugs(): array {

		return ( array ) $this->slugs;
	}

	/**
	 * Uses the array of template slugs to build a hierarchy of potential
	 * templates that can be used.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return array
	 */
	protected function hierarchy(): array {

		// Uses the slugs to build a hierarchy.
		foreach ( $this->slugs as $slug ) {

			$templates[] = "{$this->name}/{$slug}.php";
		}

		// Add in a `default.php` template.
		if ( ! in_array( 'default', $this->slugs ) ) {

			$templates[] = "{$this->name}/default.php";
		}

		// Fallback to `{$name}.php` as a last resort.
		$templates[] = "{$this->name}.php";

		// Allow developers to overwrite the hierarchy.
		return apply_filters( "backdrop/template/view/{$this->name}/hierarchy", $templates, $this->slugs );
	}

	/**
	 * Locates the template.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return string
	 */
	protected function locate(): string {

		return locate_template( $this->hierarchy() );
	}

	/**
	 * Returns the located template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function template(): string {

		if ( is_null( $this->template ) ) {

			$this->template = $this->locate();
		}

		return $this->template;
	}

	/**
	 * Sets up data to be passed to the template and renders it.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function display() {

		// Compatibility with core WP's template parts.
		$this->templatePartCompat();

		if ( $this->template() ) {

			// Load the template.
			include( $this->template() );
		}
	}

	/**
	 * Returns the template output as a string.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function render(): string {
		ob_start();
		$this->display();
		return ob_get_clean();
	}

	/**
	 * Fires the core WP action hooks for template parts.
	 *
	 * Note that WP refers to `$name` and `$slug` differently than we do.
	 * They're the opposite of what we use in our function.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected function templatePartCompat() {

		// The slug is a string in WP and we have an array. So, we're
		// just going to use the first item of the array in this case.
		$slug = $this->slugs ? reset( $this->slugs ) : null;

		// Compat with `get_header|footer|sidebar()`.
		if ( in_array( $this->name, [ 'header', 'footer', 'sidebar' ] ) ) {

			do_action( "get_{$this->name}", $slug );

			// Compat with `get_template_part()`.
		} else {
			do_action( "get_template_part_{$this->name}", $this->name, $slug );
		}
	}
}
