<?php
/**
 * Class TestTemplate
 *
 * @package micropackage/templates
 */

namespace Micropackage\Templates\Test;

use Micropackage\Templates\Template;
use Micropackage\Templates\Storage;
use Micropackage\Templates\Exceptions;

/**
 * Template test case.
 */
class TestTemplate extends \WP_UnitTestCase {

	protected static $storage_dir = __DIR__;

	public static function setUpBeforeClass() {

		parent::setUpBeforeClass();

		try {
			Storage::add( 'test', self::$storage_dir );
		} catch ( Exceptions\StorageException $e ) {

		}

	}

	/**
	 * @expectedException Micropackage\Templates\Exceptions\TemplateException
	 */
	public function test_should_throw_exception_if_vars_are_not_array() {
		new Template( 'test', 'template', 'var' );
	}

	public function test_should_get_name() {
		$name     = 'templates/section/template';
		$template = new Template( 'test', $name );
		$this->assertSame( $name, $template->get_name() );
	}

	public function test_should_return_rel_path() {
		$name     = 'templates/section/template';
		$template = new Template( 'test', $name );
		$this->assertSame( sprintf( '%s.php', $name ), $template->get_rel_path() );
	}

	public function test_should_return_path() {
		$name     = 'templates/section/template';
		$template = new Template( 'test', $name );
		$this->assertSame( sprintf( '%s/%s.php', self::$storage_dir, $name ), $template->get_path() );
	}

	public function test_should_return_variable() {

		$vars = [
			'first'  => uniqid(),
			'second' => 'test',
		];

		$template = new Template( 'test', 'test', $vars );

		$this->assertSame( $vars['first'], $template->get( 'first' ) );
		$this->assertSame( $vars['second'], $template->get( 'second' ) );

	}

	public function test_should_return_null_if_var_not_set() {

		$vars = [
			'first'  => uniqid(),
			'second' => 'test',
		];

		$template = new Template( 'test', 'test', $vars );

		$this->assertSame( null, $template->get( 'test' ) );


	}

	public function test_should_print_var() {

		$vars = [
			'first' => uniqid(),
		];

		$template = new Template( 'test', 'test', $vars );

		$this->expectOutputString( $vars['first'] );
		$template->the( 'first' );

	}

	public function test_should_print_nothing_if_var_not_set() {

		$vars = [
			'first' => uniqid(),
		];

		$template = new Template( 'test', 'test', $vars );

		$this->expectOutputString( '' );
		$template->the( 'test' );

	}

	public function test_should_set_var_and_return_object() {

		$value    = uniqid();
		$template = new Template( 'test', 'test' );

		$return = $template->set( 'var', $value );

		$this->assertSame( $value, $template->get( 'var' ) );
		$this->assertSame( $template, $return );

	}

	public function test_should_set_vars_and_return_object() {

		$vars = [
			'first'  => uniqid(),
			'second' => 'test',
		];

		$template = new Template( 'test', 'test' );

		$return = $template->set( 'first', $vars['first'] )
						   ->set( 'second', $vars['second'] );

		$this->assertSame( $vars['first'], $template->get( 'first' ) );
		$this->assertSame( $vars['second'], $template->get( 'second' ) );
		$this->assertSame( $template, $return );

	}

	public function test_should_return_variables() {

		$vars = [
			'first'  => uniqid(),
			'second' => 'test',
		];

		$template = new Template( 'test', 'test', $vars );

		$this->assertSame( $vars, $template->get_vars() );

	}

	public function test_should_remove_var() {

		$vars = [
			'test' => uniqid(),
		];

		$template = new Template( 'test', 'test', $vars );

		$template->remove( 'test' );

		$this->assertNull( $template->get( 'test' ) );

	}

	public function test_should_clear_all_vars() {

		$vars = [
			'first'  => uniqid(),
			'second' => 'test',
		];

		$template = new Template( 'test', 'test', $vars );

		$template->clear_vars();

		$this->assertSame( [], $template->get_vars() );

	}

	public function test_should_render_template_with_no_variables() {

		$template = new Template( 'test', 'assets/template-no-var' );

		$this->expectOutputString( 'Template test' );
		$template->render();

	}

	public function test_should_render_template_with_this_variable() {

		$vars = [
			'var' => uniqid(),
		];

		$template = new Template( 'test', 'assets/template-this-var', $vars );

		$this->expectOutputString( sprintf( 'This is my var: %s', $vars['var'] ) );
		$template->render();

	}

	public function test_should_render_template_with_closure_variable() {

		$vars = [
			'var' => uniqid(),
		];

		$template = new Template( 'test', 'assets/template-closure-var', $vars );

		$this->expectOutputString( sprintf( 'This is my var: %s', $vars['var'] ) );
		$template->render();

	}

	public function test_should_output_template() {

		$template = new Template( 'test', 'assets/template-no-var' );

		$this->assertSame( 'Template test', $template->output() );

	}

	/**
	 * @expectedException Micropackage\Templates\Exceptions\TemplateException
	 */
	public function test_should_throw_exception_if_template_not_found() {
		$template = new Template( 'test', 'not-existing' );
		$template->render();
	}

	/**
	 * @expectedException Micropackage\Templates\Exceptions\StorageException
	 */
	public function test_should_throw_exception_if_storage_not_found() {
		$template = new Template( 'no-storage', 'assets/template-no-var' );
		$template->render();
	}

}
