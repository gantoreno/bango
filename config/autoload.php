<?php

/**
 * Automatically load a referenced class.
 *
 * @return void
 */
spl_autoload_register(
    function($class_name)
    {
        $class_name = str_replace("\\", "/", $class_name);

        if (file_exists("models/$class_name.php"))
        {
            require_once "models/$class_name.php";
        }
        else if (file_exists("controllers/$class_name.php"))
        {
            require_once "controllers/$class_name.php";
        }
        else if (file_exists("vendor/$class_name.php"))
        {
            require_once "vendor/$class_name.php";
        }
    }
);
