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
    private $is_insertable = true;

    /**
     * Creates the fillable fields as variables.
     * 
     * @param  array $variables
     * @return void
     */
    protected function create_fields($variables)
    {
        foreach ($variables as $variable => $type)
        {
            $this->fields[$variable] = (object) ["type" => $type];
            $this->{$variable} = NULL;
        }
    }

    /**
     * Bind a given entity name to the model.
     * 
     * @param  string $entity
     * @return void
     */
    protected function bind_entity($entity)
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
        if ($this->is_insertable) 
        {
            $query = "INSERT INTO $this->entity (";

            foreach ($this->fields as $field => $variable)
            {
                if ($this->{$field} !== NULL)
                {
                    $query .= "$field, ";
                } 
            }

            $query = substr($query, 0, -2);
            $query .= ") VALUES (";

            foreach ($this->fields as $field => $variable)
            {
                if ($this->{$field} !== NULL)
                {
                    $value = $this->{$field};

                    if (gettype($value) !== $variable->type)
                    {
                        throw new Exception("$field must be of type $type");

                        exit;
                    }

                    if ($variable->type === "integer")
                    {
                        $query .= "$value, ";
                    }
                    else
                    {
                        $query .= "'$value', ";
                    }
                } 
            }

            $query = substr($query, 0, -2);
            $query .= ")";
            
            Database::insert_single($query);
        }
    }

    /**
     * Update a model's data into the database.
     * 
     * @return void
     */
    public function update()
    {
        if (!$this->is_insertable)
        {
            $query = "UPDATE $this->entity SET ";

            foreach ($this->fields as $field => $variable)
            {
                if ($this->{$field} !== NULL)
                {
                    $value = $this->{$field};

                    if (gettype($value) !== $variable->type)
                    {
                        throw new Exception("$field must be of type $type");

                        exit;
                    }

                    if ($variable->type === "integer")
                    {
                        $query .= "$field = $value, ";
                    }
                    else
                    {
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
        if (!$this->is_insertable)
        {
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
        
        $result = Database::query_all($query);
        $final_array = [];
        
        foreach ($result as $entry)
        {
            $object = new $class();

            foreach($entry as $key => $value)
            {
                $type = $object->fields[$key]->type;

                if ($type === "integer")
                {
                    $object->{$key} = (integer) $value;
                }
                else if ($type === "boolean")
                {
                    $object->{$key} = (boolean) $value;
                }
                else
                {
                    $object->{$key} = $value;
                }
            }

            $object->is_insertable = false;

            $final_array[] = $object;
        }

        $options = new class($final_array) {
            public function __construct($final_array)
            {
                $this->result = $final_array;
            }

            public function one()
            {
                if (empty($this->result))
                {
                    return NULL;
                }

                return $this->result[0];
            }

            public function all()
            {
                if (empty($this->result))
                {
                    return NULL;
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

        
        $result = Database::query_all($query);
        $final_array = [];
        
        foreach ($result as $entry)
        {
            $object = new $class();

            foreach($entry as $key => $value)
            {
                $object->{$key} = $value;
            }

            $object->is_insertable = false;

            $final_array[] = $object;
        }
        
        return $final_array;
    }
}