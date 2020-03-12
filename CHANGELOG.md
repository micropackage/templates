# Changelog
All notable changes to this project will be documented in this file.

## [Next]

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
