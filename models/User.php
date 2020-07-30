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
        $this->bindEntity("users");
        $this->createFields([
            "id" => "integer", 
            "email" => "string", 
            "password" => "string"
        ]);
    }
}
