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
    public static function handle_404()
    {
        self::create_view("404.view", [
            "auth" => Session::retrieve_object("auth"),
            "user" => Session::retrieve_object("user")
        ]);

        exit;
    }
}
