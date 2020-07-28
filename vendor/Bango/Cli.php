<?php

namespace Bango;

use \Exception;

/**
 * Cli class - command-line utilities.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class Cli
{

    /**
     * Parse CLI actions and execute them.
     *
     * @param  array $args
     * @return void
     */
    public static function parse_action($args)
    {
        if (sizeof($args) > 1)
        {
            $action = $args[1];

            switch($action)
            {
                case 'migrate':
                    try
                    {
                        Database::start($with_db = false);
                        Database::migrate();
                    }
                    catch(Exception $e)
                    {
                        throw $e;
                    }

                    break;
                default:
                    throw new Exception("Unknown action: $action");

                    break;
            }
        }
        else
        {
            throw new Exception("You must provide at least one argument");
        }
    }
}
