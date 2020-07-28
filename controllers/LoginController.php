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
        $user = Session::retrieve_object("user");

        if (isset($user))
        {
            Router::navigate_to("/");
        }

        self::create_view("login.view");

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

        if ($user === NULL)
        {
            Http::set_status(401);

            self::create_view("login.view", [
                "success" => false,
                "message" => "User does not exist"
            ]);

            exit;
        }

        if (!password_verify($password, $user->password))
        {
            Http::set_status(401);

            self::create_view("login.view", [
                "success" => false,
                "message" => "Wrong credentials"
            ]);

            exit;
        }

        unset($user->password);

        Session::set_object("user", $user);

        Http::set_status(200);

        Router::navigate_to("/");

        exit;
    }
}
