<?php

/**
 * Automatically load a referenced class.
 *
 * @return void
 */
spl_autoload_register(
    function($className)
    {
        $className = str_replace("\\", "/", $className);

        if (file_exists("models/$className.php")) {
            require_once "models/$className.php";
        } elseif (file_exists("controllers/$className.php")) {
            require_once "controllers/$className.php";
        } elseif (file_exists("vendor/$className.php")) {
            require_once "vendor/$className.php";
        }
    }
);
