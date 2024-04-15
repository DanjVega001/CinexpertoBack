<?php
namespace App\Features\User\Domain\Repositories;

use App\Models\User;

interface ProfileRepository{

    public function getUser(?int $userID):User;

    public function getProfile(?int $userID):array;

    

}