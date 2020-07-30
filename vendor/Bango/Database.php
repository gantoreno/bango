<?php

namespace Bango;

use \mysqli;
use \Exception;

/**
 * Database class - define interactions with the database.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class Database
{

    /**
     * MySQL connection object.
     *
     * @var object
     */
    private static $mysqli;

    /**
     * Start the database.
     *
     * @return void
     */
    public static function start($with_db = true)
    {
        $db_host = Environment::readEnv("DB_HOST");
        $db_user = Environment::readEnv("DB_USER");
        $db_pass = Environment::readEnv("DB_PASS");
        $db_name = Environment::readEnv("DB_NAME");

        if ($with_db)
        {
            self::$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
        }
        else
        {
            self::$mysqli = new mysqli($db_host, $db_user, $db_pass);
        }
    }

    /**
     * Run the initial migrations.
     *
     * @return void
     */
    public static function migrate()
    {
        $migration = File::read_file("database/migration.sql");

        if (self::$mysqli->multi_query($migration))
        {
            echo "Migration successful\n";
        }
        else
        {
            throw new Exception("Something went wrong while migrating\n");
        }
    }

    /**
     * Create a new MySQLi connection and perform a query.
     *
     * @param  string $query
     * @return mixed
     */
    public static function query($query)
    {
        $result = self::$mysqli->query($query);

        if ($result->num_rows < 1)
        {
            if (self::$mysqli->affected_rows > 0)
            {
                return true;
            }

            return NULL;
        }

        return $result;
    }

    /**
     * Use the query method to retrieve all matching rows.
     *
     * @param  string $query
     * @return mixed
     */
    public static function queryAll($query)
    {
        $results = self::query($query);

        if ($results !== NULL)
        {
            $result_array = [];

            while ($result = $results->fetch_assoc())
            {
                $result_array[] = (object) $result;
            }

            return $result_array;
        }

        return NULL;
    }

    /**
     * Use the query method to retrieve a single row.
     *
     * @param  string $query
     * @return mixed
     */
    public static function querySingle($query)
    {
        $results = self::query($query);

        if ($results !== NULL)
        {
            $result_array = [];
            
            return (object) $results->fetch_assoc();
        }

        return NULL;
    }

    /**
     * Use the query method to insert a single row.
     *
     * @param  string $query
     * @return mixed
     */
    public static function insertSingle($query)
    {
        return self::query($query) !== NULL ? true : false;
    }
}
