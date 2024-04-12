<?php
namespace App\Features\User\Domain\Repositories;

use App\Features\User\Domain\Entities\User;
use App\Models\User as ModelsUser;

interface UserRepository {

    public function register(User $user);

    public function login(array $credentials):ModelsUser;

    public function logout(string $idToken);


}