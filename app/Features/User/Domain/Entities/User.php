<?php

namespace App\Features\User\Domain\Entities;

use Exception;

class User {
    protected $id;
    protected $name;
    protected $email;
    protected $password;

    public function __construct($name, $email, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function validateUser() {
        if (count(str_split($this->password)) < 6 || 
            preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $this->password)) {
            throw new Exception("Contraseña Invalida");
        }
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }
}