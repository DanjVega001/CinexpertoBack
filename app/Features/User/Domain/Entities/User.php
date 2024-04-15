<?php

namespace App\Features\User\Domain\Entities;

use App\Models\Rank;
use App\Models\User as ModelsUser;
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

    public function getUltimateNameRank(ModelsUser $user):string
    {
        return count($user->ranks)!=0 ? $user->ranks[count($user->ranks)-1]->nameRank : "Sin rango";
    }

    public function ranksUser(ModelsUser $user):array
    {
        $ranksUserIDS = array();
        foreach ($user->ranks as $urk) {
            array_push($ranksUserIDS, $urk->id);
        }

        $ranksUser=array();
        foreach (Rank::all() as $rank) {
            $rank->obtained = in_array($rank->id, $ranksUserIDS);
            array_push($ranksUser, $rank);
        }
        return $ranksUser;
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