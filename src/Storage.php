<?php
/**
 * Templates storage class
 *
 * @package micropackage/templates
 */

namespace Micropackage\Templates;

use Micropackage\Filesystem\Filesystem;
use Micropackage\Templates\Exceptions\StorageException;

/**
 * Storage class
 */
class Storage {

	/**
	 * Storages
	 *
	 * @var array
	 */
	private static $storages = [];

	/**
	 * Adds new storage
	 *
	 * @throws StorageException When storage with given name already exists.
	 * @throws StorageException When storage base path doesn't exist or is not a dir.
	 * @since  1.0.0
	 * @param  string $name      Storage reference name.
	 * @param  string $base_path Storage base absolute path.
	 * @return Storage
	 */
	public static function add( $name, $base_path ) {

		if ( isset( self::$storages[ $name ] ) ) {
			throw new StorageException( sprintf( 'Storage %s already exists', $name ) );
		}

		$fs = new Filesystem( $base_path );

		if ( ! $fs->exists() || ! $fs->is_dir() ) {
			throw new StorageException( sprintf( 'Storage %s base path: %s must exists and be a directory', $name, $base_path ) );
		}

		self::$storages[ $name ] = $fs;

		return self::$storages[ $name ];

	}

	/**
	 * Gets storage
	 *
	 * @throws StorageException When storage is not found.
	 * @since  1.0.0
	 * @param  string $name Storage reference name.
	 * @return Storage
	 */
	public static function get( $name ) {

		if ( ! isset( self::$storages[ $name ] ) ) {
			throw new StorageException( sprintf( 'Storage %s does not exist', $name ) );
		}

		return self::$storages[ $name ];

	}

}
