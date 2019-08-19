<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

namespace Tankfairies\Tframe\Model;

/**
 * Class Autoloader
 *
 * @package Codebase
 */
class Autoloader
{
    /**
     * @var array
     */
    private static $autoloadedDirectories = ['controller', 'model'];

    /**
     * Autoloader for class files in core.
     *
     * @param $className
     */
    public static function autoload($className)
    {
        if (!class_exists($className, false)) {
            $processedClassName = str_replace('Tankfairies', '', $className);
            $processedClassName = ltrim($processedClassName, '\\');
            $fileName = '';
            if ($lastNsPos = strrpos($processedClassName, '\\')) {
                $namespace = substr($processedClassName, 0, $lastNsPos);
                $processedClassName = substr($processedClassName, $lastNsPos + 1);
                $fileName = str_replace('\\', '/', $namespace) . '/';
            }
            $fileName .= $processedClassName . '.php';

            for ($i = 0, $count = count(self::$autoloadedDirectories); $i < $count; $i++) {
                $candidate = __DIR__ . "/../";

                if (stream_resolve_include_path($candidate)) {
                    self::includeFile($candidate);
                    return;
                }
            }
        }
    }

    /**
     * @param $file
     */
    public static function includeFile($file)
    {
        require_once $file;
    }
}
