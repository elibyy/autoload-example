<?php
/**
 * this file is intend to autoload classes in a few ways
 *
 */
define('DS', DIRECTORY_SEPARATOR);
/**
 * PSR-4 autoloader is intend to load only specified namespaces
 * so you need to
 * 1. init the loader
 * 2. register the loader
 * 3. register namespaces with absolute path
 */
require_once 'Psr4Autoloader.php';
$loader = new Psr4Autoloader();
$loader->register();
$loader->addNamespace('Elibyy\General\\', dirname(__FILE__) . DS . 'src' . DS . 'Elibyy' . DS . 'General');
/**
 * this is a simple autoload in my format that still uses class PSR-0 locations
 * so The class \Foo\Bar will be in Foo/Bar.php
 * but this function validates file existant
 * @param string $class the class name to autoload
 *
 * @return mixed|bool returns the file contents if found or false
 */
function autoload($class)
{
    $class = str_replace('\\', DS, $class);
    $filename = $class . '.php';
    $filePath = dirname(__FILE__) . DS . 'src' . DS . $filename;
    if (file_exists($filePath)) {
        /** @noinspection PhpIncludeInspection */
        return require_once $filePath;
    }
    return false;
}

spl_autoload_register('autoload');
/**
 * inner function is autoloading classes in custom format but still uses PSR-0 locations
 * so The class \Foo\Bar will be in Foo/Bar.class.php
 */
spl_autoload_register(function ($class){
    $class = str_replace('\\', DS, $class);
    $filename = $class . '.class.php';
    $filePath = dirname(__FILE__) . DS . 'src' . DS . $filename;
    if (file_exists($filePath)) {
        /** @noinspection PhpIncludeInspection */
        return require_once $filePath;
    }
    return false;
});
/**
 * this function is loading classes in PSR-0 style
 * so The class \Foo\Bar will be in Foo/Bar.php
 * @param string $className the class name to autoload
 *
 * @since 1.0
 */
function autoloadPsr0($className)
{
    $className = ltrim($className, '\\');
    $fileName = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    /** @noinspection PhpIncludeInspection */
    require $fileName;
}

spl_autoload_register('autoloadPsr0');