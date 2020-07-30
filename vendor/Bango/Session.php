<?php

namespace Bango;

/**
 * Session class - create dynamic sessions and store information.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class Session
{

    /**
     * Initialize a browser session.
     *
     * @return void
     */
    public static function start()
    {
        session_start();
    }

    /**
     * Destroy an active session.
     *
     * @return void
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * Save a key-value pair object into session.
     *
     * @return void
     */
    public static function setObject($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieve the given key's value from session.
     *
     * @param  string $key
     * @return mixed
     */
    public static function getObject($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * Destroy a key-value pair from session.
     *
     * @param  string $key
     * @return void
     */
    public static function destroyObject($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}
