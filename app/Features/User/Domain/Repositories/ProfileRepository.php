<?php
namespace App\Features\User\Domain\Repositories;

use App\Models\User;

interface ProfileRepository{

    public function getUser(?int $userID):User;

    public function getProfile(?int $userID):array;

    public function getAllUsers():mixed;

    public function deleteUser(int $userID);

    public function updateProfile(array $data);
    

}