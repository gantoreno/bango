<?php

namespace Bango;

use \Exception;
use \RecursiveIteratorIterator;
use \RecursiveDirectoryIterator;

/**
 * File class - folder structure manipulation.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class File
{

    /**
     * Read the given file and return its content.
     *
     * @param  string $file
     * @return string
     */
    public static function read_file($file)
    {
        try
        {
            $buffer = file_get_contents($file);

            return $buffer;
        }
        catch (Exception $e)
        {
            die("Unable to read $file");
        }
    }

    /**
     * Require a specific file given its path.
     *
     * @param  string $path
     * @return void
     */
    function require_one($path)
    {
        require_once $path;
    }

    /**
     * Recursively require all files in the given path.
     *
     * @param  string $path
     * @return void
     */
    public static function require_all($path)
    {
        $dir = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($dir);

        foreach ($iterator as $file)
        {
            $file_name = $file->getFilename();

            if (preg_match('%\.php$%', $file_name))
            {
                require_once $file->getPathname();
            }
        }
    }
}
