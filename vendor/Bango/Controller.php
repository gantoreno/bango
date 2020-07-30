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
    public static function createView($viewName, $variables = null)
    {
        if ($variables !== null) {
            extract($variables, EXTR_PREFIX_SAME, "wddx");
        }

        ob_start();

        require_once "views/$viewName.php";

        echo ob_get_clean();
    }
}
