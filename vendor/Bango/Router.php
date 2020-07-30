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
    public static $getRoutes = [];

    /**
     * POST routes.
     *
     * @var array
     */
    public static $postRoutes = [];

    /**
     * PUT routes.
     *
     * @var array
     */
    public static $putRoutes = [];

    /**
     * DELETE routes.
     *
     * @var array
     */
    public static $deleteRoutes = [];

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

        self::$getRoutes[$route] = $callback;
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

        self::$postRoutes[$route] = $callback;
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

        self::$putRoutes[$route] = $callback;
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

        self::$deleteRoutes[$route] = $callback;
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

        if ($method === "GET") {
            if (isset(self::$getRoutes[$route])) {
                Http::setStatus(200);

                self::$getRoutes[$route]((object) $_GET);

                exit;
            }

            Http::setStatus(404);

            ErrorController::handle404();

            exit;
        } elseif ($method === "POST") {
            if (isset(self::$postRoutes[$route])) {
                Http::setStatus(200);

                self::$postRoutes[$route]((object) $_POST);

                exit;
            }
        } elseif ($method === "PUT") {
            if (isset(self::$putRoutes[$route])) {
                Http::setStatus(200);

                self::$putRoutes[$route]((object) $_PUT);

                exit;
            }
        } elseif ($method === "DELETE") {
            if (isset(self::$putRoutes[$route])) {
                Http::setStatus(200);

                self::$putRoutes[$route]((object) $_DELETE);

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
        if (self::isValidUrl($url)) {
            if ($url === "/") {
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
