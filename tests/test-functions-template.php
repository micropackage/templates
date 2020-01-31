<?php
/**
 * Class TestFunctionsTemplate
 *
 * @package micropackage/templates
 */

namespace Micropackage\Templates\Test;

use Micropackage\Templates\Storage;
use function Micropackage\Templates\template;
use function Micropackage\Templates\get_template;

/**
 * Functions template test case.
 */
class TestFunctionsTemplate extends \WP_UnitTestCase {

	protected static $storage_dir = __DIR__;

	public static function setUpBeforeClass() {

		parent::setUpBeforeClass();

		try {
			Storage::add( 'test', self::$storage_dir );
		} catch ( Exceptions\StorageException $e ) {

		}

	}

	public function test_should_render_template_with_no_variables() {
		template( 'test', 'assets/template-no-var' );
		$this->expectOutputString( 'Template test' );
	}

	public function test_should_render_template_with_this_variable() {

		$vars = [
			'var' => uniqid(),
		];

		template( 'test', 'assets/template-this-var', $vars );

		$this->expectOutputString( sprintf( 'This is my var: %s', $vars['var'] ) );

	}

	public function test_should_render_template_with_closure_variable() {

		$vars = [
			'var' => uniqid(),
		];

		template( 'test', 'assets/template-closure-var', $vars );

		$this->expectOutputString( sprintf( 'This is my var: %s', $vars['var'] ) );

	}

	public function test_should_output_template() {
		$output = get_template( 'test', 'assets/template-no-var' );
		$this->assertSame( 'Template test', $output );
	}

}
