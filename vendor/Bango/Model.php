<?php

namespace Bango;

use \User;

/**
 * Model class - blueprints database objects.
 *
 * @package Bango
 * @author  Gabriel Moreno <gamoreno@urbe.edu.ve>
 */
class Model
{

    /**
     * The corresponding database entity.
     * 
     * @var string
     */
    private $entity;

    /**
     * The corresponding entity fields.
     * 
     * @var array
     */
    private $fields = [];

    /**
     * Define if the object is is_insertable.
     * 
     * @var mixed
     */
    private $isInsertable = true;

    /**
     * Creates the fillable fields as variables.
     * 
     * @param  array $variables
     * @return void
     */
    protected function createFields($variables)
    {
        foreach ($variables as $variable => $type) {
            $this->fields[$variable] = (object) ["type" => $type];
            $this->{$variable} = null;
        }
    }

    /**
     * Bind a given entity name to the model.
     * 
     * @param  string $entity
     * @return void
     */
    protected function bindEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Save a model's data into the database.
     * 
     * @return void
     */
    public function save()
    {
        if ($this->isInsertable) {
            $query = "INSERT INTO $this->entity (";

            foreach ($this->fields as $field => $variable) {
                if ($this->{$field} !== null) {
                    $query .= "$field, ";
                } 
            }

            $query = substr($query, 0, -2);
            $query .= ") VALUES (";

            foreach ($this->fields as $field => $variable) {
                if ($this->{$field} !== null) {
                    $value = $this->{$field};

                    if (gettype($value) !== $variable->type) {
                        throw new Exception("$field must be of type $type");

                        exit;
                    }

                    if ($variable->type === "integer") {
                        $query .= "$value, ";
                    } else {
                        $query .= "'$value', ";
                    }
                } 
            }

            $query = substr($query, 0, -2);
            $query .= ")";
            
            return Database::insertSingle($query);
        }
    }

    /**
     * Update a model's data into the database.
     * 
     * @return void
     */
    public function update()
    {
        if (!$this->isInsertable) {
            $query = "UPDATE $this->entity SET ";

            foreach ($this->fields as $field => $variable) {
                if ($this->{$field} !== null) {
                    $value = $this->{$field};

                    if (gettype($value) !== $variable->type) {
                        throw new Exception("$field must be of type $type");

                        exit;
                    }

                    if ($variable->type === "integer") {
                        $query .= "$field = $value, ";
                    } else {
                        $query .= "$field = '$value', ";
                    }
                } 
            }

            $query = substr($query, 0, -2);

            $id = get_object_vars($this)["id"];

            $query .= " WHERE id = $id";

            Database::query($query);
        }
    }

    /**
     * Delete a database info about a given model.
     * 
     * @return void
     */
    public function delete()
    {
        if (!$this->isInsertable) {
            $id = get_object_vars($this)["id"];
            $query = "DELETE FROM $this->entity WHERE id = $id";

            Database::query($query);
        }
    }

    /**
     * Find a database entry that follows a certain criteria.
     * 
     * @param  string $parameter
     * @param  string $operator
     * @param  string $value
     * @return mixed
     */
    public static function where($parameter, $operator, $value)
    {
        $class = get_called_class();
        $object = new $class();
        $entity = $object->entity;
        
        $query = "SELECT * FROM $entity WHERE $parameter $operator '$value'";
        
        $result = Database::queryAll($query);
        $finalArray = [];
        
        if ($resut !== null || !empty($result)) {
            foreach ($result as $entry) {
                $object = new $class();

                foreach($entry as $key => $value) {
                    $type = $object->fields[$key]->type;

                    if ($type === "integer") {
                        $object->{$key} = (integer) $value;
                    } elseif ($type === "boolean") {
                        $object->{$key} = (boolean) $value;
                    } else {
                        $object->{$key} = $value;
                    }
                }

                $object->isInsertable = false;

                $finalArray[] = $object;
            }
        }

        $options = new class($finalArray) {
            public function __construct($finalArray)
            {
                $this->result = $finalArray;
            }

            public function one()
            {
                if (empty($this->result)) {
                    return null;
                }

                return $this->result[0];
            }

            public function all()
            {
                if (empty($this->result)) {
                    return null;
                }

                return $this->result;
            }
        };
        
        return $options;
    }

    /**
     * Retrieve all the database entries of a given table.
     * 
     * @return mixed
     */
    public static function all()
    {
        $class = get_called_class();
        $object = new $class();
        $entity = $object->entity;
        
        $query = "SELECT * FROM $entity";

        
        $result = Database::queryAll($query);
        $finalArray = [];
        
        foreach ($result as $entry) {
            $object = new $class();

            foreach($entry as $key => $value) {
                $object->{$key} = $value;
            }

            $object->isInsertable = false;
            $finalArray[] = $object;
        }
        
        return $finalArray;
    }
}