<?php

namespace Bango;

/**
 * Controller class - set initial controller built-in properties.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class Controller
{

    /**
     * Render a view file to the client and pass variables to it.
     *
     * @param  string $view_name
     * @param  array  $variables
     * @return void
     */
    public static function create_view($view_name, $variables = NULL)
    {
        if ($variables !== NULL)
        {
            extract($variables, EXTR_PREFIX_SAME, "wddx");
        }

        ob_start();

        require_once "views/$view_name.php";

        echo ob_get_clean();
    }
}
