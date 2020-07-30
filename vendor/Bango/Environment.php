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
        $env_buffer = File::readFile(".env");
        $env_pairs = explode("\n", $env_buffer);

        foreach ($env_pairs as $env_pair)
        {
            $env_key_value = explode("=", $env_pair);

            $env_key = $env_key_value[0];
            $env_value = $env_key_value[1];

            self::$environment[$env_key] = $env_value;
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
