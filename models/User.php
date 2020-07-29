<?php

use Bango\Model;
use Bango\Database;

class User extends Model
{

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bind_entity("users");
        $this->create_fields([
            "id" => "integer", 
            "email" => "string", 
            "password" => "string"
        ]);
    }
}
