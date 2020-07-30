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
        $user = Session::getObject("user");

        if (isset($user))
        {
            Router::navigateTo("/");
        }

        self::createView("register.view");

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
        $passwordRepeat = $request->passwordRepeat;

        if ($password !== $passwordRepeat)
        {
            Http::setStatus(401);

            self::createView("register.view", [
                "success" => false,
                "message" => "Passwords must match"
            ]);

            exit;
        }

        if (User::where("email", "=", $email)->one())
        {
            Http::setStatus(401);

            self::createView("register.view", [
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
    
            Session::setObject("user", $user);
            
            Http::setStatus(200);
    
            Router::navigateTo("/");
    
            exit;
        }
        else
        {            
            Http::setStatus(401);

            self::createView("register.view", [
                "success" => false,
                "message" => "Something went wrong, please try again"
            ]);

            exit;
        }
    }
}
