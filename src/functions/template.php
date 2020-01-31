<?php
/**
 * Template functions
 *
 * @package micropackage/templates
 */

namespace Micropackage\Templates;

/**
 * Prints the template
 * Wrapper for Template class
 *
 * @since  [Next]
 * @param  string $storage Storage name.
 * @param  string $name    Template name.
 * @param  array  $vars    Tempalte variables.
 *                         Default: empty.
 * @return void
 */
function template( $storage, $name, $vars = [] ) {
	( new Template( $storage, $name, $vars ) )->render();
}

/**
 * Outputs the template
 * Wrapper for Template class
 *
 * @since  [Next]
 * @param  string $storage Storage name.
 * @param  string $name    Template name.
 * @param  array  $vars    Tempalte variables.
 *                         Default: empty.
 * @return string
 */
function get_template( $storage, $name, $vars = [] ) {
	return ( new Template( $storage, $name, $vars ) )->output();
}
