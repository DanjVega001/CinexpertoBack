<?php
namespace App\Features\User\Domain\Repositories;


interface ProfileRepository{

    public function getProfile(?int $userID):array;

}