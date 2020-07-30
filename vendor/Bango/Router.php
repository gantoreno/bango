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
        File::requireAll("routes");

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
        $route = self::urlToRoute($route);

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
        $route = self::urlToRoute($route);

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
        $route = self::urlToRoute($route);

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
        $route = self::urlToRoute($route);

        self::$delete_routes[$route] = $callback;
    }

    /**
     * Navigate to a given url.
     *
     * @param  string $url
     * @return void
     */
    public static function navigateTo($url)
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
        $route = self::urlToRoute($_SERVER["REQUEST_URI"]);

        if ($method === "GET")
        {
            if (isset(self::$get_routes[$route]))
            {
                Http::setStatus(200);

                self::$get_routes[$route]((object) $_GET);

                exit;
            }

            Http::setStatus(404);

            ErrorController::handle404();

            exit;
        }
        else if ($method === "POST")
        {
            if (isset(self::$post_routes[$route]))
            {
                Http::setStatus(200);

                self::$post_routes[$route]((object) $_POST);

                exit;
            }
        }
        else if ($method === "PUT")
        {
            if (isset(self::$put_routes[$route])) {
                Http::setStatus(200);

                self::$put_routes[$route]((object) $_PUT);

                exit;
            }
        }
        else if ($method === "DELETE")
        {
            if (isset(self::$put_routes[$route]))
            {
                Http::setStatus(200);

                self::$put_routes[$route]((object) $_DELETE);

                exit;
            }
        }

        Http::setStatus(405);

        echo "Cannot $method /$route";

        exit;
    }

    /**
     * Receive a route and extracts the name.
     *
     * @param  string $url
     * @return string
     */
    private static function urlToRoute($url)
    {
        if (self::isValidUrl($url))
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
    private static function isValidUrl($url)
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
    private static function shouldExecuteCallback($method, $route)
    {
        return $_SERVER["REQUEST_METHOD"] === $method && $_GET["url"] === $route;
    }
}
