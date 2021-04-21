<?php
/**
 * Template class
 *
 * @package micropackage/templates
 */

namespace Micropackage\Templates;

use Micropackage\Templates\Exceptions\TemplateException;
use Micropackage\Templates\Exceptions\StorageException;

/**
 * Template class
 */
class Template {

	/**
	 * Filesystem instance
	 *
	 * @var Micropackage\Filesystem\Filesystem
	 */
	private $fs;

	/**
	 * Template name
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Template variables
	 *
	 * @var array
	 */
	private $vars = [];

	/**
	 * Constructor
	 *
	 * @throws TemplateException When variables is not an array.
	 * @throws StorageException When storage wasn't found.
	 * @since  1.0.0
	 * @param  string $storage Storage name.
	 * @param  string $name    Template name.
	 * @param  array  $vars    Tempalte variables.
	 *                        Default: empty.
	 */
	public function __construct( $storage, $name, $vars = [] ) {

		$this->fs   = Storage::get( $storage );
		$this->name = $name;

		if ( empty( $this->fs ) ) {
			throw new StorageException( sprintf( 'Storage %s wasn\'t found', $storage ) );
		}

		if ( ! is_array( $vars ) ) {
			throw new TemplateException( sprintf( 'Template %s vars should be an array', $name ) );
		}

		$this->vars = $vars;

	}

	/**
	 * Magic method for string conversion
	 *
	 * @since  1.1.1
	 * @return string
	 */
	public function __toString() {
		try {
			return $this->output();
		} catch ( TemplateException $e ) {
			return $e->getMessage();
		}
	}

	/**
	 * Gets template name
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Gets path with extension
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_path() {
		return $this->fs->path( $this->get_rel_path() );
	}

	/**
	 * Gets relative path with extension
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_rel_path() {
		return sprintf( '%s.php', $this->name );
	}

	/**
	 * Gets all template variables
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_vars() {
		return $this->vars;
	}

	/**
	 * Clears all template variables
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function clear_vars() {
		$this->vars = [];
		return $this;
	}

	/**
	 * Sets template var value
	 *
	 * @since  1.0.0
	 * @param  string $var_name Template var name.
	 * @param  mixed  $value    Var value.
	 * @return $this
	 */
	public function set( $var_name, $value ) {
		$this->vars[ $var_name ] = $value;
		return $this;
	}

	/**
	 * Gets template var value
	 *
	 * @since  1.0.0
	 * @param  string $var_name Template var name.
	 * @param  mixed  $default  Template var default value.
	 * @return mixed|null       Null if var not set.
	 */
	public function get( $var_name, $default = null ) {

		if ( isset( $this->vars[ $var_name ] ) ) {
			return $this->vars[ $var_name ];
		}

		return $default;

	}

	/**
	 * Prints the template var
	 *
	 * @since  1.0.0
	 * @param  string $var_name Template var name.
	 * @param  mixed  $default  Template var default value.
	 * @return void
	 */
	public function the( $var_name, $default = null ) {
		echo (string) $this->get( $var_name, $default ); // phpcs:ignore
	}

	/**
	 * Removes the template var
	 *
	 * @since  1.0.0
	 * @param  string $var_name Template var name.
	 * @return $this
	 */
	public function remove( $var_name ) {
		unset( $this->vars[ $var_name ] );
		return $this;
	}

	/**
	 * Checks if template file exists
	 *
	 * @since  1.1.1
	 * @return bool
	 */
	public function exists() {
		return $this->fs->is_file( $this->get_rel_path() );
	}

	/**
	 * Renders the template
	 *
	 * @since  1.0.0
	 * @return void
	 * @throws TemplateException If teplate file does not exist.
	 */
	public function render() {

		if ( ! $this->exists() ) {
			throw new TemplateException( sprintf( 'Template file "%s" does not exist', $this->get_path() ) );
		}

		$get_method = [ $this, 'get' ];
		$get        = function () use ( $get_method ) {
			return call_user_func_array( $get_method, func_get_args() );
		};
		$the_method = [ $this, 'the' ];
		$the        = function () use ( $the_method ) {
			return call_user_func_array( $the_method, func_get_args() );
		};

		include $this->get_path();

	}

	/**
	 * Outputs the template
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function output() {
		ob_start();
		$this->render();
		return ob_get_clean();
	}

}
