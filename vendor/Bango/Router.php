<?php

namespace Bango;

use \ErrorController;

/**
 * Router class - process, handle, and navigate based on requests.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class Router
{

    /**
     * GET routes.
     *
     * @var array
     */
    public static $get_routes = [];

    /**
     * POST routes.
     *
     * @var array
     */
    public static $post_routes = [];

    /**
     * PUT routes.
     *
     * @var array
     */
    public static $put_routes = [];

    /**
     * DELETE routes.
     *
     * @var array
     */
    public static $delete_routes = [];

    /**
     * Require all the available route files and start.
     *
     * @return void
     */
    public static function start()
    {
        File::require_all("routes");

        self::route();
    }

    /**
     * Register a GET method route.
     *
     * @param  string $route
     * @param  string $callback
     * @return void
     */
    public static function get($route, $callback)
    {
        $route = self::url_to_route($route);

        self::$get_routes[$route] = $callback;
    }

    /**
     * Register a POST method route.
     *
     * @param  string $route
     * @param  string $callback
     * @return void
     */
    public static function post($route, $callback)
    {
        $route = self::url_to_route($route);

        self::$post_routes[$route] = $callback;
    }

    /**
     * Register a PUT method route.
     *
     * @param  string $route
     * @param  string $callback
     * @return void
     */
    public static function put($route, $callback)
    {
        $route = self::url_to_route($route);

        self::$put_routes[$route] = $callback;
    }

    /**
     * Register a DELETE method route.
     *
     * @param  string $route
     * @param  string $callback
     * @return void
     */
    public static function delete($route, $callback)
    {
        $route = self::url_to_route($route);

        self::$delete_routes[$route] = $callback;
    }

    /**
     * Navigate to a given url.
     *
     * @param  string $url
     * @return void
     */
    public static function navigate_to($url)
    {
        header("Location: $url");
    }

    /**
     * Receive and handle a given request.
     *
     * @param  string $url
     * @return void
     */
    public static function route()
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $route = self::url_to_route($_SERVER["REQUEST_URI"]);

        if ($method === "GET")
        {
            if (isset(self::$get_routes[$route]))
            {
                Http::set_status(200);

                self::$get_routes[$route]((object) $_GET);

                exit;
            }

            Http::set_status(404);

            ErrorController::handle_404();

            exit;
        }
        else if ($method === "POST")
        {
            if (isset(self::$post_routes[$route]))
            {
                Http::set_status(200);

                self::$post_routes[$route]((object) $_POST);

                exit;
            }
        }
        else if ($method === "PUT")
        {
            if (isset(self::$put_routes[$route])) {
                Http::set_status(200);

                self::$put_routes[$route]((object) $_PUT);

                exit;
            }
        }
        else if ($method === "DELETE")
        {
            if (isset(self::$put_routes[$route]))
            {
                Http::set_status(200);

                self::$put_routes[$route]((object) $_DELETE);

                exit;
            }
        }

        Http::set_status(405);

        echo "Cannot $method /$route";

        exit;
    }

    /**
     * Receive a route and extracts the name.
     *
     * @param  string $url
     * @return string
     */
    private static function url_to_route($url)
    {
        if (self::is_valid_url($url))
        {
            if ($url === "/")
            {
                return "index.php";
            }

            return ltrim($url, $url[0]);
        }
    }

    /**
     * Receive a route and extracts the name.
     *
     * @param  string $url
     * @return void
     */
    private static function is_valid_url($url)
    {
        return $url[0] === "/";
    }

    /**
     * Check if the current site location allows the callback to be executed.
     *
     * @param  string  $method
     * @param  string  $route
     * @return boolean
     */
    private static function should_execute_callback($method, $route)
    {
        return $_SERVER["REQUEST_METHOD"] === $method && $_GET["url"] === $route;
    }
}
