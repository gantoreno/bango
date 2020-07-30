<?php

use \Bango\Session;
use \Bango\Controller;

class ErrorController extends Controller
{

    /**
     * Render the 404 view.
     *
     * @return void
     */
    public static function handle404()
    {
        self::createView("404.view", [
            "auth" => Session::getObject("auth"),
            "user" => Session::getObject("user")
        ]);

        exit;
    }
}
