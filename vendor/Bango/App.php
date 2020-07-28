<?php

namespace Bango;

/**
 * App class - application's entry point.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class App
{

    /**
     * Start the application and run initial jobs.
     *
     * @return void
     */
    public static function start()
    {
        Session::start();

        Database::start($with_db = true);

        Router::start();
    }
}
