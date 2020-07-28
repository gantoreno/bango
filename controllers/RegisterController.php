<?php

use \Bango\Http;
use \Bango\Router;
use \Bango\Session;
use \Bango\Controller;

class RegisterController extends Controller
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

        self::create_view("register.view");

        exit;
    }

    /**
     * Process a request and create a new user given its credentials.
     *
     * @param  object $request
     * @return void
     */
    public static function register($request)
    {
        $email = $request->email;
        $password = $request->password;
        $password_repeat = $request->password_repeat;

        if ($password !== $password_repeat)
        {
            Http::set_status(401);

            self::create_view("register.view", [
                "success" => false,
                "message" => "Passwords must match"
            ]);

            exit;
        }

        if (User::where("email", "=", $email)->one())
        {
            Http::set_status(401);

            self::create_view("register.view", [
                "success" => false,
                "message" => "User already exists"
            ]);

            exit;
        }

        $user = new User();

        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);

        if ($user->save())
        {
            unset($user->password);
    
            Session::set_object("user", $user);
            
            Http::set_status(200);
    
            Router::navigate_to("/");
    
            exit;
        }
        else
        {            
            Http::set_status(401);

            self::create_view("register.view", [
                "success" => false,
                "message" => "Something went wrong, please try again"
            ]);

            exit;
        }
    }
}
