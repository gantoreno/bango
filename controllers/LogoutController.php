<?php

use \Bango\Http;
use \Bango\Router;
use \Bango\Session;
use \Bango\Controller;

class LogoutController extends Controller
{
    /**
     * Sign out the current user.
     *
     * @return void
     */
    public static function logout()
    {
        Session::destroyObject("user");

        Http::setStatus(200);

        Router::navigateTo("/");
    }
}
