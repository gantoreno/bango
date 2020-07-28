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
     * Read .env file and retrieve the given key's value.
     *
     * @param  string $key
     * @return string
     */
    public static function read_env($key)
    {
        $env_buffer = File::read_file(".env");
        $env_pairs = explode("\n", $env_buffer);

        foreach ($env_pairs as $env_pair)
        {
            $env_key_value = explode("=", $env_pair);

            $env_key = $env_key_value[0];
            $env_value = $env_key_value[1];

            if ($env_key === $key)
            {
                return $env_value;
            }
        }

        return null;
    }
}
