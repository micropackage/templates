<?php
/**
 * Class TestStorage
 *
 * @package micropackage/templates
 */

namespace Micropackage\Templates\Test;

use Micropackage\Templates\Exceptions;
use Micropackage\Templates\Storage;

/**
 * Storage test case.
 */
class TestStorage extends \WP_UnitTestCase {

	/**
	 * @expectedException Micropackage\Templates\Exceptions\StorageException
	 */
	public function test_should_throw_exception_if_storage_already_exist() {
		Storage::add( 'test', '/tmp/test' );
		Storage::add( 'test', '/tmp/test' );
	}

	/**
	 * @expectedException Micropackage\Templates\Exceptions\StorageException
	 */
	public function test_should_throw_exception_if_path_doesnt_exist() {
		Storage::add( 'test', '/definitelt/not/exists' );
	}

	/**
	 * @expectedException Micropackage\Templates\Exceptions\StorageException
	 */
	public function test_should_throw_exception_if_path_isnt_dir() {
		Storage::add( 'test', __FILE__ );
	}

	/**
	 * @expectedException Micropackage\Templates\Exceptions\StorageException
	 */
	public function test_should_throw_exception_if_storage_not_added() {
		Storage::get( 'test' );
	}

	/**
	 * @expectedException Micropackage\Templates\Exceptions\StorageException
	 */
	public function test_should_add_and_get_storage() {
		$storage = Storage::add( 'test', '/tmp/test' );
		$this->assertSame( $storage, Storage::get( 'test' ) );
	}

}
