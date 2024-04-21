<?php

/**
 * Autoload function to include the appropriate class file based on the provided class name.
 *
 * This function is registered with `spl_autoload_register` and is called whenever an attempt is made to instantiate
 * a class that hasn't been defined. It converts the namespace of the class to a directory structure, constructs the
 * file path based on the base directory (`BASEDIR`) and the class name, and includes the class file if it exists.
 * If the file is not found, an error is logged and an exception is thrown.
 *
 * @param string $className The fully qualified name of the class to be autoloaded.
 *
 * @throws Exception If the file corresponding to the class name is not found.
 */
spl_autoload_register(function ($className) {
	// Convert namespace to directory structure
	$className = str_replace("\\", "/", $className);

	// Construct the file path based on BASEDIR and the class name
	$filePath = BASEDIR . '/' . $className . ".php";

	// Check if the file exists before including it
	if (file_exists($filePath)) {
		include $filePath;
	} else {
		// Log the error and throw an exception instead of exiting
		error_log("File not found. Path: " . $filePath);
		throw new Exception("File not found: " . $filePath);
	}
});