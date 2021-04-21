# Changelog
All notable changes to this project will be documented in this file.

## 1.1.3

### Fixed
- PHP 7.0 compatibility

## 1.1.2

### Added
- Default value for template vars passed as the second argument to `get` and `the` methods and it's closure eqivalents

## 1.1.1

### Added
- Magic method for string converstion. Now you are able to `echo new Template()`

### Changed
- Before printing the template, the file existance is checked. If not present, the `TemplateException` is thrown
- If the storage wasn't set previously, the `StorageException` is thrown while creating new `Template` object

## 1.1.0

### Added
- Procedural helper functions

## 1.0.0

Initial release
