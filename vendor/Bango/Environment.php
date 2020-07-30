<?php

namespace Bango;

/**
 * Environment class - pull out environment variables.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class Environment
{

    /**
     * Environment persistance.
     * 
     * @var array
     */
    private static $environment = [];

    /**
     * Read .env file and populate the environment variable.
     *
     * @return string
     */
    public static function start()
    {
        $buffer = File::readFile(".env");
        $pairs = explode("\n", $buffer);

        foreach ($pairs as $pair) {
            $keyValuePair = explode("=", $pair);

            $key = $keyValuePair[0];
            $value = $keyValuePair[1];

            self::$environment[$key] = $value;
        }
    }

    /**
     * Get a given environment variable's value.
     * 
     * @param  string $key
     * @return string
     */
    public static function readEnv($key)
    {
        return self::$environment[$key];
    }
}
