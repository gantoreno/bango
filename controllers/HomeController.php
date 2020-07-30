<?php

use \Bango\Session;
use \Bango\Controller;

class HomeController extends Controller
{

    /**
     * Serve a given view as entry point.
     *
     * @return void
     */
    public static function index()
    {
        self::createView("home.view", [
            "user" => Session::getObject("user")
        ]);

        exit;
    }
}
