<?php

use \Bango\Http;
use \Bango\Router;
use \Bango\Session;
use \Bango\Controller;

class LoginController extends Controller
{

    /**
     * Serve a given view as entry point.
     *
     * @return void
     */
    public static function index()
    {
        $user = Session::getObject("user");

        if (isset($user)) {
            Router::navigateTo("/");
        }

        self::createView("login.view");

        exit;
    }

    /**
     * Process a request and authenticate the given user's credentials.
     *
     * @param  object $request
     * @return void
     */
    public static function login($request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where("email", "=", $email)->one();

        if ($user === null) {
            Http::setStatus(401);

            self::createView("login.view", [
                "success" => false,
                "message" => "User does not exist"
            ]);

            exit;
        }

        if (!password_verify($password, $user->password)) {
            Http::setStatus(401);

            self::createView("login.view", [
                "success" => false,
                "message" => "Wrong credentials"
            ]);

            exit;
        }

        unset($user->password);

        Session::setObject("user", $user);

        Http::setStatus(200);

        Router::navigateTo("/");

        exit;
    }
}
