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
    public static function parseAction($args)
    {
        if (sizeof($args) > 1) {
            $action = $args[1];

            switch($action) {
                case 'migrate':
                    try {
                        Environment::start();
                        
                        Database::start($withDatabase = false);
                        Database::migrate();
                    } catch(Exception $e) {
                        throw $e;
                    }

                    break;
                default:
                    throw new Exception("Unknown action: $action");

                    break;
            }
        } else {
            throw new Exception("You must provide at least one argument");
        }
    }
}
